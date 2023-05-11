<?php
include('../db.php');
$now = date('Y-m-d');

$count =0;
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
                    <a href="./dashboard_client.php"><i class="fa fa-user">&nbsp;&nbsp;&nbsp;</i>Information</a>
                </li>

                <li>
                    <a href="../client/trambinoscope.php"><i class="fa fa-plus">&nbsp;&nbsp;</i>Trombinoscope</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-envelope">&nbsp;&nbsp;</i>Messagerie</a>
                </li>
                <li>
                    <a href="../client/rapport_ronde.php"><i class="fa fa-pied-piper" aria-hidden="true"></i>
                        &nbsp;&nbsp;</i>Rapport de Ronde & Avis</a>
                </li>

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
                                    <i class="fa fa-bell"></i><span class="badge badge-danger" id="count"><?php echo $count; ?></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    
                                </div>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="#" style="font-weight: bold;"><i class="fa fa-user">&nbsp;&nbsp;</i>Client</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>