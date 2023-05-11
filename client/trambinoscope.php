<?php
include '../db.php';
session_start();

$email = $_SESSION['email'];

$errors = $sucess = "";

$sql = "SELECT * FROM t_client WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_client.php');
    exit();
}



?>
<?php include '../template/head.php'; ?>
<?php include '../template/template_client/sidebar.php'; ?>

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Trombinoscope du personnel de la société </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped" id="example">
                        <thead style="text-align:center;">
                            <tr>
                                <th>LOGO</th>
                                <th>Nom de la société</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">

                            <tr>
                                <td> <img src="../img/exemple_securite.png " alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                </td>
                                <td>exemple sécurité</td>
                                <td>

                                    <button class="btn btn-circle btn-dark text-white m-1" data-toggle="modal" data-target="#trombi_secu">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-circle btn-info text-white m-1" onclick="printDiv('trombi_secu')">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </button>
                                    <!-- <input type="button" class="btn btn-circle btn-info text-white m-1" onclick="printDiv('')" value="imprimer" style="margin-bottom:10px;" /> -->

                                </td>

                                <div class="modal fade bd-example-modal-xl" id="trombi_secu" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">exemple sécurité</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <img class="d-block w-100" src="../img/trombi_secu.jpg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../template/scripts.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    window.printDiv = function(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;


    }
</script>

</html>