<?php session_start();
require_once 'functions.php';

?>

<?php
// Если COOKIE истекают - страница загружается, но с ошибкой "неизвестный ключ $_COOKIE['user_id']"
if (!isset($_COOKIE['user_id'])) {
    logout();
};
//Если не авторизован - на страницу авторизации
is_authorized($_SESSION['email'], 'page_login.php');
?>
<!-- Connect to DataBase -->
<?php
$pdo = new PDO("mysql:host=localhost;dbname=study;", 'root', 'root');
$sql = "SELECT * FROM `diplom_1`";
$check = $pdo->prepare($sql);
$check->execute();
$result = $check->fetchall(PDO::FETCH_ASSOC);
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
<body class="mod-bg-1 mod-nav-link">
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
            <li class="nav-item active">
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
<!--Flash-message if registration Success -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['color'] ?>">
        <?php echo $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
    <?php unset($_SESSION['color']); endif; ?>
<main id="js-page-content" role="main" class="page-content mt-3">


    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> Список пользователей <br>
            <?php if (is_admin($_COOKIE['user_id'], $_SESSION['admin_id']) == 'success'): ?>
                <?php $name = $_SESSION['admin_name']; ?>
            <?php else: ?>
                <?php $name = $_SESSION['name']; ?>
            <?php endif ?>

            <i></i> <span style="color: rgba(215,1,6,0.84);">Hello,</span>
            <i></i> <span style="color: rgb(255,215,0);"><?php echo $name; ?></span>

        </h1>


    </div>
    <div class="row">
        <div class="col-xl-12">
            <!--If ADMIN {show "Добавить" button}  -->

            <?php if (is_admin($_COOKIE['user_id'], $_SESSION['admin_id']) == 'success'): ?>

                <a class="btn btn-success" href="create_user.php">Добавить</a>


            <?php endif; ?>


        </div>

    </div>
    <br><div class="row" id="js-contacts">
        <!-- Start Profile Card -->
        <?php foreach ($result as $user): ?>
            <div class="col-xl-4">
                <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover"
                     data-filter-tags="<?php echo $user['name'] ?>">
                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                        <div class="d-flex flex-row align-items-center">
                                <span class="status status-<?php echo $user['status'] ?> mr-3">
                                    <span class="rounded-circle profile-image d-block "
                                          <?php if ($user['avatar'] == "") {
                                              $user['avatar'] = 'avatar-m.png';
                                          } ?>
                                          style="background-image:url('images/<?php echo $user['avatar'] ?>'); background-size: cover;"></span>
                                </span>
                            <div class="info-card-text flex-1">
                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info"
                                   data-toggle="dropdown" aria-expanded="false">
                                    <?php echo $user['name'] ?>
                                    <?php if (is_admin($_COOKIE['user_id'], $_SESSION['admin_id']) == 'success' || $_SESSION['email'] === $user['email']): ?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    <?php endif ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="edit.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                    <a class="dropdown-item" href="security.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                    <a class="dropdown-item"
                                       href="status.php?id=<?php echo $user['id'] ?>&status=<?php echo $user['status'] ?>">
                                        <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                    <a class="dropdown-item" href="page_profile.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-sun"></i>
                                        Профиль</a>
                                    <a class="dropdown-item" href="media.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-camera"></i>
                                        Загрузить аватар
                                    </a>
                                    <a href="delete_handler.php?id=<?php echo $user['id'] ?>" class="dropdown-item"
                                       onclick="return confirm('are you sure?');">
                                        <i class="fa fa-window-close"></i>
                                        Удалить
                                    </a>
                                </div>
                                <span class="text-truncate text-truncate-xl"><?php echo $user['job_title'] ?></span>
                            </div>
                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse"
                                    data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                <span class="collapsed-hidden">+</span>
                                <span class="collapsed-reveal">-</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 collapse show">
                        <div class="p-3">
                            <a href="tel:<?php echo $user['phone_number'] ?>"
                               class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i> <?php echo $user['phone_number'] ?>
                            </a>
                            <a href="<?php
                            echo $user['email'];
                            ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?php echo $user['email'] ?></a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i> <?php
                                echo $user['location']
                                ?>
                            </address>
                            <div class="d-flex flex-row">
                                <a href="https://<?php echo $user['vk'] ?>" class="mr-2 fs-xxl" style="color:#4680C2">
                                    <i class="fab fa-vk">
                                    </i>
                                </a>
                                <a href="https://<?php echo $user['tg'] ?>" class="mr-2 fs-xxl" style="color:#38A1F3">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a href="https://<?php echo $user['insta'] ?>" class="mr-2 fs-xxl" style="color:#E1306C">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- END Profile Card -->

    </div>
</main>

<!-- BEGIN Page Footer -->
<footer class="page-footer" role="contentinfo">
    <div class="d-flex align-items-center flex-1 text-muted">
        <span class="hidden-md-down fw-700">2024 Первый проект</span>
    </div>
    <div>

    </div>
</footer>

</body>

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
</html>