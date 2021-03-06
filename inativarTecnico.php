<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("SELECT idTecnico FROM chamado WHERE idTecnico=? AND situacao='pendente'");
        $r->execute(array(base64_decode($_GET['id'])));
        if($r->rowCount()==0) {
            $r = $db->prepare("UPDATE tecnico SET ativo=0 WHERE id=?");
            $r->execute(array(base64_decode($_GET['id'])));
            $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Técnico inativado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
            header("location: admTecnico.php");
        } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Negado: técnico com chamado em andamento!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>"; header("location: admTecnico.php");}
    } else {header("location: index.php");}
?>