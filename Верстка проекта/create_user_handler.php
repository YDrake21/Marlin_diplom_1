<?php
session_start();
require_once 'functions.php';

$register_result = register_user($_POST['email'], $_POST['password']);
if ($register_result == "Email exists"){
    $_SESSION['message'] = 'Email занят';
    $_SESSION['color'] = 'danger';
    header("location: create_user.php");
    exit;
}
//Пользователь создается, flash выводится


