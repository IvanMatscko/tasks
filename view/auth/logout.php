<?php
    require_once('../../includes/initialize.php');
    unset($_SESSION['logged_user']);
    header('Location: /');
?>