<?php
require_once('../../includes/initialize.php');

?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>


    <link href="../../public/css/style.css" rel="stylesheet">
</head>
<body class="clr">
<?php
    require_once('../../view/includes/header.php');
?>

<div class="container">

    <div class="wrapper back">
        <?php if ( isset($_SESSION['logged_user']) ) : ?>
            <a href="../auth/logout.php">logout</a>
            <a href="#">Имя пользователя - <?php echo $_SESSION['logged_user']->login; ?></a>


            <?php

            if(isset($_GET['id_task'])){
                $id = $_GET['id_task'];
                $ids = [$id];
                $tasks = R::find('task', 'id IN (' . R::genSlots($ids) . ')', $ids);

            }else{
                $error['status'] = "99";
                $error['message'] = "Required Parameters missing";
                echo json_encode($error);
            }
            ?>

            <?php foreach ($tasks as $task):?>
                <form class="block edit_form" action="../../methods/update.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $task->id ;?>">
                    <div class="form-group item">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $task->name ;?>">
                    </div>
                    <div class="form-group item">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $task->email ;?>">
                    </div>
                    <div class="form-group item">
                        <label>Task</label>
                        <textarea name="task" class="form-control"><?php echo $task->task ;?></textarea>
                    </div>
                    <div class="form-group item">
                        <label>checkbox</label>
                        <input type="checkbox" name="checkbox" value="1">
                    </div>
                    <div class="form-group item">
                        <div class="but"><button type="submit" name="save">Сохранить</button></div>
                    </div>

                    <div class="form-group item">
                        <a class="form-control" href="/methods/delete.php?id_task=<?php echo $task->id;?>" >Удалить</a>
                    </div>

                </form>
            <?php endforeach?>

        <?php else: ?>
            <a href="../auth/registration.php">Registration</a>
            <a href="../auth/login.php">login</a>
        <?php endif; ?>
    </div>
</div>
<?php
require_once('../../view/includes/footer.php');
?>
</body>
</html>
