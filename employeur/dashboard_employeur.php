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

?>
<?php include '../template/head.php'; ?>
<?php include '../template/template.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

</head>

<body>


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">content de vous revoir 🎉</h5>
                                <p class="mb-4">
                                    Visualiser vos tâches quotidiennes en temps réels<span class="fw-bold"></span>
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../img/tpiu_uu5y_220227.jpg" height="130" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../img/unicons/chart-success.png" alt="chart success" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">N° Employé</span>
                                <h3 class="card-title mb-2"><?php
                                                            $sql = "SELECT count(*) as 'count' FROM t_employe ";
                                                            $result = mysqli_query($conn, $sql);
                                                            $fetch = mysqli_fetch_assoc($result);
                                                            echo $fetch['count'];
                                                            ?></h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +15.80%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../img/unicons/chart.png" alt="Credit Card" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span>N° Client</span>
                                <h3 class="card-title text-nowrap mb-1"><?php
                                                                        $sql = "SELECT count(*) as 'count' FROM t_client ";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        $fetch = mysqli_fetch_assoc($result);
                                                                        echo $fetch['count'];
                                                                        ?></h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2">Statistique Utilisateurs</h5>
                                <span class="badge bg-label-warning rounded-pill">Année 2022</span>
                            </div>
                            <div class="mt-sm-auto">
                                <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> 68.2%</small>
                                <h3 class="mb-0">500k Membres</h3>
                                <canvas id="mixed-chart" width="800" height="450"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div> -->
    </div>


</body>
<?php include '../template/scripts.php'; ?>
<script type="text/javascript">


</script>

</html>