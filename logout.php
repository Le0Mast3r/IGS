<?php

session_start();
session_destroy();

header('location: ./choix_user.php');
