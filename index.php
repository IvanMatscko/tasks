<?php
require_once('includes/initialize.php');
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks</title>


    <link href="../../public/css/style.css" rel="stylesheet">
</head>
<body class="clr">
<?php
require_once('view/includes/header.php');
?>

<div class="container">

    <div class="wrapper back">
        <?php
            $data = $_POST;
            if (isset($data['do_task'])){
                $errors = array();
                if( trim(($data['name']) == '')){
                    $errors[] = 'Enter Name!';
                }
                if( trim(($data['email']) == '')){
                    $errors[] = 'Enter Email!';
                }
                if( R::count('tasks', "email = ?", array($data['email'])) > 0 ){
                    $errors[] = 'This Email already exists!';
                }
                if( trim(($data['task']) == '')){
                    $errors[] = 'Enter Task!';
                }
                if( empty($errors)){
                    //всё хорошо рег
                    $task = R::dispense('task');
                    $task->name = $data['name'];
                    $task->email = $data['email'];
                    $task->task = $data['task'];
                    R::store($task);
                    echo '<div style="color: green;">Successfully</div><hr>';
                } else{
                    echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
                }
            }
        ?>
        <a href="/view/admin/admin.php">Admin</a>
        <form action="index.php" method="POST">
            <h1>Task</h1>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo @$data['name'];?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo @$data['email'];?>">
            </div>

            <div class="form-group">
                <label>Task</label>
                <textarea typeof="text" name="task" class="form-control"></textarea>
            </div>

            <div class="but"><button type="submit" name="do_task">Сохранить</button></div>
        </form>
        <div class="tasks">
            <?php
            for ($i = 1; $i<=$str_page; $i++){
                echo " <a href=index.php?page=".$i.">.$i.</a> ";
            }
            ?>
            <form action="<?php
            for ($i = 1; $i<=$str_page; $i++){
                echo " href=index.php?page=".$i."";
            }
            ?>" method="POST">
                <div class="form-group">
                    <label>Sorting</label>
                    <select name="sort" class="form-control options">
                        <option class="first">Выбрать</option>
                        <option name="name" value="name">Name</option>
                        <option name="email" value="email">Email</option>
                        <option name="checkbox" value="checkbox">Done</option>
                    </select>
                </div>
                <div class="but"><button type="submit" name="sorting">Сохранить</button></div>
            </form>




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
                function my_sort($a, $b){
                    return $a['name'] >= $b['name'];
                }

                usort($tasks, 'my_sort');
            }
            if ($data['sort'] == 'email'){
                function my_sort1($a, $b){
                    return $a['email'] >= $b['email'];
                }

                usort($tasks, 'my_sort1');
            }
            if ($data['sort'] == 'checkbox'){
                function my_sort2($a, $b){
                    return $a['checkbox'] <= $b['checkbox'];
                }

                usort($tasks, 'my_sort2');
            }

            ?>


            <?php foreach ($tasks as $task):?>
                <div class="block">
                    <div class="item">
                        <div class="form-group">
                            <label>Name</label>
                            <h3><?php echo  $task['name'] ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <h3><?php echo $task['email'] ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Task</label>
                            <h3 title="task"><?php echo $task['task'] ;?></h3>
                        </div>
                        <div class="form-group">
                            <label>Checkbox</label>
                            <h3 class="checkbox" title="Checkbox">
                                <?php
                                    if ($task['checkbox'] == 1){
                                        echo 'Ready';
                                    } else {
                                        echo 'In work';
                                    }
                                ?></h3>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
            <div class="pagination clr">
                <?php
                for ($i = 1; $i<=$str_page; $i++){
                    echo " <a href=index.php?page=".$i.">.$i.</a> ";
                }
                ?>
            </div>

        </div>
    </div>
</div>
<?php
    require_once('view/includes/footer.php');
?>
</body>
</html>
