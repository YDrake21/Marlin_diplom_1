<?php
session_start();

function login($email, $password)
{
    // Search email in BD
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "SELECT `id`,`email`, `password`, `is_admin` FROM `diplom_1` WHERE `email` =:email";
    $check = $pdo->prepare($sql);
    $check->execute([':email' => $email]);
    $result = $check->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];

    // If email exist -> compare password and hashed_password:

    // login success
    if (isset($result['email'])) {
        if (password_verify($password, $result['password'])) {
            // Set COOKIE to Logged-in user
            setcookie('user_id', $result['id'], time() + 3600, '/'); // The cookie is valid for 1 hour
            // Set $_SESSION['admin'] if admin
            if (($result['is_admin']) === 'admin') {
                $_SESSION['admin'] = true;
                header("location: users.php");
                exit;
            }
            // if not admin
            unset($_SESSION['admin']);
            header("location: users.php");
            exit;
            // if password incorrect
        } else $_SESSION['message'] = "Password incorrect";
        $_SESSION['color'] = "danger";
        header("location: page_login.php");
        exit;
        // if email incorrect
    } else $_SESSION['message'] = "Incorrect email";
    $_SESSION['color'] = "danger";
    header("location: page_login.php");
    exit;
}

// function 'login'
login($_POST['email'], $_POST['password']);


