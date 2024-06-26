<?php session_start();
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
        flash_message('Можно редактировать только свой профиль', 'danger');
        header("location: users.php");
    }
}
//Connect to DataBase
$pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
$sql = "SELECT * FROM `diplom_1` WHERE `id` =:id";
$check = $pdo->prepare($sql);
$check->execute([':id' => $_GET['id']]);
$result = $check->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
    <a class="navbar-brand d-flex align-items-center fw-500" href="users.php"><img alt="logo"
                                                                                   class="d-inline-block align-top mr-2"
                                                                                   src="img/logo.png"> Учебный
        проект</a>
    <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="users.php">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="page_login.php">Войти</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout_handler.php">Выйти</a>
            </li>
        </ul>
    </div>
</nav>
<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Загрузить аватар
        </h1>

    </div>
    <form action="media_handler.php" enctype="multipart/form-data" method="post">

        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Текущий аватар</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <?php if ($result['avatar'] == "") {
                                    $result['avatar'] = 'avatar-m.png';
                                } ?>
                                <img src='images/<?php echo $result['avatar'] ?>' alt="" class="img-responsive"
                                     width="200">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                <input type="file" name="avatar" id="example-fileinput" class="form-control-file">
                            </div>


                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                                <button class="btn btn-warning">Загрузить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>

    $(document).ready(function () {

        $('input[type=radio][name=contactview]').change(function () {
            if (this.value == 'grid') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');

            } else if (this.value == 'table') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }

        });

        //initialize filter
        initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
    });

</script>
</body>
</html>