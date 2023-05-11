<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "igs";

    // Create connection
    $conn = mysqli_connect($server, $username, $password, $database);
    mysqli_set_charset($conn,'utf8');
    

    // Check connection
    if (!$conn) {
        die("Erreur de connection de base de données: " . mysqli_connect_error());
    }
    
?>
