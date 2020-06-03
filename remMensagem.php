<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("DELETE FROM notificacao WHERE id=?");
        $r->execute(array(base64_decode($_GET['id'])));
        header("location: mensagem.php");
    } else {header("location: index.php");}
?>