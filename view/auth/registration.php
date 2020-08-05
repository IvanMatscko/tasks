<?php
require_once('../../includes/initialize.php');
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>


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
        if (isset($data['registration'])){
            $errors = array();
            if( trim(($data['login']) == '')){
                $errors[] = 'Enter login!';
            }
            if( trim(($data['email']) == '')){
                $errors[] = 'Enter Email!';
            }
            if( trim(($data['password']) == '')){
                $errors[] = 'Enter Password!';
            }
            if( trim(($data['password_2']) != $data['password'])){
                $errors[] = 'The second password was entered incorrectly!';
            }
            if( R::count('users', "login = ?", array($data['login'])) > 0 ){
                $errors[] = 'This login already exists!';
            }
            if( R::count('users', "email = ?", array($data['email'])) > 0 ){
                $errors[] = 'This Email already exists!';
            }
            if( empty($errors)){
                //всё хорошо рег
                $user = R::dispense('users');
                $user->login = $data['login'];
                $user->email = $data['email'];
                $user->password = password_hash($data['password'],
                    PASSWORD_DEFAULT);
                R::store($user);
                echo '<div style="color: green;">Successfully</div><hr>';
            } else{
                echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
            }
        }
        ?>

        <a href="login.php">Login</a>
        <form action="registration.php" method="POST">
            <h1>Registration</h1>
            <div class="form-group">
                <label>Login</label>
                <input type="text" name="login" class="form-control" value="<?php echo @$data['login'];?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo @$data['email'];?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo @$data['password'];?>">
            </div>
            <div class="form-group">
                <label>Password again</label>
                <input type="password" name="password_2" class="form-control" value="<?php echo @$data['password_2'];?>">
            </div>

            <div class="but"><button type="submit" name="registration">Сохранить</button></div>
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
