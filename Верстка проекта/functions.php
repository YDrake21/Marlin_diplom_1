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

/*
 * Функция использует $_SESSION()
Возвращает:
1.  "success_admin" - если залогинился админ
2.  "success_user" - если залогинился user
3.  "password_incorrect" - если пароль неверный
4.  "email_incorrect" - если email неверный
*/
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
                return "success_admin";

            }
            // if not admin
            unset($_SESSION['admin']);
            return "success_user";

            // if password incorrect
        } else $_SESSION['message'] = "Password incorrect";
        $_SESSION['color'] = "danger";
        return "password_incorrect";

        // if email incorrect
    } else $_SESSION['message'] = "Incorrect email";
    $_SESSION['color'] = "danger";
    return "email_incorrect";
}

/*
 * Работает с множественным выделением
 * Передать нужно $_FILES['avatar'] || имя файла
 * $directory_path = '/Users/YDrake21/Downloads/Погружение/Верстка проекта/images'
*/
function upload_avatar($id, $filename, $directory_path)
{


    // Обработка имени файла
    $old_name = pathinfo($filename['name']);
    $str_delete = str_replace(['-', '_', ',', '.', ' ', '(', ')'], '', $old_name['filename']);
    $new_filename = uniqid($str_delete) . "." . $old_name['extension'];

    // Путь к файлу
    $target_file = $directory_path . $new_filename;

    // Перемещаем файл в указанную папку
    move_uploaded_file($filename['tmp_name'], $target_file);


    // Подключение к базе данных
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');

    // Подготовка запроса к базе данных
    $sql = "UPDATE `diplom_1` SET `avatar`= :File_name WHERE `id` =:id ";
    $check = $pdo->prepare($sql);

    // Выполнение запроса с использованием имени файла
    $check->execute([':File_name' => $new_filename, ':id' => $id]);
}


/*
 * Update SQL values
 */
function edit_general_info($id, $name, $workplace, $phone_number, $location)
{
    //Connect to DataBase and Update
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "UPDATE `diplom_1` SET `name`= :name,`workplace`=:workplace,`phone_number`=:phone_number,`location`=:location WHERE `id` =:id ";
    $check = $pdo->prepare($sql);
    $check->execute([':id' => $id, ':name' => $name, ':workplace' => $workplace, ':phone_number' => $phone_number, ':location' => $location]);

}

/*
 * Update SQL value
 */
function change_status($id, $status)
{
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "UPDATE `diplom_1` SET `status`= :status WHERE `id` =:id ";
    $check = $pdo->prepare($sql);
    $check->execute([':id' => $id, ':status' => $status]);
}

function edit_media_links($id, $vk_link, $tg_link, $insta_link)
{
    $pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
    $sql = "UPDATE `diplom_1` SET `vk`= :vk_link,`tg`=:tg_link,`insta`=:insta_link WHERE `id` =:id ";
    $check = $pdo->prepare($sql);
    $check->execute([':vk_link' => $vk_link, ':tg_link' => $tg_link, ':insta_link' => $insta_link, ':id' => $id]);
}

