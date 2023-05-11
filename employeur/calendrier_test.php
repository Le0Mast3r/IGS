<?php
require_once('../db.php');
session_start();

header('Content-type: text/html; charset=utf-8');
setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
date_default_timezone_set('Europe/Paris');

$email = $_SESSION['email'];
$errors = $sucess = "";

$sql = "SELECT * FROM t_employeur WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
	header('location:login_employeur.php');
	exit();
}

if (isset($_GET['id'])) {
	$site_id = $_GET['id'];
} else {
	header('Location:planning.php');
}

$sucess = $errors = "";

if (isset($_POST['ajouter'])) {

	$nom_site = $_POST['nom_site'];
	$debut_date = $_POST['debut_date'];
	$debut_heure = $_POST['debut_heure'];
	$fin_date = $_POST['fin_date'];
	$fin_heure = $_POST['fin_heure'];
	// echo $site_id;

	$sql_check = "SELECT * FROM t_calendrier WHERE (region='$nom_site')";
	$sql_query = mysqli_query($conn, $sql_check);
	$sql_fetch = mysqli_fetch_assoc($sql_query);

	if (!$sql_fetch) {
		if (!empty($debut_date) && !empty($debut_heure) && !empty($fin_date) && !empty($fin_heure)) {
			$sql = "INSERT INTO t_calendrier(country,region,meta,datasource,site) VALUES('de','$nom_site','meta','datasource','$site_id')";
			$result = mysqli_query($conn, $sql);
			$last_id = mysqli_insert_id($conn);
			$sql_1 = "INSERT INTO t_calendrier_tmp(id,startdate,enddate,meta,timestart,timeend) VALUES('$last_id','$debut_date','$fin_date','meta','$debut_heure','$fin_heure')";
			$result_1 = mysqli_query($conn, $sql_1);
			if ($result_1 && $result) {
				$sucess = "Les informations sont ajoutés au calendrier";
			} else {
				$errors = "Erreur d'enregistrer les données";
			}
		} else {
			$errors = "Veuillez remplir tous les champs !";
		}
	} else {
		$id_emp = $sql_fetch['id'];
		$sql_update = "INSERT INTO t_calendrier_tmp(id,startdate,enddate,meta,timestart,timeend) VALUES('$id_emp','$debut_date','$fin_date','meta','$debut_heure','$fin_heure')";
		$result_update = mysqli_query($conn, $sql_update);
	}
}
if (isset($_POST['ajouter_abscence'])) {
	$nom_site = $_POST['nom_site'];
	$debut_abscence = $_POST['debut_abscence'];
	$fin_abscence = $_POST['fin_abscence'];
	// echo $site_id;

	$sql_check = "SELECT * FROM t_calendrier WHERE (region='$nom_site')";
	$sql_query = mysqli_query($conn, $sql_check);
	$sql_fetch = mysqli_fetch_assoc($sql_query);

	if (!$sql_fetch) {
		if (!empty($debut_date) && !empty($debut_heure) && !empty($fin_date) && !empty($fin_heure)) {
			$sql = "INSERT INTO t_calendrier(country,region,meta,datasource,site) VALUES('de','$nom_site','meta','datasource','$site_id')";
			$result = mysqli_query($conn, $sql);
			$last_id = mysqli_insert_id($conn);
			$sql_1 = "INSERT INTO t_calendrier_tmp(id,startdate,enddate,meta) VALUES('$last_id','$debut_abscence','$fin_abscence','meta')";
			$result_1 = mysqli_query($conn, $sql_1);
			if ($result_1 && $result) {
				$sucess = "Les informations sont ajoutés au calendrier";
			} else {
				$errors = "Erreur d'enregistrer les données";
			}
		} else {
			$errors = "Veuillez remplir tous les champs !";
		}
	} else {
		$id_emp = $sql_fetch['id'];
		$sql_update = "INSERT INTO t_calendrier_tmp(id,startdate,enddate,meta) VALUES('$id_emp','$debut_abscence','$fin_abscence','meta')";
		$result_update = mysqli_query($conn, $sql_update);
	}
}


/* REGIONS */
$result = mysqli_query($conn, "SELECT id,country,region,meta,site FROM `t_calendrier` WHERE site='$site_id'");
$regionNames = array();
$regionIDs = array();
$tArray = array();
$allDays = array();
$regionMeta = array();


/* DATE PREPARATIONS */
// http://php.net/manual/en/function.date.php
$today = date('Y-m-d');

$requYMD = $today; // makes it first of month
$startpage = true;
if (isset($_GET['m'])) {
	$requYMD = preg_replace("/[^0-9\-]/i", '', $_GET['m']) . '-01';
	$startpage = false;
}
// block hack, required yyyy-mm-dd
if (strlen($requYMD) != 10) {
	exit();
}

// get current month
$curMonthTS = strtotime($requYMD); // add 4 hours
$monthNr = date('n', $curMonthTS); // numeric representation of current month, without leading zeros
// echo strftime('%s %H:%M:%S %z %Z %a., %d. %B %Y', $curMonthTS);

// http://stackoverflow.com/questions/13346395/php-array-containing-all-dates-of-the-current-month
// number of days in the given month
$num_of_days = date('t', $curMonthTS);
$x_year = date('Y', $curMonthTS);
$x_month = date('m', $curMonthTS);
for ($i = 1; $i <= $num_of_days; $i++) {
	$dates[] = $x_year . "-" . $x_month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
}

// fill Arrays with data
while ($row = mysqli_fetch_assoc($result)) {
	$id = $row['id'];
	// write regionids to each country
	$regionIDs[$row['country']][] = $id;
	$regionMeta[$id] = $row['meta'];
	$regionNames[$id] = $row['region'];
	$regionSite = $row['site'];
	$tArray[$id] = '';
	// create all days in month as array entries
	$d = 1; // id starts with 1, we dont have an id==0
	while ($d <= $num_of_days) {
		$allDays[$id][$d] = ' ';
		$d++;
	}
}

// get all holiday periods by checking if month appears in startdate or enddate

$result = mysqli_query($conn, 'SELECT id,startdate,enddate,meta,timestart,timeend FROM `t_calendrier_tmp`

							WHERE YEAR(`startdate`) = YEAR("' . $requYMD . '")
								AND MONTH(`startdate`) = MONTH("' . $requYMD . '")
								OR
								YEAR(`enddate`) = YEAR("' . $requYMD . '")
								AND MONTH(`enddate`) = MONTH("' . $requYMD . '")
							ORDER BY `startdate`');

while ($row = mysqli_fetch_assoc($result)) {

	// first entry without leading comma
	if (@$tArray[$row['id']] == '') {
		@$tArray[$row['id']] .= $row['startdate'] . ',' . $row['enddate'] . ',' . $row['meta'] . $row['timestart'] . $row['timeend'];
		// echo $row['timestart'];
	} else {
		@$tArray[$row['id']] .= ',' . $row['startdate'] . ',' . $row['enddate'] . ',' . $row['meta'] . $row['timestart'] . $row['timeend'];
	}
}

// extra query for regions with holidays over 2 months, e.g.

$resultXX = mysqli_query($conn, 'SELECT id,startdate,enddate,meta,timestart,timeend FROM `t_calendrier_tmp`
							WHERE YEAR(`startdate`) = YEAR("' . $requYMD . '")
								AND MONTH(`startdate`) = MONTH("' . date('Y-m-d', strtotime($requYMD . ' - 1 month')) . '")
								AND
								YEAR(`enddate`) = YEAR("' . $requYMD . '")
								AND MONTH(`enddate`) = MONTH("' . date('Y-m-d', strtotime($requYMD . ' + 1 month')) . '")
							ORDER BY `startdate`');
while ($row = mysqli_fetch_assoc($resultXX)) {
	// set holiday of region to full month setting first to end of month
	@$tArray[$row['id']] = $requYMD . ',' . substr($requYMD, 0, 8) . $num_of_days . ',' . $row['meta'] . ',' . $row['startdate'] . ',' . $row['enddate'] . $row['timestart'] . $row['timeend'];
}



/* OUTPUT function */
function getAllHolidays($countryCode)
{
	// include '../db.php';
	global $dates;
	global $regionNames;
	global $regionIDs; // IDs of all regions
	global $tArray; // contains all holiday periods for each region
	global $allDays;
	global $regionMeta;
	global $today;
	global $requYMD;
	global $curMonthTS;
	global $monthNr;
	global $num_of_days;
	$allMetas = array();

	$output = '
	<table id="table_' . $countryCode . '" class="bordered">
	<tr>
		<th style="text-align:left !important;background:#FFD !important;">
		<span style="display:none;">Holidays in </span>' . strftime('%B %Y', $curMonthTS) . '
		</th>
	';

	// all number days of current month
	foreach ($dates as $day) {
		// set id for today to color the column, but only if showing this month
		$cssToday = '';
		if ($day == $today && substr($today, 5, 2) == $monthNr) {
			$cssToday = ' class="today" title="Der heutige Tag!"';
		}
		// format 2013-10-01 to 01 and remove if necessary the 0 by ltrim
		$output .= '<th' . $cssToday . '>' . ltrim(substr($day, 8, 2), '0') . '</th>'; // alternative: output $day and let JS convert the day to weekday
	}
	$regionTerm = ($countryCode == 'ch') ? 'Kantone' : 'Bundesländer';
	$output .= '
	</tr>

	<tr class="weekdays"><td><span style="display:none;">' . $regionTerm . '</span></td>';
	$wdaysMonth = array();
	// week days
	$i = 1;
	foreach ($dates as $day) {
		// echo '<td>'.date('D', strtotime($day)).'</td>';
		$weekdayName = strftime('%a', strtotime($day));
		$wkendcss = '';
		$todayWDcss = '';
		//if($weekdayName=='Sa' || $weekdayName=='So'){
		if ($day == $today) {
			$todayWDcss = 'class="activeday"';
		} else if ($weekdayName == 'So') {
			$wkendcss = 'class="wkend"';
		}
		// write day date in array field
		$wdaysMonth[$i++] = strftime('%A %e. %B %Y', strtotime($day));
		$output .= '<td  ' . $todayWDcss . $wkendcss . ' title="' . strftime('%A %e. %B %Y', strtotime($day)) . '">' . $weekdayName . '</td>';
	}

	$hasData = false;
	$output .= '
	</tr>';

	// go over all regions and display holidays

	if ($regionIDs) {

		include '../db.php';
		foreach ($regionIDs[$countryCode] as $id) {
			if (isset($_GET['id'])) {
				$site_id = $_GET['id'];
			}
			$emp = explode(' ', $regionNames[$id]);
			$sql = "SELECT DISTINCT service FROM t_employe INNER JOIN t_calendrier ON t_employe.site=t_calendrier.site WHERE t_calendrier.site='$site_id' AND nom LIKE '$emp[0]'";
			$sql_query = mysqli_query($conn, $sql);
			$sql_fetch = mysqli_fetch_assoc($sql_query);
			// 3 items in a row belong together: startdate, enddate, meta
			$regionHolidays = explode(',', $tArray[$id]);
			$output .= '<tr> <td> ' .  $regionNames[$id]  . " | " . $sql_fetch['service'] . '</td>';
			// start and end date is one loop
			$loops = count($regionHolidays);

			$i = 0;
			$entiremonthFree = false;
			while ($i < $loops) {
				/* write holiday days into month for region */
				// compare month, e.g. if 09-25 to 10-01 or 05-20 to 05-25
				$startdate_year = substr(@$regionHolidays[$i], 0, 4);
				$startdate_month = substr(@$regionHolidays[$i], 5, 2);
				$startdate_day = substr(@$regionHolidays[$i], 8, 2);
				$enddate_year = substr(@$regionHolidays[$i + 1], 0, 4);
				$enddate_month = substr(@$regionHolidays[$i + 1], 5, 2);
				$enddate_day = substr(@$regionHolidays[$i + 1], 8, 2);

				$day_start = 1;
				$day_end = $num_of_days; // 31;

				// end month outside current month, e.g. 2013-10* to 2013-11
				if (($startdate_year == $enddate_year && $monthNr < $enddate_month)) {
					// last of months
					$day_end = $num_of_days;
					// extra check for period that goes over 2 months, e.g. 31.07.2014 - 13.09.2014
					// our month to be filled is not the start or the end month but between
					if ($enddate_month - $startdate_month > 1 && $monthNr != $enddate_month && $monthNr != $startdate_month) {
						// remember that next $month is free completely
						$entiremonthFree = true;
						$output .= '###';
					}
				}
				// end month outside current month, e.g. 2013-12* to 2014-01
				else if (($startdate_year < $enddate_year && $monthNr > $enddate_month)) {
					// last of months
					$day_end = $num_of_days;
				} else {
					// set end date of given month, remove leading zero
					$day_end = ltrim(substr(@$regionHolidays[$i + 1], 8, 2), '0');
				}
				// start month outside current month, e.g. 2013-10 to 2013-11*
				if (($startdate_year == $enddate_year && $monthNr > $startdate_month)) {
					// first of month
					$day_start = 1;
				}
				// start month outside current month, e.g. 2013-12 to 2014-01*
				else if (($startdate_year < $enddate_year && $monthNr < $startdate_month)) {
					// first of months
					$day_start = 1;
				} else {
					// date of start month, remove leading zero
					$day_start = ltrim(substr($regionHolidays[$i], 8, 2), '0');
					//echo $day_start;
				}

				if ($entiremonthFree) {
					$day_end = $num_of_days;
					$day_start = 1;
				}

				// write holidays into array
				while ($day_start <= $day_end) {
					$allDays[$id][$day_start] = 'x';
					// write holiday meta into array
					$allMetas[$id][$day_start] = @$regionHolidays[$i + 2];
					$day_start++;
				}

				// jump to next data items
				$i += 3;
				$hasData = true;
			}

			$k = 0;
			foreach ($allDays[$id] as $day) {
				$k++;
				if ($day == 'x') {
					if (substr($allMetas[$id][$k], 4, 5) != '') {
						$output .= '<td class="free" style="font-size:11px;background:rgb(153, 243, 89);" title="' . @$wdaysMonth[$k] . ' ' . @$allMetas[$id][$k] . '">' . substr($allMetas[$id][$k], 4, 5) . '<br>' . substr($allMetas[$id][$k], 12, 5) .    '</td>';
					} else {
						$output .= '<td class="free" style="font-size:12px;background:rgba(238, 86, 86, 0.747);" title="' . @$wdaysMonth[$k] . ' ' . @$allMetas[$id][$k] . '">' . "AB" .    '</td>';
					}
				} else {
					$output .= '<td>' . $day . '</td>';
				}
			}
			$output .= '</tr>';
		}
	}
	$output .= '</table>';
	if (!$hasData) {
		$output = '<p>Oh non, pas de données pour cette période.</p>';
	}
	return $output;
}

// $mnthyear = strftime('%b %G', $curMonthTS);
$mnthyear = strftime('%b %Y', $curMonthTS);

?>
<link rel="stylesheet" href="../css/calendrier.css">
<?php include '../template/head.php'; ?>
<?php include '../template/template.php'; ?>

<body class="holidaysm">
	<div id="nav">
		<div id="fastaccess">
			<?php
			// LIST Nav Buttons first or last 6 months of year - according to recent date year
			$requYear = substr($requYMD, 0, 4);
			$requMonth = substr($requYMD, 5, 2);
			$monthr = $requMonth < 7 ? 1 : 7;
			$timestamp = $requYear . '-' . $monthr;

			$monthOut = array();
			$c = 0;
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp));
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp));
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp . ' +1 month')); // next month
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp . ' +1 month'));
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp . ' +2 month'));
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp . ' +2 month'));
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp . ' +3 month'));
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp . ' +3 month'));
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp . ' +4 month'));
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp . ' +4 month'));
			$monthOut[$c][0] = date('Y-m', strtotime($timestamp . ' +5 month'));
			$monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp . ' +5 month'));
			$c_out = 0;

			?>
			<a class="navpre" title="previous month" href="?m=<?php echo date('Y-m', strtotime($requYMD . ' -1 month')); ?>&id=<?php echo $site_id; ?>">&laquo;</a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a <?php echo (substr($requYMD, 0, 7) == $monthOut[$c_out][0]) ? 'class="oranged" ' : '' ?>href="?m=<?php echo $monthOut[$c_out][0]; ?>&id=<?php echo $site_id; ?>"><?php echo $monthOut[$c_out++][1]; ?></a>
			<a class="navfwd" title="next month" href="?m=<?php echo date('Y-m', strtotime($requYMD . ' +1 month')); ?>&id=<?php echo $site_id; ?>">&raquo;</a>



		</div>

		<br />
		<!-- add MODAL -->
		<div class="modal fade bd-example-modal-xl" id="ajouterModel_HEURE" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">ajouter une Heure</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
							<input type="hidden" name="site_id" value="<?php echo $site_id; ?>">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form name="ajouterForm" id="ajouterForm" action="calendrier_test.php?id=<?php echo $site_id; ?>" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label for="name">Choisir un Employe</label>
								<select class="form-select form-control" name="nom_site" aria-label="Default select example">
									<?php
									if (isset($_GET['id'])) {
										$site_id = $_GET['id'];
									}
									$sql = "SELECT * FROM t_employe WHERE site='$site_id'";
									if ($result = mysqli_query($conn, $sql)) :
										while ($row = mysqli_fetch_assoc($result)) :

									?>
											<option value="<?php echo $row['nom'] . " " . $row['prenom']; ?>"><?php echo $row['nom'] . " " . $row['prenom'] ?> </option>
									<?php
										endwhile;
										mysqli_free_result($result);
									endif;
									?>
								</select>
							</div>
							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Début</label>
								<input type="date" class="form-control" id="" name="debut_date">
							</div>
							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Heure de départ</label>
								<input type="time" class="form-control" id="" name="debut_heure">
							</div>
							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Fin</label>
								<input type="date" class="form-control" id="" name="fin_date">
							</div>
							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Heure fin</label>
								<input type="time" class="form-control" id="" name="fin_heure">
							</div>
							<button type="submit" name="ajouter" id="ajouterSubmit" class="btn btn-info text-nowrap m-1" style="color:#F6F6F6" style="background-color:#32be8f"><i class="fa fa-plus"></i>
								<span class="d-none d-lg-inline-block">&nbsp;Ajouter</span>
							</button>
						</form>
					</div>
				</div>

			</div>
		</div>
		<!-- Abscence Modal -->
		<div class="modal fade bd-example-modal-xl" id="abscence_HEURE" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Abscence</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
							<input type="hidden" name="site_id" value="<?php echo $site_id; ?>">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form name="ajouterForm" id="ajouterForm" action="calendrier_test.php?id=<?php echo $site_id; ?>" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label for="name">Choisir un Employe</label>
								<select class="form-select form-control" name="nom_site" aria-label="Default select example">
									<?php
									if (isset($_GET['id'])) {
										$site_id = $_GET['id'];
									}
									$sql = "SELECT * FROM t_employe WHERE site='$site_id'";
									if ($result = mysqli_query($conn, $sql)) :
										while ($row = mysqli_fetch_assoc($result)) :

									?>
											<option value="<?php echo $row['nom'] . " " . $row['prenom']; ?>"><?php echo $row['nom'] . " " . $row['prenom'] ?> </option>
									<?php
										endwhile;
										mysqli_free_result($result);
									endif;
									?>
								</select>
							</div>
							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Début</label>
								<input type="date" class="form-control" id="" name="debut_abscence">
							</div>

							<div class="form-outline timepicker-inline-24">
								<label class="form-label" for="form4">Fin</label>
								<input type="date" class="form-control" id="" name="fin_abscence">
							</div>

							<button type="submit" name="ajouter_abscence" id="ajouterSubmit" class="btn btn-info text-nowrap m-1"><i class="fa fa-plus"></i>
								<span class="d-none d-lg-inline-block">&nbsp;Valider</span>
							</button>
						</form>
					</div>
				</div>

			</div>
		</div>



		<div id="calholdr">
			<div class="calendar"><?php echo substr($today, 8, 2); ?><em><?php echo strftime('%b %Y', strtotime($today)); ?></em></div>
			<div id="clock"></div>
		</div>

	</div>
	<div class="card-header d-flex justify-content-between align-items-center">
		<div class="container">
			<?php if ($errors != "") : ?>
				<div class="alert alert-info alert-dismissible fade show error-alert" role="alert" id="message_id">
					<?php echo $errors; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<?php if ($sucess != "") : ?>
				<div class="alert alert-success alert-dismissible fade show error-alert" role="alert" id="message_id">
					<?php echo $sucess; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
		</div>

		<button type="button" class="btn btn-info text-nowrap m-1" data-toggle="modal" data-target="#ajouterModel_HEURE">
			<span class="d-none d-lg-inline-block"><i class="fa fa-plus-circle" aria-hidden="true"></i>
				&nbsp;Ajouter une heure</span>
		</button>

		<button type="button" class="btn btn-dark text-nowrap m-1" data-toggle="modal" data-target="#abscence_HEURE">
			<span class="d-none d-lg-inline-block"><i class="fa fa-bar-chart" aria-hidden="true"></i>
				&nbsp;Abscence</span>
		</button>
	</div>

	<div id="main">

		<div class="">

			<h5>Calendrier Pour <?php echo $mnthyear; ?></h5>

			<?php

			echo getAllHolidays('de');
			?>
		</div>





	</div>
	<?php include '../template/scripts.php'; ?>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#sidebarCollapse').on('click', function() {
				$('#sidebar').toggleClass('active');
			});
			$('.carousel').carousel({
				interval: false,
			})

			window.printDiv = function(divName) {
				var printContents = document.getElementById(divName).innerHTML;
				var originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			}
		});
		$("document").ready(function() {
			setTimeout(function() {
				$("#message_id").remove();
			}, 3000);
		});
	</script>
</body>