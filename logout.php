<?php
    session_start();
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    unset($_SESSION['idTecnico']);
    session_destroy();
    header("location: index.php");
?>