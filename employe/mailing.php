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


$errors = $sucess = "";

$sql_id = "SELECT * FROM t_employe WHERE email='$email' LIMIT 1";
$result_id = mysqli_query($conn, $sql_id);
$employe_id = mysqli_fetch_assoc($result_id);
$employe_id_2 = $employe_id['id'];

$nom = $employe_id['nom'];
$prenom = $employe_id['prenom'];


if (isset($_POST['ajouterMessage'])) {
    $message =  htmlspecialchars($_POST['message'], ENT_QUOTES);
    $select_employeur = $_POST['select_employeur'];
    $objet = htmlspecialchars($_POST['objet'], ENT_QUOTES);
    $fichier = $_FILES["fichier"]["name"];
    $tempname_fichier = $_FILES["fichier"]["tmp_name"];
    if (!empty($message) && !empty($objet) && !empty($select_employeur)) {
        $dirName = '../img/fichier_messagerie/' . $nom . ' ' . $prenom . '/';
        $dirName = iconv("UTF-8", "Windows-1252", $dirName);
        if (!file_exists($dirName)) {
            $mk = mkdir($dirName, 0777, true);
        }

        $folder_fichier = $dirName .  iconv("UTF-8", "Windows-1252", $fichier);

        $sql_email = "SELECT email FROM t_employeur WHERE id='$select_employeur'";
        $result_email = mysqli_query($conn, $sql_email);
        $emp_email = mysqli_fetch_assoc($result_email);
        $sql = "INSERT INTO t_messagerie(message,id_employeur,objet,id_employe,user_send_type) VALUES('$message','$select_employeur','$objet','$employe_id_2','employe')";
        $result = mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        $sql_fichier = "INSERT INTO t_messagerie_fichier(id_message,fichier) VALUES('$last_id','$fichier')";
        $result_fichier = mysqli_query($conn, $sql_fichier);

        /**
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ayoub.elbouad@gmail.com';
        $mail->Password = 'ogenki@Desuka1';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender info
        $mail->setFrom('ayoub.elbouad@gmail.com', 'IGS Management');
        $mail->addReplyTo('ayoub.elbouad@gmail.com', 'IGS Management');

        $mail->addAddress($emp_email['email']);

        $mail->isHTML(true);

        // Mail subject
        $mail->Subject = 'IGS Management' . " " . $objet;

        // Mail body content
        $bodyContent = "<h5>$objet</h5>";
        $bodyContent .= "<div calss='card' style='width: 18rem;'>
            <img class='card-img-top' src='https://i.ibb.co/k5m8HY6/logo.jpg' alt='Card image cap'>
            <div class='card-body'>
            <h4 class='card-title'>Message</h4>
            <p class='card-text'>$message</p>
            <a href='#' class='btn btn-primary'>Répondre sur votre espace igs</a>
            </div>
            </div>";
        $mail->Body    = $bodyContent;

         */

        // Send email
        if ($result && $result_fichier) {
            move_uploaded_file($tempname_fichier, $folder_fichier);
            $sucess = "Message Envoyé";
        } else {
            $errors = "Message non Envoyé!";
        }
    } else {
        $errors = "Les champs choisir un employé , objet , message sont obligatoires!";
    }
}


if (isset($_POST['supprimerMessage'])) {
    $id = $_POST['id'];
    $sql = "SELECT created FROM t_messagerie WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $old_created = mysqli_fetch_assoc($result);
    $old_created = $old_created['created'];

    // $now = date('Y-m-d H-i-s');
    $now = date('Y-m-d H:i:s');
    $sql_supprimer = "UPDATE  t_messagerie SET created='$old_created', deleted_at='$now' WHERE id='$id'";
    $result_supprimer = mysqli_query($conn, $sql_supprimer);
    if ($result_supprimer) {
        $sucess = "Message a été bien supprimé! ";
    } else {
        $errors = "Message n'a été pas supprimé !";
    }
}


?>

<?php include('../template_employe/sidebar.php'); ?>

<!-- messagerie-->
<div class="container">
    <?php if ($errors != "") : ?>
        <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert" id="message_id">
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
    <div class="modal fade bd-example-modal-xl" id="exempleModel_ADD" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="mailing.php" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <label for="name">Choisir un employe</label>

                                    <select class="form-select form-control" name="select_employeur" aria-label="Default select example">

                                        <?php
                                        $sql_employeur = "SELECT * FROM t_employeur";
                                        if ($result_employeur = mysqli_query($conn, $sql_employeur)) :
                                            while ($row_employeur = mysqli_fetch_assoc($result_employeur)) :

                                        ?>
                                                <option value="<?php echo $row_employeur['id'] ?>"><?php echo $row_employeur['nom'] . " " . $row_employeur['prenom']; ?> </option>
                                        <?php
                                            endwhile;
                                            mysqli_free_result($result_employeur);
                                        endif;
                                        ?>


                                    </select>
                                </div>
                                <label for="ObjetInput" class="form-label">Objet</label>
                                <input type="text" class="form-control" id="objetInput" placeholder="Objet" name="objet" />
                                <br>
                                <div class="row">

                                    <div class="col-sm-11 ml-auto">
                                        <div class="toolbar" role="toolbar">
                                            <div class="btn-group">
                                                <label type="button" class="btn btn-light" for="my-file-selector">
                                                    <input id="my-file-selector" type="file" class="d-none" name="fichier">
                                                    <span class="fa fa-paperclip"></span>
                                                </label>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-bold"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-italic"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-underline"></span>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-align-left"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-align-right"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-align-center"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-align-justify"></span>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-indent"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-outdent"></span>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-list-ul"></span>
                                                </button>
                                                <button type="button" class="btn btn-light">
                                                    <span class="fa fa-list-ol"></span>
                                                </button>
                                            </div>
                                            <button type="button" class="btn btn-light">
                                                <span class="fa fa-trash-o"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="messageInput" class="form-label">Message</label>

                                    <textarea class="form-control" id="messageInput" name="message" rows="12" placeholder="Entrer Votre Message" style="resize: none;"></textarea>
                                </div>
                                <input class="btn btn-dark" type="submit" value="Envoyer" name="ajouterMessage">

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border border-dark">
                <div class="card-body text-white mailbox-widget pb-0" style="background-color:#32be8f ;">

                    <h2 class="text-white pb-3">Votre boîte aux lettres</h2>
                    <ul class="nav nav-tabs custom-tab border-bottom-0 mt-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="inbox-tab" data-toggle="tab" aria-controls="inbox" href="#inbox" role="tab" aria-selected="true">
                                <span class="d-block d-md-none"><i class="ti-email"></i></span>
                                <span class="d-none d-md-block">Réception</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sent-tab" data-toggle="tab" aria-controls="sent" href="#sent" role="tab" aria-selected="false">
                                <span class="d-block d-md-none"><i class="ti-export"></i></span>
                                <span class="d-none d-md-block">Envoyé</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="delete-tab" data-toggle="tab" aria-controls="delete" href="#delete" role="tab" aria-selected="false">
                                <span class="d-block d-md-none"><i class="ti-trash"></i></span>
                                <span class="d-none d-md-block">Supprimé</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="inbox" aria-labelledby="inbox-tab" role="tabpanel">
                        <div>
                            <div class="row p-4 no-gutters align-items-center">
                                <div class="col-sm-12 col-md-6">
                                    <!-- <h4 class="font-light mb-0"><i class="ti-email mr-2"></i>Vous avez 33 messages</h4> -->
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <ul class="list-inline dl mb-0 float-left float-md-right">
                                        <li class="list-inline-item text-info mr-3">
                                            <a href="" data-toggle="modal" data-target="#exempleModel_ADD">
                                                <button class="btn btn-circle  text-white" style="background-color:#32be8f;">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <span class="ml-2 font-normal text-dark">Nouveau Message</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <!-- Mail list-->
                            <div class="table-responsive">
                                <table id="" class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                    <tbody>
                                        <thead>
                                            <th></th>
                                            <th>Nom & Prénom</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </thead>
                                        <!-- row -->
                                        <?php

                                        $sql = "SELECT DISTINCT t_messagerie.id,t_messagerie.objet , t_messagerie.message ,t_employeur.nom ,t_employeur.prenom,t_employeur.photo as 'pic',t_employeur.email,t_messagerie.created FROM t_messagerie INNER JOIN t_employe ON t_messagerie.id_employe='$employe_id_2' INNER JOIN t_employeur ON t_messagerie.id_employeur=t_employeur.id where t_messagerie.user_send_type='employeur' ORDER BY t_messagerie.created Desc ";
                                        if ($result = mysqli_query($conn, $sql)) :
                                            while ($row = mysqli_fetch_assoc($result)) :

                                        ?>
                                                <div class="modal fade" id="<?php echo "exampleMoadal" . $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">message</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../img/database_image/<?php echo $row['pic']; ?>" class="rounded-circle img-fluid" style="width:40px; height:40px;">
                                                                <?php echo $row['nom'] . " " . $row['prenom']; ?>
                                                                <small><?php echo "'" . $row['email'] . "'"; ?></small>
                                                                <small class="text-right"><?php echo $row['created']; ?></small>


                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Objet:</label>
                                                                    <h6><?php echo $row['objet'] ?></h6>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                                    <h6><?php echo $row['message'] ?></h6>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr onclick="link" style="cursor:pointer;" data-toggle="modal" data-whatever="@fat" data-target="<?php echo "#exampleMoadal" . $row['id'] ?>">
                                                    <!-- label -->

                                                    <!-- star -->
                                                    <td><i class="fa fa-star text-warning"></i></td>
                                                    <td>
                                                        <span class="mb-0 text-muted"><?php echo $row['nom'] . " " . $row['prenom'] ?></span>
                                                    </td>
                                                    <!-- Message -->
                                                    <td>
                                                        <span class="text-dark">
                                                            <?php if (strlen($row['message']) > 10) {
                                                                $message = substr($row['message'], 0, 10);
                                                                echo $message . "...";
                                                            } else {
                                                                echo $row['message'];
                                                            } ?></span>
                                                    </td>
                                                    <!-- Attachment -->

                                                    <!-- Time -->
                                                    <td class="text-muted"><?php echo $row['created']; ?></td>

                                                </tr>

                                                <!-- row -->

                                        <?php
                                            endwhile;
                                            mysqli_free_result($result);
                                        endif;
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sent" aria-labelledby="sent-tab" role="tabpanel">
                        <div class="row p-3 text-dark">
                            <div class="table-responsive">

                                <table id="" class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                    <tbody>
                                        <thead>
                                            <th></th>
                                            <th>Nom & Prénom</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <!-- row -->
                                        <?php

                                        $sql = "SELECT DISTINCT t_messagerie.id,t_messagerie.objet , t_messagerie.message ,t_employeur.nom,t_employeur.photo as 'pic' ,t_employeur.prenom,t_employeur.email,t_messagerie.created FROM t_messagerie INNER JOIN t_employe ON t_messagerie.id_employe='$employe_id_2' INNER JOIN t_employeur ON t_messagerie.id_employeur=t_employeur.id where t_messagerie.user_send_type='employe' ORDER BY t_messagerie.created Desc ";
                                        if ($result = mysqli_query($conn, $sql)) :
                                            while ($row = mysqli_fetch_assoc($result)) :

                                        ?>
                                                <div class="modal fade" id="<?php echo "exampleMoadal" . $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">message</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../img/database_image/<?php echo $row['pic']; ?>" class="rounded-circle img-fluid" style="width:40px; height:40px;">
                                                                <?php echo $row['nom'] . " " . $row['prenom']; ?>
                                                                <small><?php echo "'" . $row['email'] . "'"; ?></small>
                                                                <small class="text-right"><?php echo $row['created']; ?></small>


                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Objet:</label>
                                                                    <h6><?php echo $row['objet'] ?></h6>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                                    <h6><?php echo $row['message'] ?></h6>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- SUPPRIMER MODAL-->

                                                <div id="myModal1" class="modal">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h4 class="modal-title">supprimer cet employé</h4>
                                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <p>Voulez-vous supprimer ce Message ?</p>
                                                                <form method="POST" action="mailing.php" id="supprimer_messagerie">
                                                                    <input type="hidden" name="id">
                                                                </form>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                                                                <button type="submit" name="supprimerMessage" form="supprimer_messagerie" class="btn btn-danger">supprimer</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            endwhile;
                                            mysqli_free_result($result);
                                        endif;
                                        ?>

                                        <?php
                                        $sql_employe =  "SELECT DISTINCT t_messagerie.id,t_messagerie.objet , t_messagerie.message ,t_messagerie.deleted_at,t_employeur.nom ,t_employeur.prenom,t_employeur.photo as 'pic',t_employeur.email,t_messagerie.created FROM t_messagerie INNER JOIN t_employe ON t_messagerie.id_employe='$employe_id_2' INNER JOIN t_employeur ON t_messagerie.id_employeur=t_employeur.id WHERE t_messagerie.user_send_type='employe' AND t_messagerie.deleted_at IS NULL ORDER BY t_messagerie.created Desc ";
                                        if ($result_employe = mysqli_query($conn, $sql_employe)) :
                                            while ($row_employe = mysqli_fetch_assoc($result_employe)) :


                                        ?>
                                                <div class="modal fade" id="<?php echo "envoyerModal" . $row_employe['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">message</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../img/database_image/<?php echo $row_employe['pic']; ?>" class="rounded-circle img-fluid" style="width:40px; height:40px;">
                                                                <?php echo $row_employe['nom'] . " " . $row_employe['prenom']; ?>
                                                                <small><?php echo "'" . $row_employe['email'] . "'"; ?></small>
                                                                <small class="text-right"><?php echo $row_employe['created']; ?></small>


                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Objet:</label>
                                                                    <h6><?php echo $row_employe['objet'] ?></h6>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                                    <h6><?php echo $row_employe['message'] ?></h6>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <tr onclick="link" style="cursor:pointer;" data-toggle="modal" data-whatever="@fat" data-target="<?php echo "#envoyerModal" . $row_employe['id'] ?>">
                                                    <!-- label -->

                                                    <!-- star -->
                                                    <td><i class="fa fa-star text-warning"></i></td>
                                                    <td>
                                                        <span class="mb-0 text-muted"><?php echo $row_employe['nom'] . " " . $row_employe['prenom'] ?></span>
                                                    </td>
                                                    <!-- Message -->
                                                    <td>
                                                        <span class="text-dark">
                                                            <?php if (strlen($row_employe['message']) > 10) {
                                                                $message = substr($row_employe['message'], 0, 10);
                                                                echo $message . "...";
                                                            } else {
                                                                echo $row_employe['message'];
                                                            } ?></span>
                                                    </td>
                                                    <!-- Attachment -->

                                                    <!-- Time -->
                                                    <td class="text-muted"><?php echo $row_employe['created']; ?></td>
                                                    <td class="clickable-td">
                                                        <button type="button" class="btn btn-light" data-id="<?php echo $row_employe['id']; ?>" onclick="confirmDelete(this)">
                                                            <span class="fa fa-trash-o"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php
                                            endwhile;
                                            mysqli_free_result($result_employe);
                                        endif;
                                        ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="delete" aria-labelledby="delete-tab" role="tabpanel">
                        <div class="row p-3 text-dark">
                            <div class="table-responsive">
                                <table id="" class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                    <tbody>
                                        <thead>
                                            <th></th>
                                            <th>Nom & Prénom</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </thead>
                                        <!-- row -->

                                        <?php
                                        $sql_messagerie_supp = "SELECT DISTINCT t_messagerie.id,t_messagerie.objet , t_messagerie.message ,t_messagerie.deleted_at,t_employeur.nom ,t_employeur.prenom,t_employeur.photo as 'pic',t_employeur.email, t_messagerie.created FROM t_messagerie INNER JOIN t_employe ON t_messagerie.id_employe='$employe_id_2' INNER JOIN t_employeur ON t_messagerie.id_employeur=t_employeur.id WHERE t_messagerie.user_send_type='employe' AND t_messagerie.deleted_at IS NOT NULL ORDER BY t_messagerie.created Desc ";
                                        if ($result_messagerie_supp = mysqli_query($conn, $sql_messagerie_supp)) :
                                            while ($row_messagerie_supp = mysqli_fetch_assoc($result_messagerie_supp)) :

                                        ?>

                                                <div class="modal fade" id="<?php echo "exampleMoadal" . $row_messagerie_supp['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">message</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../img/database_image/<?php echo $row_messagerie_supp['pic']; ?>" class="rounded-circle img-fluid" style="width:40px; height:40px;">
                                                                <?php echo $row_messagerie_supp['nom'] . " " . $row_messagerie_supp['prenom']; ?>
                                                                <small><?php echo "'" . $row_messagerie_supp['email'] . "'"; ?></small>
                                                                <small class="text-right"><?php echo $row_messagerie_supp['created']; ?></small>


                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Objet:</label>
                                                                    <h6><?php echo $row_messagerie_supp['objet'] ?></h6>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                                    <h6><?php echo $row_messagerie_supp['message'] ?></h6>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- SUPPRIMER MODAL-->

                                                <div class="modal fade" id="<?php echo "envoyerModal" . $row_messagerie_supp['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">message</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../img/database_image/<?php echo $row_messagerie_supp['pic']; ?>" class="rounded-circle img-fluid" style="width:40px; height:40px;">
                                                                <?php echo $row_messagerie_supp['nom'] . " " . $row_messagerie_supp['prenom']; ?>
                                                                <small><?php echo "'" . $row_messagerie_supp['email'] . "'"; ?></small>
                                                                <small class="text-right"><?php echo $row_messagerie_supp['created']; ?></small>


                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Objet:</label>
                                                                    <h6><?php echo $row_messagerie_supp['objet'] ?></h6>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                                    <h6><?php echo $row_messagerie_supp['message'] ?></h6>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <tr onclick="link" style="cursor:pointer;" data-toggle="modal" data-whatever="@fat" data-target="<?php echo "#envoyerModal" . $row_messagerie_supp['id'] ?>">
                                                    <!-- label -->

                                                    <!-- star -->
                                                    <td><i class="fa fa-star text-warning"></i></td>
                                                    <td>
                                                        <span class="mb-0 text-muted"><?php echo $row_messagerie_supp['nom'] . " " . $row_messagerie_supp['prenom'] ?></span>
                                                    </td>
                                                    <!-- Message -->
                                                    <td>
                                                        <span class="text-dark">
                                                            <?php if (strlen($row_messagerie_supp['message']) > 10) {
                                                                $message = substr($row_messagerie_supp['message'], 0, 10);
                                                                echo $message . "...";
                                                            } else {
                                                                echo $row_messagerie_supp['message'];
                                                            } ?></span>
                                                    </td>
                                                    <!-- Attachment -->

                                                    <!-- Time -->
                                                    <td class="text-muted"><?php echo $row_messagerie_supp['created']; ?></td>

                                                </tr>
                                        <?php
                                            endwhile;
                                            mysqli_free_result($result_messagerie_supp);
                                        endif;
                                        ?>
                                        <!-- row -->



                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<script type="text/javascript">
    function confirmDelete(self) {
        event.preventDefault();
        var id = self.getAttribute("data-id");

        document.getElementById("supprimer_messagerie").id.value = id;
        $("#myModal1").modal("show");
    }

    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    $("document").ready(function() {
        setTimeout(function() {
            $("#message_id").remove();
        }, 3000);
    });


    $(".clickable-td").on("click", function(e) {
        e.preventDefault();
        return false;
    });
</script>

</html>