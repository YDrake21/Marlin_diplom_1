<?php
session_start();
require_once 'functions.php';

//Проверка авторизован ли пользователь
is_authorized($_COOKIE['user_id'], "page_login.php");

// Проверяем, установлено ли значение 'id' в GET-запросе
if (!isset($_GET['id'])) {
    echo "ID не указан!";
    exit;
}
// Проверка: админ ли планирует редактировать пользователя или нет?
if ($_GET['id'] != $_COOKIE['user_id']) {
    if (is_admin($_COOKIE['user_id'], $_SESSION['admin_id']) !== 'success') {
        flash_message('Можно удалить только свой профиль', 'danger');
        header("location: users.php");
    }
}
//Connect to DataBase AND Delete User
$pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
$sql = "SELECT `avatar` FROM `diplom_1` WHERE `id` =:id";
$check = $pdo->prepare($sql);
$check ->execute([':id' => $_GET['id']]);
$image_name = $check ->fetch(PDO::FETCH_ASSOC);

$way_to_file = "images/" . $image_name['avatar'];

//Delete file from images
if (file_exists($way_to_file)) {
    unlink($way_to_file);

    if (is_admin($_COOKIE['user_id'], $_SESSION['admin_id']) === 'success') {
        $sql = "DELETE FROM `diplom_1` WHERE `id` =:id";
        $pdo->prepare($sql)->execute([':id' => $_GET['id']]);
        flash_message('Пользователь удален', 'success');
        header("location: users.php");
        exit;
    }
    $sql = "DELETE FROM `diplom_1` WHERE `id` =:id";
    $pdo->prepare($sql)->execute([':id' => $_GET['id']]);
    logout();
    header("location: page_register.php");}






