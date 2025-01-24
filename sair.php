<?php 
    session_start();
    unset($_SESSION['id_admin']);
    unset($_SESSION['id_funcionario']);
    header('Location: index.php');
    exit();
?>