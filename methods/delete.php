<?php
require_once('../includes/initialize.php');
    if(isset($_GET['id_task'])){
        $id = $_GET['id_task'];
        $ids = [$id];
        $task = R::load('task', $id);
        R::trash($task);
        header('Location: /view/admin/admin.php');
        echo '<div style="color: green;">Successfully.<a href="../view/admin/admin.php">back to admin panel</a> </div><hr>';
    }else{
        $error['status'] = "99";
        $error['message'] = "Required Parameters missing";
        echo json_encode($error);
    }
