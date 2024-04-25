<?php
/*
Если создаст нового пользователя - вернет его id из БД
Если email занят - вернет "Email exists"
 */
function register_user($email, $password)
{
    //Connect to DataBase
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "SELECT `email` FROM `diplom_1` WHERE `email` =:email";
    $check = $pdo->prepare($sql);
    $check->execute([':email' => $email]);
    $result = $check->fetch(PDO::FETCH_ASSOC);


    if (!$result) {
        $sql = "INSERT INTO `diplom_1`(`email`, `password`) VALUES (:email, :password)";
        $check = $pdo->prepare($sql);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $check->execute([':email' => $email, ':password' => $password_hash]);
        $sql_id = "SELECT `id` FROM `diplom_1` WHERE `email` =:email";
        $check_id = $pdo->prepare($sql_id);
        $check_id->execute([':email' => $email]);
        $user_id = $check_id->fetch(PDO::FETCH_ASSOC);

        return $user_id['id'];

    } else return "Email exists";

}

function login($email, $password)
{
    // Search email in BD
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "SELECT `id`,`email`, `password`, `is_admin` FROM `diplom_1` WHERE `email` =:email";
    $check = $pdo->prepare($sql);
    $check->execute([':email' => $email]);
    $result = $check->fetch(PDO::FETCH_ASSOC);


    // If email exist -> compare password and hashed_password:

    // login success
    if (isset($result['email'])) {
        //Set $_SESSION['email'] to display that user's email
        $_SESSION['email'] = $result['email'];
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

/*
Передать нужно $_FILES['filename']['name'] || имя файла
$directory_path = '/Users/YDrake21/Downloads/drive-download-20240328T113025Z-001/uploads/';
*/
function upload_avatar($filename, $directory_path)
{

    foreach ($filename as $key => $file_name) {
        $tmp_name = $_FILES['filename']['tmp_name'][$key];
        $error = $_FILES['filename']['error'][$key];
//Если возникнет ошибка - покажет ее код
        if ($error !== UPLOAD_ERR_OK) {
            echo "Ошибка загрузки файла: " . $error;
        }

// Удаляем лишние точки, запятые и тд
        $old_name = pathinfo($file_name);
        $str_delete = str_replace(['-', '_', ',', '.', ' ', '(', ')'], '', $old_name['filename']);
// Переопределяем имя файла
        $new_filename = uniqid($str_delete) . "." . $old_name['extension'];

// Загружаем в указанную папку
        $target_file = $directory_path . $new_filename;
        if (move_uploaded_file($tmp_name, $target_file)) {
            echo "Ok";
        } else echo "Error";

// Connect to DataBase
        $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');

// Prepare a database query
        $sql = "INSERT INTO `diplom_1` (`avatar`) VALUES (:File_name)";
        $check = $pdo->prepare($sql);
        $check->execute([':File_name' => $new_filename]);
    }
    return "ok";
}
