<?php
include '../db.php';
session_start();

$email = $_SESSION['email'];
$errors = $sucess = "";

$sql = "SELECT * FROM t_employeur WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_employeur.php');
    exit();
}

if (isset($_POST['envoyerMessage'])) {
    $message = $_POST['ecrireMessage'];
    $sql = "INSERT INTO t_messagerie(message,id_employeur) VALUES('$message','1')";
    $result = mysqli_query($conn, $sql);
    header('../dashboard_employeur.php');
} else {
    $errors = "Erreur d'envoyer le message!";
}

$now = date('Y-m-d');



$count_final = 0;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

        body {
            font-family: 'Poppins', sans-serif;
            background: #fafafa;
        }

        p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            color: #999;
        }

        a,
        a:hover,
        a:focus {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-btn {
            box-shadow: none;
            outline: none !important;
            border: none;
        }

        #navbarDropdown {
            background-color: #F8F9FA;
            ;
        }

        .line {
            width: 100%;
            height: 1px;
            border-bottom: 1px dashed #ddd;
            margin: 40px 0;
        }

        /* ---------------------------------------------------
SIDEBAR STYLE
----------------------------------------------------- */

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #32be8f;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #32be8f;
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #32be8f;
        }


        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }

        #sidebar ul li a:hover {
            color: #32be8f;
            background: #fff;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: #fff;
            background: #32be8f;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        .dropdown-toggle::after {
            display: block;
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }

        ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: #32be8f;
        }

        ul.CTAs {
            padding: 20px;
        }

        ul.CTAs a {
            text-align: center;
            font-size: 0.9em !important;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        a.download {
            background: #fff;
            color: #32be8f;
        }

        a.article,
        a.article:hover {
            background: #32be8f !important;
            color: #fff !important;
        }

        /* ---------------------------------------------------
CONTENT STYLE
----------------------------------------------------- */

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* ---------------------------------------------------
MEDIAQUERIES
----------------------------------------------------- */

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #sidebarCollapse span {
                display: none;
            }
        }

        body {
            background-color: #f4f7f6;
            /* margin-top: 20px; */
        }

        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        .chat-app .people-list {
            width: 300px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;

            z-index: 7
        }

        .chat-app .chat {
            margin-left: 290px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 85px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .my-message {
            background: #efefef
        }

        .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #efefef;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .other-message {
            background: #e8f1f3;
            text-align: right
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #e8f1f3;
            left: 93%
        }

        .chat .chat-message {
            padding: 20px
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }

        #count {
            border-radius: 50%;
            position: relative;
            top: -12px;
            left: -8px;
        }
    </style>

</head>

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
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-envelope">&nbsp;&nbsp;</i>Messagerie</a>
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
                            <a href="./rapport_service.php"><i class="fa fa-bell">&nbsp;</i>Rapport de prise de service</a>
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
            <!-- table-->
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card chat-app">
                            <div id="plist" class="people-list">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Chercher un employeur">
                                </div>
                                <ul class="list-unstyled chat-list mt-2 mb-0">
                                    <?php
                                    $sql = "SELECT * FROM t_employeur";
                                    if ($result = mysqli_query($conn, $sql)) :
                                        while ($row = mysqli_fetch_assoc($result)) :

                                    ?>
                                            <li class="clearfix">

                                                <img src="../img/database_image/<?php echo $row['photo'] ?>" alt="avatar" class="img-thumbnail">
                                                <div class="about">
                                                    <div class="name"><?php echo $row['nom'] . " " . $row['prenom'] ?></div>
                                                    <div class="status"> <i class="fa fa-circle offline"></i> Offline </div>
                                                </div>

                                            </li>
                                    <?php
                                        endwhile;
                                        mysqli_free_result($result);
                                    endif;
                                    ?>
                                    <li class="clearfix active">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                        <div class="about">
                                            <div class="name">Aiden Chavez</div>
                                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="chat">

                                <div class="chat-header clearfix">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                            </a>
                                            <div class="chat-about">
                                                <h6 class="m-b-0">Aiden Chavez</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 hidden-sm text-right">
                                            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-history">
                                    <ul class="m-b-0">
                                        <li class="clearfix">
                                            <div class="message-data text-right">
                                                <span class="message-data-time">16:10 , Hier</span>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                            </div>
                                            <div class="message other-message float-right"> Salut Aiden, comment vas-tu ? Comment avance le projet ? </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:12 , Aujourd'hui</span>
                                            </div>
                                            <div class="message my-message">Sommes-nous réunis aujourd'hui ?</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:15 , Aujourd'hui</span>
                                            </div>
                                            <div class="message my-message">Le projet est déjà terminé et j'ai des résultats à vous montrer.</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="chat-message clearfix">
                                    <form action="./messagerie.php" method="post">
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <button type="submit" name="envoyerMessage" class="input-group-text"><i class="fa fa-send"></i></button>
                                            </div>
                                            <input type="text" name="ecrireMessage" class="form-control" placeholder="Ecrire un message...">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</html>