<?php
include '../db.php';
include '../functions.php';
session_start();

$email = $_SESSION['email'];
$errors = $sucess = "";


$sql = "SELECT * FROM t_employeur WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_employeur.php');
    exit();
}

if (isset($_POST['supprimer'])) {
    // t_qrcode_employe t_messagerie t_fichier t_messagerie_fichier
    $id = $_POST['id'];



    $sql = "SELECT * FROM t_employe WHERE id='$id'";
    $sql_query = mysqli_query($conn, $sql);
    $sql_fetch = mysqli_fetch_assoc($sql_query);

    $sql2 = "SELECT * FROM t_messagerie_fichier INNER JOIN t_messagerie ON t_messagerie.id = t_messagerie_fichier.id_message AND t_messagerie.id_employe='$id'";
    $sql_query2 = mysqli_query($conn, $sql2);
    $sql_fetch3 = mysqli_fetch_assoc($sql_query2);

    @$msg_id = $sql_fetch3['id_message'];




    


    $path = "../img/dossier_RH/" . $sql_fetch['nom'] . " " . $sql_fetch['prenom'];
    $path2 = "../img/database_image/" . iconv("UTF-8", "Windows-1250", $sql_fetch['photo']);

    deleteDirectory($path);

    if (is_file($path2)) {
        unlink("../img/database_image/" . iconv("UTF-8", "Windows-1250", $sql_fetch['photo']));
    }

    $sql1 = "DELETE FROM t_messagerie_fichier where id_message in ('$msg_id');";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM t_messagerie WHERE id_employe='$id'";
    $result2 = mysqli_query($conn, $sql2);



    $sql3 = "DELETE FROM t_fichier where id_employe='$id';";
    $result3 = mysqli_query($conn, $sql3);



    $sql5 = "DELETE FROM t_qrcode_employe where id_employe='$id';";
    $result5 = mysqli_query($conn, $sql5);

    // $sql_10 = "DELETE FROM t_recyclage WHERE id_employe='$id'";
    // $result10 = mysqli_query($conn, $sql_10);


    $sql6 = "DELETE FROM t_employe where id='$id';";
    $result6 = mysqli_query($conn, $sql6);
}

if (isset($_POST['modifier'])) {
    // Pour la table employe
    $id = $_POST['id'];
    $sql = "SELECT * FROM t_employe WHERE id='$id'";
    $sql_query = mysqli_query($conn, $sql);
    $fetch_information_employe = mysqli_fetch_assoc($sql_query);

    // Pour la table fichier

    $sql = "SELECT * FROM t_fichier WHERE id_employe='$id'";
    $sql_query = mysqli_query($conn, $sql);
    $fetch_information_fichier = mysqli_fetch_assoc($sql_query);

    $success = $error = "";
    $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES);
    $prenom = htmlspecialchars($_POST['prenom'], ENT_QUOTES);
    $date_de_naissance = $_POST['date_de_naissance'];
    $date_de_naissance_format = date("Y-m-d", strtotime($date_de_naissance));

    $email = $_POST['email'];
    $adresse = htmlspecialchars($_POST['adresse'], ENT_QUOTES);
    $code_postal = $_POST['code_postal'];
    $ville = htmlspecialchars($_POST['ville'], ENT_QUOTES);
    $statut = htmlspecialchars($_POST['statut'], ENT_QUOTES);
    $select_contrat = $_POST['select_contrat'];
    $echelon = $_POST['echelon'];
    $select_ssiap = $_POST['select_ssiap'];


    $date_fin_contrat = $_POST['date_fin_contrat'];
    $date_fin_contrat_format = date("Y-m-d", strtotime($date_fin_contrat));
    $date_embauche = $_POST['date_embauche'];
    $date_embauche_format = date("Y-m-d", strtotime($date_embauche));

    $image = $_FILES["image"]["name"];
    $tempname_image = $_FILES["image"]["tmp_name"];
    $carte_pro = $_FILES["carte_pro"]["name"];
    $tempname_carte_pro = $_FILES["carte_pro"]["tmp_name"];
    $carte_identite = $_FILES["carte_identite"]["name"];
    $tempname_carte_identite = $_FILES["carte_identite"]["tmp_name"];
    $carte_grise = $_FILES["carte_grise"]["name"];
    $tempname_carte_grise = $_FILES["carte_grise"]["tmp_name"];
    $carte_vitale = $_FILES["carte_vitale"]["name"];
    $tempname_carte_vitale = $_FILES["carte_vitale"]["tmp_name"];
    $diplome = $_FILES["diplome"]["name"];
    $tempname_diplome = $_FILES["diplome"]["tmp_name"];
    $permis = $_FILES["permis"]["name"];
    $tempname_permis = $_FILES["permis"]["tmp_name"];
    $rib = $_FILES["rib"]["name"];
    $tempname_rib = $_FILES["rib"]["tmp_name"];
    $convention_collective = $_FILES["convention_collective"]["name"];
    $tempname_convention_collective = $_FILES["convention_collective"]["tmp_name"];
    $contrat_de_travail = $_FILES["contrat_de_travail"]["name"];
    $tempname_contrat_de_travail = $_FILES["contrat_de_travail"]["tmp_name"];

    $dirName = '../img/dossier_RH/' . $nom . ' ' . $prenom . '/';
    $dirName = iconv("UTF-8", "Windows-1252", $dirName);

    $folder_image = "../img/database_image/" . iconv("UTF-8", "Windows-1252", $image);
    $folder_carte_pro =   $dirName .  iconv("UTF-8", "Windows-1252", $carte_pro);
    $folder_carte_identite = $dirName .  iconv("UTF-8", "Windows-1252", $carte_identite);
    $folder_carte_grise = $dirName .  iconv("UTF-8", "Windows-1252", $carte_grise);
    $folder_carte_vitale =  $dirName . iconv("UTF-8", "Windows-1252", $carte_vitale);
    $folder_diplome = $dirName . iconv("UTF-8", "Windows-1252", $diplome);
    $folder_permis = $dirName . iconv("UTF-8", "Windows-1252", $permis);
    $folder_rib = $dirName . iconv("UTF-8", "Windows-1252", $rib);
    $folder_convention_collective = $dirName .  iconv("UTF-8", "Windows-1252", $convention_collective);
    $folder_contrat_de_travail = $dirName . iconv("UTF-8", "Windows-1252", $contrat_de_travail);




    $dirName_old = iconv("UTF-8", "Windows-1252", '../img/dossier_RH/' . $fetch_information_employe['nom'] . ' ' . $fetch_information_employe['prenom'] . '/');
    rename($dirName_old, $dirName);

    if ($image != NULL) {
        $image_url = "../img/database_image/" . $fetch_information_employe['photo'];
        if (is_file($image_url)) {
            unlink($image_url);
        }
        $sql = "UPDATE t_employe SET nom='$nom', prenom='$prenom', date_de_naissance='$date_de_naissance_format', email='$email', adresse = '$adresse' , code_postal = '$code_postal' , ville = '$ville' , statut = '$statut' ,  contrat = '$select_contrat' , echelon = '$echelon' ,service='$select_ssiap' , date_embauche='$date_embauche_format',date_fin_contrat = '$date_fin_contrat_format' ,photo ='$image' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        move_uploaded_file($tempname_image, $folder_image);
    } else {
        $image = $fetch_information_employe['photo'];
    }
    if ($carte_pro != NULL) {
        $carte_pro_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['carte_pro'];
        // echo file_exists($carte_pro_url);
        if (is_file($carte_pro_url)) {
            unlink($carte_pro_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET carte_pro='$carte_pro' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_carte_pro, $folder_carte_pro);
    } else {
        $carte_pro = $fetch_information_fichier['carte_pro'];
    }
    if ($carte_identite != NULL) {
        $carte_identite_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['carte_identite'];
        if (is_file($carte_identite_url)) {
            // chmod($carte_identite_url, 0644);
            unlink($carte_identite_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET carte_identite='$carte_identite' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_carte_identite, $folder_carte_identite);
    } else {
        $carte_identite = $fetch_information_fichier['carte_identite'];
    }
    if ($carte_grise != NULL) {
        $carte_grise_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['carte_grise'];
        if (is_file($carte_grise_url)) {
            unlink("../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['carte_grise']);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET carte_grise='$carte_grise' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_carte_grise, $folder_carte_grise);
    } else {
        $carte_grise = $fetch_information_fichier['carte_grise'];
    }
    if ($carte_vitale != NULL) {
        $carte_vital_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['carte_vitale'];
        if (is_file($carte_vital_url)) {
            unlink($carte_vital_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET carte_vitale='$carte_vitale' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_carte_vitale, $folder_carte_vitale);
    } else {
        $carte_vitale = $fetch_information_fichier['carte_vitale'];
    }
    if ($diplome != NULL) {
        $diplome_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['diplome'];
        if (is_file($diplome_url)) {
            unlink($diplome_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET diplome='$diplome' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_diplome, $folder_diplome);
    } else {
        $diplome = $fetch_information_fichier['diplome'];
    }
    if ($permis != NULL) {
        $permis_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['permis'];
        if (is_file($permis_url)) {
            unlink($permis_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET permis='$permis' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_permis, $folder_permis);
    } else {
        $permis = $fetch_information_fichier['permis'];
    }
    if ($rib != NULL) {
        $rib_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['rib'];
        if (is_file($rib_url)) {
            unlink($rib_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET rib='$rib' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_rib, $folder_rib);
    } else {
        $rib = $fetch_information_fichier['rib'];
    }
    if ($convention_collective != NULL) {
        $convention_collective_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['convention_collective'];
        if (is_file($convention_collective_url)) {
            unlink($convention_collective_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET convention_collective='$convention_collective' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_convention_collective, $folder_convention_collective);
    } else {
        $convention_collective = $fetch_information_fichier['convention_collective'];
    }
    if ($contrat_de_travail != NULL) {
        $contrat_de_travail_url = "../img/dossier_RH/" . $nom . " " . $prenom . "/" . $fetch_information_fichier['contrat_de_travail'];
        if (is_file($contrat_de_travail_url)) {
            unlink($contrat_de_travail_url);
        }
        $last_id = mysqli_insert_id($conn);
        $sql2 = "UPDATE t_fichier SET contrat_de_travail='$contrat_de_travail' WHERE id_employe='$id'";
        $result = mysqli_query($conn, $sql2);
        move_uploaded_file($tempname_contrat_de_travail, $folder_contrat_de_travail);
    } else {
        $contrat_de_travail = $fetch_information_fichier['contrat_de_travail'];
    }
    $sql = "UPDATE t_employe SET nom='$nom', prenom='$prenom', date_de_naissance='$date_de_naissance_format', email='$email', adresse = '$adresse' , code_postal = '$code_postal' , ville = '$ville' , statut = '$statut' ,  contrat = '$select_contrat' , echelon = '$echelon' ,service='$select_ssiap' , date_embauche='$date_embauche_format',date_fin_contrat = '$date_fin_contrat_format' ,photo ='$image' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $success = "Les informations sont modifiés";
    } else {
        $errors = "Erreur de modifier les données";
    }
}



if (isset($_POST['ajouter'])) {

    $nom = htmlspecialchars(filter_var($_POST['nom'], FILTER_SANITIZE_STRING), ENT_QUOTES);
    $prenom = htmlspecialchars(filter_var($_POST['prenom'], FILTER_SANITIZE_STRING), ENT_QUOTES);
    $date_de_naissance = $_POST['date_de_naissance'];
    $date_de_naissance_format = date("Y-m-d", strtotime($date_de_naissance));
    $date_aujordhui = date("Y-m-d");


    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe'], ENT_QUOTES);
    $mot_de_passe2 = htmlspecialchars($_POST['mot_de_passe2'], ENT_QUOTES);
    $adresse = htmlspecialchars($_POST['adresse'], ENT_QUOTES);
    $code_postal = filter_var($_POST['code_postal'], FILTER_SANITIZE_NUMBER_INT);
    $ville = htmlspecialchars($_POST['ville'], ENT_QUOTES);
    $statut = htmlspecialchars($_POST['statut'], ENT_QUOTES);
    $select_contrat = $_POST['select_contrat'];
    $echelon = $_POST['echelon'];
    $select_ssiap = $_POST['select_ssiap'];
    $date_embauche = $_POST['date_embauche'];
    $date_embauche_format = date("Y-m-d", strtotime($date_embauche));
    $date_fin_contrat = $_POST['date_fin_contrat'];
    $date_fin_contrat_format = date("Y-m-d", strtotime($date_fin_contrat));

    $site = $_POST['nom_site'];

    $image = $_FILES["image"]["name"];
    $tempname_image = $_FILES["image"]["tmp_name"];
    $carte_pro = $_FILES["carte_pro"]["name"];
    $tempname_carte_pro = $_FILES["carte_pro"]["tmp_name"];
    $carte_identite = $_FILES["carte_identite"]["name"];
    $tempname_carte_identite = $_FILES["carte_identite"]["tmp_name"];
    $carte_grise = $_FILES["carte_grise"]["name"];
    $tempname_carte_grise = $_FILES["carte_grise"]["tmp_name"];
    $carte_vitale = $_FILES["carte_vitale"]["name"];
    $tempname_carte_vitale = $_FILES["carte_vitale"]["tmp_name"];
    $diplome = $_FILES["diplome"]["name"];
    $tempname_diplome = $_FILES["diplome"]["tmp_name"];
    $permis = $_FILES["permis"]["name"];
    $tempname_permis = $_FILES["permis"]["tmp_name"];
    $rib = $_FILES["rib"]["name"];
    $tempname_rib = $_FILES["rib"]["tmp_name"];
    $convention_collective = $_FILES["convention_collective"]["name"];
    $tempname_convention_collective = $_FILES["convention_collective"]["tmp_name"];
    $contrat_de_travail = $_FILES["contrat_de_travail"]["name"];
    $tempname_contrat_de_travail = $_FILES["contrat_de_travail"]["tmp_name"];


    $sql_email = "SELECT * FROM t_employe where nom='$nom' and prenom='$prenom' or email='$email' LIMIT 1";
    $sql_email_query = mysqli_query($conn, $sql_email);
    $employe = mysqli_fetch_assoc($sql_email_query);

    $sql_email2 = "SELECT * FROM t_employeur where nom='$nom' and prenom='$prenom' or email='$email' LIMIT 1";
    $sql_email_query2 = mysqli_query($conn, $sql_email2);
    $employeur = mysqli_fetch_assoc($sql_email_query2);


    if (!$employe && !$employeur) {
        if ($mot_de_passe == $mot_de_passe2) {
            if (strlen($mot_de_passe) >= 8) {
                $mot_de_passe_hashe = md5($mot_de_passe);

                $dirName = '../img/dossier_RH/' . $nom . ' ' . $prenom . '/';
                $dirName = iconv("UTF-8", "Windows-1252", $dirName);

                if (!file_exists($dirName)) {
                    $mk = mkdir($dirName, 0777, true);
                }

                $folder_image = "../img/database_image/" . iconv("UTF-8", "Windows-1252", $image);
                $folder_carte_pro =   $dirName .  iconv("UTF-8", "Windows-1252", $carte_pro);
                $folder_carte_identite = $dirName .  iconv("UTF-8", "Windows-1252", $carte_identite);
                $folder_carte_grise = $dirName .  iconv("UTF-8", "Windows-1252", $carte_grise);
                $folder_carte_vitale =  $dirName . iconv("UTF-8", "Windows-1252", $carte_vitale);
                $folder_diplome = $dirName . iconv("UTF-8", "Windows-1252", $diplome);
                $folder_permis = $dirName . iconv("UTF-8", "Windows-1252", $permis);
                $folder_rib = $dirName . iconv("UTF-8", "Windows-1252", $rib);
                $folder_convention_collective = $dirName .  iconv("UTF-8", "Windows-1252", $convention_collective);
                $folder_contrat_de_travail = $dirName . iconv("UTF-8", "Windows-1252", $contrat_de_travail);


                $sql = "INSERT INTO t_employe(nom,prenom,adresse,code_postal,ville,echelon,date_de_naissance,statut,contrat,date_embauche,date_fin_contrat,service,email,mot_de_passe,photo,`site`) VALUES('$nom','$prenom','$adresse',$code_postal,'$ville','$echelon','$date_de_naissance_format','$statut','$select_contrat','$date_embauche_format','$date_fin_contrat_format','$select_ssiap','$email','$mot_de_passe_hashe','$image',$site)";

                $result = mysqli_query($conn, $sql);


                $last_id = mysqli_insert_id($conn);

                $sql3 = "INSERT INTO t_qrcode_employe(id_employe,code_act) VALUES ('$last_id','$nom.123')";
                $result = mysqli_query($conn, $sql3);

                $sql2 = "INSERT INTO t_fichier(carte_pro,carte_identite,carte_grise,carte_vitale,convention_collective,diplome,contrat_de_travail,permis,rib,id_employe) VALUES('$carte_pro','$carte_identite','$carte_grise','$carte_vitale','$convention_collective','$diplome','$contrat_de_travail','$permis','$rib','$last_id')";
                $result = mysqli_query($conn, $sql2);



                if (move_uploaded_file($tempname_image, $folder_image)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }

                if (move_uploaded_file($tempname_carte_pro, $folder_carte_pro)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_carte_identite, $folder_carte_identite)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_carte_grise, $folder_carte_grise)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_carte_vitale, $folder_carte_vitale)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_diplome, $folder_diplome)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_permis, $folder_permis)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_rib, $folder_rib)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_convention_collective, $folder_convention_collective)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
                if (move_uploaded_file($tempname_contrat_de_travail, $folder_contrat_de_travail)) {
                    $sucess = "fichiers téléchargés avec succès";
                } else {
                    $errors = "il manque des fichiers ! ";
                }
            } else {
                $errors = "le mot de passe doit comporter 8 caractères de plus !";
            }
        } else {
            $errors = "Les mots de passe ne correspondent pas !";
        }
    } else {
        $errors = "l'email ou le nom complet existe déjà";
    }
}


?>

<?php include '../template/head.php'; ?>
<?php include '../template/template.php'; ?>

<body>

    <!-- Page Content  -->

    <!-- table-->

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h5 class="mb-0">Liste des employés</h5>
                    <button type="button" class="btn btn-primary text-nowrap m-1" style="color:#F6F6F6" data-toggle="modal" data-target="#exempleModel_ADD" style="background-color:#32be8f">
                        <i class="fa fa-plus"></i>&nbsp;Ajouter un employé
                    </button>
                </div>


                <div class="card-body">
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



                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>N°MAtricule</th>
                                        <th></th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Statut</th>

                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM t_employe";
                                    if ($result = mysqli_query($conn, $sql)) :
                                        while ($row = mysqli_fetch_assoc($result)) :

                                    ?>

                                            <tr>

                                                <th scope="row"><?php echo $row['id']; ?></th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (empty($row['photo'])) : ?>
                                                            <img src="../img/avatar.png" alt="avatar" class="rounded-circle" width="30">
                                                        <?php else : ?>
                                                            <img src="../img/database_image/<?php echo $row['photo']; ?> " alt="avatar" class="rounded-circle" width="30">
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $row['nom']; ?>
                                                </td>
                                                <td><?php echo $row['prenom']; ?></td>
                                                <td><?php echo $row['statut'] . " | " . $row['service']; ?></td>

                                                <td>
                                                    <div class="d-flex flex-column flex-lg-row align-items-center ">
                                                        <button type="button" class="btn btn-success text-nowrap m-1" data-toggle="modal" data-target="<?php echo "#exampleModal" . $row['id']; ?>" style="background-color:#32be8f"><i class="fa fa-eye"></i>
                                                            <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Information</span>
                                                        </button>

                                                        <button type="button" class="btn btn-warning text-nowrap m-1" style="color:#F6F6F6" data-toggle="modal" data-target="<?php echo "#exampleModal" . $row['id'] . "update"; ?>" style="background-color:#32be8f"><i class="fa fa-pencil"></i>
                                                            <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Modifier</span>
                                                        </button>

                                                        <form action="liste_employe.php" method="POST" name="myForm" style="display: inline-block;">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                                            <button type="submit" data-id="<?php echo $row['id']; ?>" onclick="confirmDelete(this)" name="supprimer" class="btn btn-danger text-nowrap m-1"><i class="fa fa-trash"></i>
                                                                <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Supprimer</span>
                                                            </button>
                                                        </form>

                                                        <button type="button" class="btn btn-info text-nowrap m-1" style="color:#F6F6F6" data-toggle="modal" data-target="<?php echo "#exampleModal" . $row['id'] . "D_RH"; ?>" style="background-color:#32be8f"><i class="fa fa-file"></i>
                                                            <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Dossier RH</span>
                                                        </button>

                                                    </div>

                                                    <!-- SUPPRIMER MODAL-->

                                                    <div id="myModal" class="modal">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">supprimer cet employé</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <p>Voulez-vous supprimer cet utilisateur ?</p>
                                                                    <form method="POST" action="liste_employe.php" id="form-delete-user">
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

                                                    <!-- AFFICHER MODAL-->
                                                    <?php
                                                    $id = $row['id'];
                                                    $req = "SELECT * FROM t_qrcode_employe WHERE id_employe='$id'";
                                                    $req_query = mysqli_query($conn, $req);
                                                    $res_query = mysqli_fetch_assoc($req_query);

                                                    ?>
                                                    <div class="modal fade bd-example-modal-xl" id="<?php echo "exampleModal" . $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['nom'] . " " . $row['prenom']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <section style="background-color: #eee;">
                                                                        <div class="container py-5">


                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="card mb-4">
                                                                                        <div class="card-body text-center">
                                                                                            <?php if (empty($row['photo'])) : ?>
                                                                                                <img src="../img/avatar.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                                                                            <?php else : ?>
                                                                                                <img src="../img/database_image/<?php echo $row['photo']; ?> " alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                                                                            <?php endif; ?>
                                                                                            <h5 class="my-3"></h5>
                                                                                            <p class="text-muted mb-1"><?php echo $row['nom'] . " " . $row['prenom']; ?></p>
                                                                                            <p class="text-muted mb-1"><?php echo $row['email']; ?></p>
                                                                                            <p class="text-muted mb-4"><?php echo $row['statut'] . " | " . $row['service']; ?></p>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card mb-4 mb-lg-0">
                                                                                        <div class="card-body p-0">
                                                                                            <img src="../img/image-qrcode.png" class="img-thumbnail">
                                                                                            <center> QR CODE : <?php
                                                                                                                if (isset($res_query['code_act'])) {
                                                                                                                    echo  $res_query['code_act'];
                                                                                                                } else {
                                                                                                                    echo "NULL";
                                                                                                                }
                                                                                                                ?></center>

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
                                                                                                    <p class="text-body mb-0"><?php echo $row['nom'] . " " . $row['prenom']; ?></p>
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
                                                                                                                                $date_de_naissance_format = date("Y-m-d", strtotime($row['date_de_naissance']));


                                                                                                                                $age = date_diff(date_create($date_de_naissance_format), date_create($date_aujordhui));
                                                                                                                                echo $age->format('%y'); ?>


                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Date de naissance</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['date_de_naissance']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Adresse</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['adresse']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">code postal</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['code_postal']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Ville</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['ville']; ?></p>
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
                                                                                                    <p class="text-body mb-0"><?php echo $row['statut']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Contrat</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['contrat']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">date d'embauche</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['date_embauche']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Date fin contrat</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php if ($row['date_fin_contrat']) {
                                                                                                                                    echo $row['date_fin_contrat'];
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
                                                                                                    <p class="text-body mb-0"><?php echo $row['service']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-3">
                                                                                                    <p class="mb-0">Echelon</p>
                                                                                                </div>
                                                                                                <div class="col-sm-9">
                                                                                                    <p class="text-body mb-0"><?php echo $row['echelon']; ?></p>
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
                                                    </div>




                                                    <!-- MODIFY MODAL -->

                                                    <div class="modal fade bd-example-modal-xl" id="<?php echo "exampleModal" . $row['id'] . "update"; ?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <?php
                                                        $id = $row['id'];
                                                        $requete = "SELECT * FROM t_fichier INNER JOIN t_employe ON t_fichier.id_employe='$id'";
                                                        $res = mysqli_query($conn, $requete);
                                                        $file = mysqli_fetch_assoc($res);
                                                        ?>
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['nom'] . " " . $row['prenom']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="liste_employe.php" method="POST" enctype="multipart/form-data">

                                                                        <div class="form-group">
                                                                            <label for="email">Nom</label>
                                                                            <span></span>
                                                                            <input class="form-control" type="text" name="nom" value="<?php echo $row['nom'] ?>" />

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Prénom</label>
                                                                            <input class="form-control" type="text" name="prenom" value="<?php echo $row['prenom'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Date de naissance</label>
                                                                            <input class="form-control" type="date" name="date_de_naissance" value="<?php echo $row['date_de_naissance'] ?>" />
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="name">Email</label>
                                                                            <input class="form-control" type="email" name="email" value="<?php echo $row['email'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Adresse</label>
                                                                            <input class="form-control" type="text" name="adresse" value="<?php echo $row['adresse'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Code Postal</label>
                                                                            <input class="form-control" type="number" name="code_postal" value="<?php echo $row['code_postal'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Ville</label>
                                                                            <input class="form-control" type="text" name="ville" value="<?php echo $row['ville'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div></div>
                                                                            <label for="name">Statut</label>
                                                                            <input class="form-control" type="text" name="statut" value="<?php echo $row['statut'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Contrat</label>

                                                                            <select class="form-select form-control" name="select_contrat" aria-label="Default select example">
                                                                                <option hidden><?php echo $row['contrat']; ?></option>
                                                                                <option value="CDD">CDD</option>
                                                                                <option value="CDI">CDI</option>
                                                                                <!-- <option value="3">Three</option> -->
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Echelon</label>
                                                                            <input class="form-control" type="int" name="echelon" value="<?php echo $row['echelon'] ?>" />

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Service</label>

                                                                            <select class="form-select form-control" name="select_ssiap" aria-label="Default select example">
                                                                                <option hidden><?php echo $row['service'] ?></option>
                                                                                <option value="SSIAP1">SSIAP 1</option>
                                                                                <option value="SSIAP2">SSIAP 2</option>
                                                                                <option value="SSIAP3">SSIAP 3</option>
                                                                                <!-- <option value="3">Three</option> -->
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="name">Date d'embauche</label>
                                                                            <input class="form-control" type="date" name="date_embauche" value="<?php echo $row['date_embauche'] ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">Date fin de contrat</label>
                                                                            <input class="form-control" type="date" name="date_fin_contrat" value="<?php echo $row['date_fin_contrat'] ?>" />
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label">Modifier l'image</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="image" src="">
                                                                            <label class="custom-file-label" for="customInput">Choisir votre image</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CARTE PROFESSIONNELLE</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="carte_pro">
                                                                            <label class="custom-file-label" for="customInput">Choisir votre CARTE PROFESSIONNELLE</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> CARTE D'IDENTITÉ </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="carte_identite" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_identite']; ?>">
                                                                            <label class="custom-file-label" for="customInput">Choisir votre CARTE D'IDENTITÉ</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> CARTE GRISE </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="carte_grise" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_grise']; ?>">
                                                                            <label class="custom-file-label" for="customInput">CARTE GRISE</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> CARTE VITALE </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="carte_vitale" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_vitale']; ?>">
                                                                            <label class="custom-file-label" for="customInput"> CARTE VITALE</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> DIPLOME </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="diplome" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['diplome']; ?>">
                                                                            <label class="custom-file-label" for="customInput"> DIPLOME</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> DIPLOME </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="permis" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['diplome']; ?>">
                                                                            <label class="custom-file-label" for="customInput"> PERMIS</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> RIB </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="rib" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['rib']; ?>">
                                                                            <label class="custom-file-label" for="customInput"> RIB</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> CONVENTION COLLECTIVE </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="convention_collective" value=" <?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['convention_collective']; ?>">
                                                                            <label class="custom-file-label" for="customInput"> CONVENTION COLLECTIVE</label>
                                                                        </div>
                                                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;"> CONTRAT DE TRAVAIL </label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="contrat_de_travail" value="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['contrat_de_travail']; ?>">
                                                                            <label class="custom-file-label" for="customInput">CONTRAT DE TRAVAIL </label>
                                                                        </div>

                                                                        <form action="liste_employe.php" method="POST">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                                                            <button type="submit" name="modifier" class="btn btn-success text-nowrap m-1" style="color:#F6F6F6" style="background-color:#32be8f"><i class="fa fa-pencil"></i>
                                                                                <span class="d-none d-lg-inline-block">&nbsp;&nbsp;Valider</span>
                                                                            </button>
                                                                        </form>

                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Dossier RH MODAL -->

                                                    <div class="modal fade bd-example-modal-xl" id="<?php echo "exampleModal" . $row['id'] . "D_RH"; ?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                        <?php
                                                        $id = $row['id'];
                                                        $requete = "SELECT * FROM t_fichier INNER JOIN t_employe ON t_fichier.id_employe='$id'";
                                                        $res = mysqli_query($conn, $requete);
                                                        $file = mysqli_fetch_assoc($res);
                                                        ?>
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['nom'] . " " . $row['prenom']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">

                                                                    <input type="button" class="btn btn-dark" onclick="printDiv('<?php echo $row['id']; ?>')" value="imprimer" style="margin-bottom:10px;" />
                                                                    <div id="<?php echo "carouselExampleControls" . $row['id']; ?>" class="carousel slide" data-ride="carousel">
                                                                        <div id="<?php echo $row['id']; ?>">
                                                                            <?php
                                                                            $identite_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_identite'], PATHINFO_EXTENSION);
                                                                            $vitale_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_vitale'], PATHINFO_EXTENSION);
                                                                            $permis_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['permis'], PATHINFO_EXTENSION);
                                                                            $rib_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['rib'], PATHINFO_EXTENSION);
                                                                            $grise_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_grise'], PATHINFO_EXTENSION);
                                                                            $pro_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_pro'], PATHINFO_EXTENSION);
                                                                            $diplome_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['diplome'], PATHINFO_EXTENSION);
                                                                            $travail_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['contrat_de_travail'], PATHINFO_EXTENSION);
                                                                            $convention_extension = pathinfo("../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['convention_collective'], PATHINFO_EXTENSION);
                                                                            ?>

                                                                            <div class="carousel-inner">
                                                                                <div class="carousel-item active">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CARTE D'IDENTITÉ</center>
                                                                                    <?php if ($identite_extension == 'png' || $identite_extension == 'jpg' || $identite_extension == 'jpeg' || $identite_extension == 'gif' || $identite_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_identite']; ?>">
                                                                                    <?php elseif ($identite_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_identite']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CARTE D'IDENTITÉ' est introuvable</center>

                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CARTE VITALE</center>
                                                                                    <?php if ($vitale_extension == 'png' || $vitale_extension == 'jpg' || $vitale_extension == 'jpeg' || $vitale_extension == 'gif' || $vitale_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_vitale']; ?>">
                                                                                    <?php elseif ($vitale_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_vitale']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CARTE VITALE' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">PERMIS</center>
                                                                                    <?php if ($permis_extension == 'png' || $permis_extension == 'jpg' || $permis_extension == 'jpeg' || $permis_extension == 'gif' || $permis_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['permis']; ?>">
                                                                                    <?php elseif ($permis_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['permis']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'PERMIS' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">RIB</center>
                                                                                    <?php if ($rib_extension == 'png' || $rib_extension == 'jpg' || $rib_extension == 'jpeg' || $rib_extension == 'gif' || $rib_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['rib']; ?>">
                                                                                    <?php elseif ($rib_extension) : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['rib']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'RIB' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CARTE GRISE</center>
                                                                                    <?php if ($grise_extension == 'png' || $grise_extension == 'jpg' || $grise_extension == 'jpeg' || $grise_extension == 'gif' || $grise_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_grise']; ?>">
                                                                                    <?php elseif ($grise_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_grise']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CARTE GRISE' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CARTE PROFESSIONNELLE</center>
                                                                                    <?php if ($pro_extension == 'png' || $pro_extension == 'jpg' || $pro_extension == 'jpeg' || $pro_extension == 'gif' || $pro_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_pro']; ?>">
                                                                                    <?php elseif ($pro_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['carte_pro']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CARTE PROFESSIONNELLE' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">DIPLOME</center>
                                                                                    <?php if ($diplome_extension == 'png' || $diplome_extension == 'jpg' || $diplome_extension == 'jpeg' || $diplome_extension == 'gif' || $diplome_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['diplome']; ?>">
                                                                                    <?php elseif ($diplome_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['diplome']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'Diplome' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CONTRAT DE TRAVAIL</center>
                                                                                    <?php if ($travail_extension == 'png' || $travail_extension == 'jpg' || $travail_extension == 'jpeg' || $travail_extension == 'gif' || $travail_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['contrat_de_travail']; ?>">
                                                                                    <?php elseif ($travail_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['contrat_de_travail']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CONTRAT DE TRAVAIL' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                <div class="carousel-item ">
                                                                                    <center style="margin-bottom:10px;font-weight: bold;">CONVENTION COLLECTIVE</center>
                                                                                    <?php if ($convention_extension == 'png' || $convention_extension == 'jpg' || $convention_extension == 'jpeg' || $convention_extension == 'gif' || $convention_extension == 'tiff') : ?>
                                                                                        <img class="d-block w-100" src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['convention_collective']; ?>">
                                                                                    <?php elseif ($convention_extension == 'pdf') : ?>
                                                                                        <iframe src="<?php echo "../img/dossier_RH/" . $row['nom'] . " " . $row['prenom'] . "/" . $file['convention_collective']; ?>" frameborder="0" style="width:100%; height:580px; padding: 3em; "></iframe>
                                                                                    <?php else : ?>
                                                                                        <center>Le document 'CONVENTION COLLECTIVE DE TRAVAIL' est introuvable</center>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <a class="carousel-control-prev" href="<?php echo "#carouselExampleControls" . $row['id']; ?>" role="button" data-slide="prev">
                                                                            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                                                                        </a>
                                                                        <a class="carousel-control-next" href="<?php echo "#carouselExampleControls" . $row['id']; ?>" role="button" data-slide="next">
                                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        </a>
                                                                    </div>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        endwhile;
                                        mysqli_free_result($result);
                                    endif;
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- add MODAL -->
                    <div class="modal fade bd-example-modal-xl" id="exempleModel_ADD" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ajouter un nouvel employé</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form name="ajouterForm" id="ajouterForm" action="liste_employe.php" method="POST" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="email">Nom</label>
                                            <input class="form-control" type="text" name="nom" placeholder="nom" maxlength="15" data-parsley-maxlength="15" required data-parsley-pattern="/^[a-zA-ZÀ-ÿ-. ]*$/" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Prénom</label>
                                            <input class="form-control" type="text" name="prenom" placeholder="prénom" maxlength="15" data-parsley-maxlength="15" required data-parsley-pattern="/^[a-zA-ZÀ-ÿ-. ]*$/" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Date de naissance</label>
                                            <input class="form-control" type="date" name="date_de_naissance" placeholder="date de naissance" />
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input class="form-control" type="email" name="email" placeholder="email" required data-parsley-type="email" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Mot de passe</label>
                                            <input class="form-control" type="password" name="mot_de_passe" placeholder="mot de passe" maxlength="60" data-parsley-maxlength="60" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Confirmation de mot de passe</label>
                                            <input class="form-control" type="password" name="mot_de_passe2" placeholder="confirmation mot de passe" maxlength="60" data-parsley-maxlength="60" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Adresse</label>
                                            <input class="form-control" type="text" name="adresse" placeholder="adresse" maxlength="100" data-parsley-maxlength="100" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Ville</label>
                                            <input class="form-control" type="text" name="ville" id="ville" placeholder="ville" maxlength="15" data-parsley-maxlength="15" required />

                                            <label for="name">Code Postal</label>
                                            <input class="form-control" type="number" id="code" name="code_postal" placeholder="code postal" min="0" oninput="validity.valid||(value='');" required />
                                        </div>

                                        <ul class="list-group">
                                            <button class="list-group-item list-group-item-action" data-vicopo="#ville, #code" data-vicopo-click='{"#code": "code", "#ville": "ville"}'>
                                                <strong data-vicopo-code-postal></strong>
                                                <span data-vicopo-ville></span>
                                            </button>
                                        </ul>
                                        <div class="form-group">

                                            <label for="name">Choisir un site</label>

                                            <select class="form-select form-control" name="nom_site" aria-label="Default select example">

                                                <?php
                                                $sql_site = "SELECT id,nom_site FROM t_site";
                                                if ($result_site = mysqli_query($conn, $sql_site)) :
                                                    while ($row_site = mysqli_fetch_assoc($result_site)) :

                                                ?>
                                                        <option value="<?php echo $row_site['id'] ?>"><?php echo $row_site['nom_site'] ?> </option>
                                                <?php
                                                    endwhile;
                                                    mysqli_free_result($result_site);
                                                endif;
                                                ?>


                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Statut</label>
                                            <input class="form-control" type="text" name="statut" placeholder="statut" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Contrat</label>

                                            <select class="form-select form-control" name="select_contrat" aria-label="Default select example">
                                                <option value="CDD">CDD</option>
                                                <option value="CDI">CDI</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Echelon</label>
                                            <input class="form-control" type="number" name="echelon" placeholder="echelon" min="0" oninput="validity.valid||(value='');" required />

                                        </div>
                                        <div class="form-group">
                                            <label for="name">Service</label>

                                            <select class="form-select form-control" name="select_ssiap" aria-label="Default select example">
                                                <option value="SSIAP1">SSIAP 1</option>
                                                <option value="SSIAP2">SSIAP 2</option>
                                                <option value="SSIAP3">SSIAP 3</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="name">Date d'embauche</label>
                                            <input class="form-control" type="date" name="date_embauche" placeholder="date d'embauche" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Date fin de contrat</label>
                                            <input class="form-control" type="date" name="date_fin_contrat" placeholder="date fin de contrat" />
                                        </div>

                                        <label for="formFileMultiple" class="form-label">IMAGE</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choisir image</label>
                                        </div>


                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CARTE PROFESSIONNELLE</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="carte_pro">
                                            <label class="custom-file-label" for="customInput">Choisir votre carte professionnelle</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CARTE D'IDENTITÉ</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="carte_identite">
                                            <label class="custom-file-label" for="customInput">Choisir votre carte d'identité</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CARTE GRISE</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="carte_grise">
                                            <label class="custom-file-label" for="customInput">Choisir votre carte grise</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CARTE VITALE</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="carte_vitale">
                                            <label class="custom-file-label" for="customInput">Choisir votre carte vitale</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">DIPLOME</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="diplome">
                                            <label class="custom-file-label" for="customInput">Choisir votre diplome SSIAP</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">PERMIS</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="permis">
                                            <label class="custom-file-label" for="customInput">Choisir votre permis</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">RIB</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="rib">
                                            <label class="custom-file-label" for="customInput">Choisir votre rib</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CONVENTION COLLECTIVE</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="convention_collective">
                                            <label class="custom-file-label" for="customInput">Choisir votre convention collective</label>
                                        </div>

                                        <label for="formFileMultiple" class="form-label" style="margin-top:15px;">CONTRAT DE TRAVAIL</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="contrat_de_travail">
                                            <label class="custom-file-label" for="customInput">Choisir votre contrat de travail</label>
                                        </div>

                                        <button type="submit" name="ajouter" id="ajouterSubmit" class="btn btn-primary text-nowrap m-1" style="color:#F6F6F6" style="background-color:#32be8f"><i class="fa fa-plus"></i>
                                            <span class="d-none d-lg-inline-block">&nbsp;Ajouter</span>
                                        </button>

                                    </form>
                                </div>
                                <!-- <div class="form-navigation">
                                    <button type="button" class="previous btn btn-info pull-left">&lt; Previous</button>
                                    <button type="button" class="next btn btn-info pull-right">Next &gt;</button>
                                    <input type="submit" class="btn btn-default pull-right">
                                    <span class="clearfix"></span>
                                </div> -->

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>


    <?php include '../template/scripts.php'; ?>






</body>
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
        $("document").ready(function() {
            setTimeout(function() {
                $("#message_id").remove();
            }, 3000);
        });

    });

    function confirmDelete(self) {
        event.preventDefault();
        var id = self.getAttribute("data-id");

        document.getElementById("form-delete-user").id.value = id;
        $("#myModal").modal("show");
    }



    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "search": "Chercher:",
                "infoEmpty": "Il n'y a pas d'enregistrements disponibles.",
                "sInfo": "Affichage de _START_ à _END_ enregistrements sur _TOTAL_",
                "zeroRecords": "Rien trouvé - désolé",
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "infoFiltered": "(filtré à partir de _MAX_ enregistrements au total)",
                "paginate": {
                    "next": "suivant",
                    "previous": "Précédent"
                }
            }

        });
    });

    $('#ajouterForm').parsley();
    $(document).ready(function() {
        Parsley.addMessages('fr', {
            defaultMessage: "Cette valeur semble non valide.",
            type: {
                email: "Cette valeur n'est pas une adresse email valide.",
                url: "Cette valeur n'est pas une URL valide.",
                number: "Cette valeur doit être un nombre.",
                integer: "Cette valeur doit être un entier.",
                digits: "Cette valeur doit être numérique.",
                alphanum: "Cette valeur doit être alphanumérique."
            },
            notblank: "Cette valeur ne peut pas être vide.",
            required: "Ce champ est requis.",
            pattern: "Cette valeur semble non valide.",
            min: "Cette valeur ne doit pas être inférieure à %s.",
            max: "Cette valeur ne doit pas excéder %s.",
            range: "Cette valeur doit être comprise entre %s et %s.",
            minlength: "Cette chaîne est trop courte. Elle doit avoir au minimum %s caractères.",
            maxlength: "Cette chaîne est trop longue. Elle doit avoir au maximum %s caractères.",
            length: "Cette valeur doit contenir entre %s et %s caractères.",
            mincheck: "Vous devez sélectionner au moins %s choix.",
            maxcheck: "Vous devez sélectionner %s choix maximum.",
            check: "Vous devez sélectionner entre %s et %s choix.",
            equalto: "Cette valeur devrait être identique."
        });

        Parsley.setLocale('fr');
    });
</script>

</html>