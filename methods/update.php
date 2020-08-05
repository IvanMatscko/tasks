<?php
require_once('../includes/initialize.php');
if(isset($_POST['id'])&&isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['task'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $taskText = $_POST['task'];
    $checkbox = $_POST['checkbox'];
// Загружаем объект с ID = 1
    $task = R::load('task', $id);
    $task->name = $name;
    $task->email = $email;
    $task->task = $taskText;
    $task->checkbox = $checkbox;
    R::store($task);
    echo '<div style="color: green;">Successfully. <a href="../view/admin/admin.php">Back to Admin panel</a> </div><hr>';

}else{
    $error['status'] = "99";
    $error['message'] = "Required Parameters missing";
    echo json_encode($error);
}
