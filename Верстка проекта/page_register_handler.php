<?php
session_start();

//Connect to DataBase
$pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$sql = "SELECT `email` FROM `diplom_1` WHERE `email` =:email";
$check = $pdo->prepare($sql);
$check->execute([':email' => $email]);
$result = $check->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    $sql = "INSERT INTO `diplom_1`(`email`, `password`) VALUES (:email, :password)";
    $check = $pdo->prepare($sql);
    $check->execute([':email' => $email, ':password' => $password]);
    $_SESSION['message'] = 'Регистрация успешна';
    $_SESSION['color'] = 'success';
    header("location: page_login.php");
    exit;

} else ($_SESSION['message'] = "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
header("location: page_register.php");

var_dump($result);
