<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("UPDATE chamado SET situacao='andamento',dthrAnalise=now(),idTecnico=? WHERE id=?");
        $r->execute(array($_SESSION['idTecnico'],base64_decode($_GET['id'])));

        $r = $db->prepare("INSERT INTO notificacao(conteudo,tipo,idCliente) VALUES (?,?,?)");
        $conteudo = "O chamado ".base64_decode($_GET['id'])." está sendo analisado pelo técnico (".$_SESSION['idTecnico'].") ".$_SESSION['nome']."";
        $tipo = "analise";
        $r->execute(array($conteudo,$tipo,base64_decode($_GET['id'])));

        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado para análise!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: pTecnico.php");
    } else {header("location: index.php");}
?>