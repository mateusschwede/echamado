<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("SELECT id FROM chamado WHERE idCliente=? AND situacao='andamento'");
        $r->execute(array(base64_decode($_GET['id'])));
        if($r->rowCount()==0) {
            $r = $db->prepare("UPDATE cliente SET ativo=0,ipMaquina=null WHERE id=?");
            $r->execute(array(base64_decode($_GET['id'])));
            $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Cliente id ".base64_decode($_GET['id'])." inativado, máquina disponível!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
            header("location: admCliente.php");
        } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Negado: cliente com chamado em andamento!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";}
    } else {header("location: index.php");}
?>