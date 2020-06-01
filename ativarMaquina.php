<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['ip'])) {
        $r = $db->prepare("UPDATE maquina SET ativo=1 WHERE ip=?");
        $r->execute(array(base64_decode($_GET['ip'])));
        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Máquina ativada, não possui cliente!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: admMaquina.php");
    } else {header("location: index.php");}
?>