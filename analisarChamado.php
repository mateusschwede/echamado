<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if(!empty($_GET['id'])) {
        $r = $db->prepare("SELECT id FROM tecnico WHERE nome=? AND senha=?");
        $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {$id=$l['id'];}

        $r = $db->prepare("UPDATE chamado SET situacao='andamento',dthrAnalise=now(),idTecnico=? WHERE id=?");
        $r->execute(array($id,base64_decode($_GET['id'])));
        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado para análise!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: pTecnico.php");
    } else {header("location: index.php");}
?>