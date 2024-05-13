<?php
session_start();
require_once 'functions.php';

$result = register_user($_POST['email'], $_POST['password']);

if (is_int($result)) {
    flash_message('Регистрация успешна', 'success');
    header("location: page_login.php");
} else if ($result == 'Email exists') {
    $_SESSION['message'] = "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.";
    header("location: page_register.php");
} else echo "Ошибка создания пользователя:" . var_dump(register_user($_POST['email'], $_POST['password']));





