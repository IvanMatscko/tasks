<?php
require_once('../../includes/initialize.php');

?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>


    <link href="../../public/css/style.css" rel="stylesheet">
</head>
<body class="clr">

<div class="container">
    <?php
    require_once('../../view/includes/header.php');
    ?>

    <div class="wrapper back">
        <?php
        $data = $_POST;
        if (isset($data['do_login'])){
            $errors = array();
            $user = R::findOne('users', 'login = ?', array($data['login']));
            if ( $user ) {
                //логин существует
                if ( password_verify($data['password'], $user->password)){
                    $_SESSION['logged_user'] = $user;
                    echo '<a href="/view/admin/admin.php" style="color: green;">Authorization successful Go to Admin</a><hr>';
                }else{
                    $errors[] = 'Wrong password';
                }
            } else {
                $errors[] = 'User is not found';
            }
            if( ! empty($errors)){

                echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
            }

        }
        ?>
        <a href="registration.php">Registration</a>

        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="form-group">
                <label>Login</label>
                <input type="text" name="login" class="form-control" value="<?php echo @$data['login'];?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo @$data['password'];?>">
            </div>

            <div class="but"><button type="submit" name="do_login">Войти</button></div>
        </form>
    </div>
</div>
<footer>
    <div class="wrapper">
        <div class="logo"><a href="index.php" title="Главная"><img alt="Главная" title="Главная" src="/public/img/kisspngfff.png"><h3>Авторские книги</h3></a></div>
        <script src="public/js/js.js"></script>
    </div>
</footer>
</body>
</html>
