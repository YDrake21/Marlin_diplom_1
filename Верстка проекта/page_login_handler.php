<?php
session_start();

require_once 'functions.php';

$result = login($_POST['email'], $_POST['password']);

switch ($result) {
    case "success_admin" :
    case "success_user"  :
        header("location: users.php");
        break;
    case "password_incorrect" :
    case "email_incorrect" :
        header("location: page_login.php");
        break;
}
