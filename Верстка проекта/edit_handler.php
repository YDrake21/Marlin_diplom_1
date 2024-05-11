<?php
session_start();
require_once 'functions.php';
edit_general_info($_POST['user_id'], $_POST['name'], $_POST['workplace'], $_POST['phone_number'], $_POST['location']);
$_SESSION['message'] = "Пользователь {$_POST['name']} успешно обновлен";
$_SESSION['name'] = $_POST['name'];
header("location: users.php");
