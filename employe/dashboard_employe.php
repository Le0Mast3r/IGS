<?php
include '../db.php';
session_start();

$email = $_SESSION['email'];

$sql = "SELECT * FROM t_employe WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_employe.php');
    exit();
}

?>

<?php include('../template_employe/sidebar.php'); ?>
<?php
$sql = "SELECT * FROM t_employe WHERE email='$email' LIMIT 1";
$request = mysqli_query($conn, $sql);
$employe = mysqli_fetch_assoc($request);
?>



<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?php echo $employe['nom'] . " " . $employe['prenom']; ?></h5>
</div>
<div class="modal-body">
    <section style="background-color: #eee;">
        <div class="container py-5">


            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../img/database_image/<?php echo $employe['photo'];  ?> " alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"></h5>
                            <p class="text-muted mb-1"><?php echo $employe['nom'] . " " . $employe['prenom']; ?></p>
                            <p class="text-muted mb-4"><?php echo $employe['statut'] . " | " . $employe['service']; ?></p>

                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <img src="../img/image-qrcode.png" class="img-thumbnail">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nom complet</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['nom'] . " " . $employe['prenom']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Age</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php
                                                                $date_aujordhui = date("Y-m-d");
                                                                $date_de_naissance_format = date("Y-m-d", strtotime($employe['date_de_naissance']));


                                                                $age = date_diff(date_create($date_de_naissance_format), date_create($date_aujordhui));
                                                                echo $age->format('%y'); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Date de naissance</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['date_de_naissance']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Adresse</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['adresse']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">code postal</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['code_postal']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Ville</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['ville']; ?></p>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Statut</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['statut']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Contrat</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['contrat']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">date d'embauche</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['date_embauche']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Date fin contrat</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php if ($employe['date_fin_contrat']) {
                                                                    echo $employe['date_fin_contrat'];
                                                                } else {
                                                                    echo "contrat non déterminé";
                                                                } ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Service</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['service']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Echelon</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-body mb-0"><?php echo $employe['echelon']; ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
</section>



</div>

</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</html>