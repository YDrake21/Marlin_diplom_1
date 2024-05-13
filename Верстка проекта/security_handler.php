<?php session_start();
require_once 'functions.php';
// Проверяем существует ли введенный email в БД
$pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
$sql = "SELECT `email` FROM `diplom_1` WHERE `id` =:id ";
$check = $pdo->prepare($sql);
$check->execute([':id' => $_POST['user_id']]);
$result = $check->fetch(PDO::FETCH_ASSOC);

if (($result['email'])==$_POST['email']){
    flash_message('email уже занят','danger');
    header("location: page_profile.php?id={$_POST['user_id']}");
    exit;
}

security_edit($_POST['user_id'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
flash_message('Профиль успешно обновлен','success');
header("location: page_profile.php?id={$_POST['user_id']}");
