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
            <div class="log clr">
                <a href="../auth/logout.php">logout</a>
                <a href="#">Name - <?php echo $_SESSION['logged_user']->login; ?></a>
            </div>

            <?php

            if (isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $limit = 3;
            $number = ($page * $limit)- $limit;

            $tasks_total = R::count( 'task' );
            $str_page = ceil($tasks_total / $limit);

            $tasks = R::findAll('task','ORDER BY id LIMIT '.(($page-1)*$limit).', '.$limit);

            $data = $_POST;
            if ($data['sort'] == 'name'){
                $tasks = R::findAll('task','ORDER BY name DESC LIMIT '.(($page-1)*$limit).', '.$limit);

            }
            if ($data['sort'] == 'email'){
                $tasks = R::findAll('task','ORDER BY email DESC LIMIT '.(($page-1)*$limit).', '.$limit);
            }
            if ($data['sort'] == 'checkbox'){
                $tasks = R::findAll('task','ORDER BY checkbox DESC LIMIT '.(($page-1)*$limit).', '.$limit);
            }
            if ($data['sort'] == 'all'){
                $tasks = R::findAll('task','ORDER BY id DESC LIMIT '.(($page-1)*$limit).', '.$limit);
            }

            ?>

            <?php foreach ($tasks as $task):?>
                <div class="block">
                    <div class="item">
                        <div class="form-group">
                            <label>Name</label>
                            <h3><?php echo  $task->name ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <h3><?php echo $task->email ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Task</label>
                            <h3 title="task"><?php echo $task->task ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Checkbox</label>
                            <h3 title="Checkbox">
                                <?php
                                if ($task->checkbox == 1){
                                    echo 'Ready';
                                } else {
                                    echo 'In work';
                                }
                                ?></h3>
                        </div>

                        <a href="/view/admin/edit.php?id_task=<?php echo $task['id'];?>">Edit</a>
                    </div>
                </div>
            <?php endforeach?>
            <div class="pagination clr">
                <?php
                for ($i = 1; $i<=$str_page; $i++){
                    echo " <a href=admin.php?page=".$i.">.$i.</a> ";
                }
                ?>
            </div>

        <?php else: ?>
            <a href="../auth/login.php">login</a>
        <?php endif; ?>
    </div>
</div>
<?php
require_once('../../view/includes/footer.php');
?>
</body>
</html>
