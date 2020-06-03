<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("UPDATE chamado SET situacao='finalizado',dthrFinalizado=now() WHERE id=?");
        $r->execute(array(base64_decode($_GET['id'])));

        $r = $db->prepare("INSERT INTO notificacao(conteudo,tipo,idCliente) VALUES (?,?,?)");
        $conteudo = "O chamado ".base64_decode($_GET['id'])." está finalizado pelo técnico (".$_SESSION['idTecnico'].") ".$_SESSION['nome']."";
        $r->execute(array($conteudo,"finalizado",base64_decode($_GET['id2'])));

        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado finalizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: pTecnico.php");
    } else {header("location: index.php");}
?>