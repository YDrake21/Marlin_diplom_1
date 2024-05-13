<?php
session_start();
require_once 'functions.php';

// If email exist:
$register_result = register_user($_POST['email'], $_POST['password']);
if ($register_result == "Email exists") {
    flash_message('Email занят', 'danger');

    header("location: create_user.php");
    exit;
}
// Здесь $register_result = $id
if (is_int($register_result)) {
    edit_general_info($register_result, $_POST['name'], $_POST['workplace'], $_POST['phone_number'], $_POST['location']);
    change_status($register_result, $_POST['status']);
    if ($_FILES['avatar']['name']!==""){
        upload_avatar($register_result, $_FILES['avatar'], '/Users/YDrake21/Downloads/Погружение/Верстка проекта/images/');
    }

    edit_media_links($register_result, $_POST['vk_link'], $_POST['tg_link'], $_POST['insta_link']);
    flash_message('Пользователь успешно создан', 'success');
    header("location: users.php");
}



