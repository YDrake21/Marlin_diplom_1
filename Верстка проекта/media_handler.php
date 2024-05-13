<?php
session_start();
require_once 'functions.php';

upload_avatar($_POST['id'], $_FILES['avatar'], "/Users/YDrake21/Downloads/Погружение/Верстка проекта/images/");

flash_message('Аватар успешно обновлен', 'success');

header("location: page_profile.php?id={$_POST['id']}");