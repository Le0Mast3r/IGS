<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <!-- Bootstrap CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <title>IGS Management</title>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style type="text/css">
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
            background: #edf1f5;
            margin-top: 0px;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid transparent;
            border-radius: 0;
        }

        .mailbox-widget .custom-tab .nav-item .nav-link {
            border: 0;
            color: #fff;
            border-bottom: 3px solid transparent;
        }

        .mailbox-widget .custom-tab .nav-item .nav-link.active {
            background: 0 0;
            color: #fff;
            border-bottom: 3px solid #fff;
        }

        .no-wrap td,
        .no-wrap th {
            white-space: nowrap;
        }

        .table td,
        .table th {
            padding: .9375rem .4rem;
            vertical-align: top;
            border-top: 1px solid rgba(120, 130, 140, .13);
        }

        .font-light {
            font-weight: 300;
        }

        table td {
            position: relative;
        }

        table td input {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            border: none;
            padding: 10px;
            box-sizing: border-box;

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
                    <a href="./dashboard_employe.php"><i class="fa fa-user">&nbsp;&nbsp;</i>Profil</a>
                </li>

                <!-- <li>
                    <a href="#"><i class="fa fa-calendar">&nbsp;&nbsp;</i>Planning</a>
                </li> -->
                <li>
                    <a href="./mailing.php"><i class="fa fa-envelope">&nbsp;&nbsp;</i>Messagerie</a>
                </li>
                <!-- <li>
                    <a href="./note_service.php"><i class="fa fa-check">&nbsp;&nbsp;</i>note de service</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-circle">&nbsp;&nbsp;</i>congés et absences</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bars">&nbsp;&nbsp;</i>Vacation de site</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="./prise_service.php"><i class="fa fa-bell">&nbsp;&nbsp;</i>Prise de service</a>

                        </li>
                        <li>
                            <a href="#"><i class="fa fa-map-pin">&nbsp;&nbsp;</i>ronde de sécurité pointé</a>

                        </li>
                        <li>
                            <a href="maincourante.php"><i class="fa fa-file">&nbsp;&nbsp;</i>Rapport / main courante</a>

                        </li>
                        <li>
                            <a href="#"><i class="fa fa-exclamation">&nbsp;&nbsp;</i>signalé un incident</a>
                        </li>

                    </ul>

                </li>

            </ul> -->

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
                            <li class="nav-item active">
                                <a class="nav-link" href="#" style="font-weight: bold;"><i class="fa fa-user">&nbsp;&nbsp;</i>Employé</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>