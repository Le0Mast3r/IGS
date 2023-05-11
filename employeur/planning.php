<?php
include '../db.php';
session_start();

$sucess = $errors = "";
$email = $_SESSION['email'];

$sql = "SELECT * FROM t_employeur WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_employeur.php');
    exit();
}

if (isset($_POST['ajouterSite'])) {
    
    $nom_site =htmlspecialchars($_POST['nom_site'],ENT_QUOTES);
    $ville = htmlspecialchars($_POST['Ville'],ENT_QUOTES);
    $id_responsable = $_POST['id_responsable'];
    if (!empty($nom_site) && !empty($ville) && !empty($id_responsable)) {
        $sql = "INSERT INTO t_site (ville,id_responsable,nom_site) VALUES('$ville','$id_responsable','$nom_site')";
        $result = mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        $sql_1 = "INSERT INTO t_calendrier(country,meta,datasource,site) VALUES('de','meta','data','$last_id')";
        $result_1 = mysqli_query($conn, $sql_1);
        if ($result && $result_1) {
            $sucess = "Les informations sont enregistrés!";
        } else {
            $errors = "Erreur d'enregistrer les données!";
        }
    } else {
        $errors = "Veuillez remplire tous les champs";
    }
}
if (isset($_POST['modifierSite'])) {
    $id = $_POST['id'];
    $nom_site = htmlspecialchars($_POST['nom_site_modifier'],ENT_QUOTES);
    $id_responsable = $_POST['id_responsable_modifier'];
    $ville = htmlspecialchars($_POST['ville_site_modifier'],ENT_QUOTES);
    if (!empty($nom_site) && !empty($id_responsable) && !empty($ville)) {

        $sql = "UPDATE t_site SET ville='$ville',id_responsable='$id_responsable',nom_site='$nom_site' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sucess = "Les informations sont enregistrés";
        } else {
            $errors = "Erreur d'enregistrer les données!";
        }
    } else {
        $errors = "Veuillez remplire tous les champs";
    }
}
if (isset($_POST['supprimer'])) {
    $id = $_POST['id'];
    $sql_update="UPDATE t_employe SET site=NULL WHERE site in($id)";
    $result_update=mysqli_query($conn,$sql_update);
    $sql = "DELETE FROM t_site WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && $sql_update) {
        $sucess = "Les informations sont supprimés";
    } else {
        $errors = "Les informations ne sont pas supprimés";
    }
}
?>
<?php include '../template/head.php'; ?>
<?php include '../template/template.php'; ?>

<body>
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
    <!-- SUPPRIMER MODAL-->

    <div id="supprimerModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">supprimer ce site</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <p>Voulez-vous supprimer ce site ?</p>
                    <form method="POST" action="planning.php" id="form-delete-user">
                        <input type="hidden" name="id">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                    <button type="submit" name="supprimer" form="form-delete-user" class="btn btn-danger">supprimer</button>
                </div>

            </div>
        </div>
    </div>
    <!-- ajouter Modal Site -->
    <div class="modal fade bd-example-modal-xl" id="exempleModel_ADD" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ajouter un nouveau site</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="ajouterForm" id="ajouterForm" action="planning.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom de site</label>
                            <input class="form-control" type="text" name="nom_site" placeholder="Nom de site" />
                        </div>
                        <div class="form-group">
                            <label for="name">Ville</label>
                            <input class="form-control" type="text" name="Ville" id="Ville" placeholder="ville" />
                            <ul class="list-group">
                                <button class="list-group-item list-group-item-action" data-vicopo="#Ville" data-vicopo-click='{"#Ville": "Ville"}'>
                                    <strong data-vicopo-code-postal></strong>
                                    <span data-vicopo-ville></span>
                                </button>
                            </ul>
                        </div>
                        <div class="form-group">

                            <label for="name">Nom & Prénom du responsable</label>
                            <select class="form-select form-control" name="id_responsable" aria-label="Default select example">
                                <?php
                                $sql = "SELECT * FROM t_employeur";
                                if ($result_employeur = mysqli_query($conn, $sql)) :
                                    while ($row_employeur = mysqli_fetch_assoc($result_employeur)) :
                                ?>
                                        <option value="<?php echo $row_employeur['id'] ?>"><?php echo $row_employeur['nom'] . " " . $row_employeur['prenom'] ?> </option>

                                <?php
                                    endwhile;
                                    mysqli_free_result($result_employeur);
                                endif;
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="ajouterSite" id="ajouterSite" class="btn btn-info text-nowrap m-1" style="color:#F6F6F6" style="background-color:#32be8f"><i class="fa fa-plus"></i>
                            <span class="d-none d-lg-inline-block">&nbsp;Ajouter</span>
                        </button>

                    </form>
                </div>



            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h5 class="mb-0">Liste des sites</h5>

                    <button type="button" class="btn btn-primary text-nowrap m-1" style="color:#F6F6F6" data-toggle="modal" data-target="#exempleModel_ADD" style="background-color:#32be8f">
                        <i class="fa fa-plus"></i>&nbsp;Ajouter un site
                    </button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
                                    <th>Nom du site</th>
                                    <th>Ville</th>
                                    <th>Nom du responsable</th>
                                    <th>Nombre d'employé</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT t_site.id,nom_site,ville,nom,prenom FROM t_site INNER JOIN t_employeur ON t_site.id_responsable= t_employeur.id";
                                if ($result_site = mysqli_query($conn, $sql)) :
                                    while ($row_site = mysqli_fetch_assoc($result_site)) :
                                ?>
                                        <!-- Modifier Modal site -->
                                        <div class="modal fade bd-example-modal-xl" id="<?php echo "modifierModalSite" . $row_site['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo "Modifier " . $row_site['nom_site']  ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="planning.php" method="POST" enctype="multipart/form-data">

                                                            <div class="form-group">
                                                                <label for="email">Nom Du Site</label>
                                                                <span></span>
                                                                <input class="form-control" type="text" name="nom_site_modifier" value="<?php echo $row_site['nom_site'] ?>" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="ville">Ville</label>
                                                                <span></span>
                                                                <input class="form-control" type="text" id="ville" name="ville_site_modifier" value="<?php echo $row_site['ville'] ?>" />
                                                                <ul class="list-group">
                                                                    <button class="list-group-item list-group-item-action" data-vicopo="#ville" data-vicopo-click='{"#ville": "ville"}'>
                                                                        <strong data-vicopo-code-postal></strong>
                                                                        <span data-vicopo-ville></span>
                                                                    </button>
                                                                </ul>
                                                            </div>
                                                            <div class="form-group">

                                                                <label for="name">Nom & Prénom du responsable</label>
                                                                <select class="form-select form-control" name="id_responsable_modifier" aria-label="Default select example">
                                                                    <?php
                                                                    $sql = "SELECT * FROM t_employeur";
                                                                    if ($result_employeur = mysqli_query($conn, $sql)) :
                                                                        while ($row_employeur = mysqli_fetch_assoc($result_employeur)) :
                                                                    ?>
                                                                            <option value="<?php echo $row_employeur['id'] ?>"><?php echo $row_employeur['nom'] . " " . $row_employeur['prenom'] ?> </option>
                                                                    <?php
                                                                        endwhile;
                                                                        mysqli_free_result($result_employeur);
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="id" value="<?php echo $row_site['id']; ?>" />
                                                            <button type="submit" name="modifierSite" class="btn btn-success text-nowrap m-1" style="color:#F6F6F6" style="background-color:#32be8f"><i class="fa fa-pencil"></i>
                                                                <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Valider</span>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <tr>

                                            <td><?php echo $row_site['nom_site']; ?></td>
                                            <td><?php echo $row_site['ville']; ?></td>
                                            <td><?php echo $row_site['nom'] . " " . $row_site['prenom']; ?></td>
                                            <td>
                                                <?php
                                                $site_nom = $row_site['id'];
                                                $sql = "SELECT DISTINCT email FROM t_employe INNER JOIN t_site ON t_employe.site='$site_nom'";
                                                $sql_res = mysqli_query($conn, $sql);
                                                $sql_stat = mysqli_num_rows($sql_res);
                                                echo $sql_stat; ?>

                                            </td>
                                            <td>
                                                <a href="./calendrier_test.php?id=<?php echo $row_site['id']; ?>">
                                                    <button class="btn btn-circle btn-dark text-white">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                <button class="btn btn-circle btn-info text-white" data-toggle="modal" data-target="<?php echo "#modifierModalSite" . $row_site['id'] ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button data-id="<?php echo $row_site['id']; ?>" onclick="confirmDelete(this)" class="btn btn-circle btn-danger text-white" name="supprimer_site">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                    endwhile;
                                    mysqli_free_result($result_site);
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include '../template/scripts.php' ?>
<script>
    function confirmDelete(self) {
        event.preventDefault();
        var id = self.getAttribute("data-id");

        document.getElementById("form-delete-user").id.value = id;
        $("#supprimerModal").modal("show");
    }

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
        $("document").ready(function() {
            setTimeout(function() {
                $("#message_id").remove();
            }, 3000);
        });

    });
</script>