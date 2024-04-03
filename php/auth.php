<?php
session_start();

$user_logged = null;

if(isset($_SESSION['user'])) {
    $user_logged = $_SESSION['user'];
}

if(isset($_SESSION['modify_user'])) {
    $user_logged = $_SESSION['modify_user'];
}

// var_dump($_SESSION['modify_user'], $_SESSION['user']);
// die;
