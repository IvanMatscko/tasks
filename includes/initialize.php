<?php

    require_once ('rb.php');
    R::setup( 'mysql:host=localhost;dbname=tasks',
    'root', '' ); //for both mysql or mariaDB

session_start();