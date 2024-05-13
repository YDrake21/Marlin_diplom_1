<?php
session_start();
require_once 'functions.php';

set_status($_POST['id'], $_POST['status']);

flash_message('Статус обновлен', 'success');

header("location: users.php");
