<?php
session_start();

require_once 'functions.php';

login($_POST['email'], $_POST['password']);


