<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
            $r = $db->prepare("DELETE FROM chamado WHERE id=?");
            $r->execute(array(base64_decode($_GET['id'])));
            $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado removido!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
            header("location: pCliente.php");
    } else {header("location: index.php");}
?>