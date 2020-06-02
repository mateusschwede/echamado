<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['ip'])) {
        $r = $db->prepare("SELECT ipMaquina FROM chamado WHERE ipMaquina=? AND (situacao='andamento' OR situacao='pendente')");
        $r->execute(array(base64_decode($_GET['ip'])));
        if($r->rowCount()==0) {
            $r = $db->prepare("UPDATE cliente SET ipMaquina=null WHERE ipMaquina=?");
            $r->execute(array(base64_decode($_GET['ip'])));
            $r = $db->prepare("UPDATE maquina SET ativo=0 WHERE ip=?");
            $r->execute(array(base64_decode($_GET['ip'])));
            $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Máquina inativada, cliente sem máquina!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
            header("location: admMaquina.php");
        } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Negado: máquina com chamado em andamento!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>"; header("location: admMaquina.php");}
    } else {header("location: index.php");}
?>