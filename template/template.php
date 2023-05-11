<!DOCTYPE html>
<html lang="fr">
<?php
include('../db.php');
$now = date('Y-m-d');


$count_final = 0;

?>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>IGS MANAGEMENT</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard_employeur.php"><i class="fa fa-dashboard">&nbsp;&nbsp;</i>Dashboard</a>
                </li>

                <li>
                    <a href="liste_employe.php"><i class="fa fa-list">&nbsp;&nbsp;</i>Liste des employés</a>
                </li>

                <li>
                    <a href="planning.php"><i class="fa fa-calendar">&nbsp;&nbsp;</i>Planning</a>
                </li>

                <!-- <li>
                    <a href="./note_service.php"><i class="fa fa-check">&nbsp;&nbsp;</i>note de service</a>
                </li> -->

                <!-- <li>
                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;Recrutement</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">

                        <li>
                            <a href="recrutement.php"><i class="fa fa-briefcase">&nbsp;&nbsp;</i>Messagerie de Recrutement</a>
                        </li>
                        <li>
                            <a href="./offre_emploi.php"><i class="fa fa-suitcase" aria-hidden="true"></i>&nbsp;&nbsp;</i>Offre d'emploi</a>
                        </li>
                    </ul>
                </li> -->

                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-envelope-open">&nbsp;&nbsp;</i>Messagerie</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="../employeur/mailing.php"><i class="fa fa-envelope">&nbsp;&nbsp;</i>Messagerie</a>

                        </li>
                        <li>
                            <a href="../employeur/messagerie.php"><i class="fa fa-comments">&nbsp;&nbsp;</i>Salons de la société</a>
                        </li>

                    </ul>

                </li>
                <!-- <li>
                    <a href="#pageSubmen" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bars">&nbsp;&nbsp;</i>Vacation de site</a>
                    <ul class="collapse list-unstyled" id="pageSubmen">
                        <li>
                            <a href="./rapport_service.php"><i class="fa fa-info-circle"></i>&nbsp;</i>Rapport de prise de service</a>
                        </li>
                        <li>
                            <a href="./rapport_evaluation.php"><i class="fa fa-info-circle"></i>&nbsp;</i>Rapport des évaluations</a>
                        </li>

                    </ul>

                </li> -->
                <!-- <li>
                    <a href="#pageSubmen_2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-recycle"></i>&nbsp;&nbsp;</i>Recyclage</a>
                    <ul class="collapse list-unstyled" id="pageSubmen_2">
                        <li>
                            <a href="./bon_recyclage.php"><i class="fa fa-file-o" aria-hidden="true"></i>&nbsp;</i>Bon de recyclage</a>
                        </li>
                        <li>
                            <a href="./recyclage.php"><i class="fa fa-table" aria-hidden="true"></i>&nbsp;</i>Tableau de recyclage</a>
                        </li>

                    </ul>

                </li> -->

            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="../logout.php" class="download"><i class="fa fa-sign-out">&nbsp;&nbsp;</i>Déconnexion</a>
                </li>

            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fa fa-align-left"></i>
                        <span>Menu</span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto mr-2">

                            <li class="nav-item dropleft">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i><span class="badge badge-danger" id="count"><?php echo $count_final; ?></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                    if ($count_final > 0) {
                                        while ($sql_fetch = mysqli_fetch_assoc($sql_query)) {
                                            echo ' <a class="dropdown-item text-primary font-weight-bold" href="poste_service_stat.php?id=' . $sql_fetch['id'] . '"><i class="fa fa-dot-circle-o">&nbsp;&nbsp;</i>' . $sql_fetch['nom'] . " " . $sql_fetch['prenom'] . " | " . $sql_fetch['statut_service'] . '</a>';
                                        }
                                        while ($sql_fetch_1 = mysqli_fetch_assoc($sql_2_query)) {
                                            echo ' <a class="dropdown-item text-warning font-weight-bold" href="./vacation_stat.php?id=' . $sql_fetch_1['id'] . '"><i class="fa fa-dot-circle-o">&nbsp;&nbsp;</i>' . $sql_fetch_1['nom'] . " " . $sql_fetch_1['prenom'] . " | " . "Vacation Journalière " . '</a>';
                                        }
                                        while ($sql_fetch_2 = mysqli_fetch_assoc($sql_3_query)) {
                                            echo ' <a class="dropdown-item text-info font-weight-bold" href="./evaluation_vacation_stat.php?id=' . $sql_fetch_2['id'] . '"><i class="fa fa-dot-circle-o">&nbsp;&nbsp;</i>' . $sql_fetch_2['nom'] . " " . $sql_fetch_2['prenom'] . " | " . "Évaluation Vacation Journalière" . '</a>';
                                        }
                                    } else {
                                        echo ' <a class="dropdown-item text-danger font-weight-bold" href="#"><i class="fa fa-frown-o">&nbsp;&nbsp;</i>désolé ! pas de messages</a>';
                                    }
                                    ?>
                                </div>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="#" style="font-weight: bold;"><i class="fa fa-user">&nbsp;&nbsp;</i>Manager</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>