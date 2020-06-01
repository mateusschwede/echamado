<?php
    require_once 'conect.php';
    $msg = null;

    if((!empty($_POST['nome'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("SELECT id FROM cliente WHERE nome=? AND senha=?");
        $r->execute(array($_POST['nome'],$_POST['senha']));
        $r2 = $db->prepare("SELECT id FROM tecnico WHERE nome=? AND senha=?");
        $r2->execute(array($_POST['nome'],$_POST['senha']));
        if($r->rowCount()>0) {
            session_start();
            $_SESSION['nome'] = $_POST['nome'];
            $_SESSION['senha'] = $_POST['senha'];
            $_SESSION['msgm'] = null;
            header("location: pCliente.php");
        } elseif($r2->rowCount()>0) {
            session_start();
            $_SESSION['nome'] = $_POST['nome'];
            $_SESSION['senha'] = $_POST['senha'];
            $_SESSION['msgm'] = null;
            header("location: pTecnico.php");
        } elseif(($_POST['nome']=="admin") and ($_POST['senha']=="111")) {
            session_start();
            $_SESSION['nome'] = $_POST['nome'];
            $_SESSION['senha'] = $_POST['senha'];
            $_SESSION['msgm'] = null;
            header("location: pAdmin.php");
        } else {$msg = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Dado(s) incorreto(s)!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";}
    }
?>

<body id="entrada">
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12">
            <img src="https://img.icons8.com/color/100/000000/technical-support.png">
            <h1>EChamado</h1>
            <h5>Software gestor de suporte tecnico</h5>
            <form action="index.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" required name="nome" maxlength="50" placeholder="Nome" style="text-transform: lowercase;">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" required name="senha" maxlength="5" placeholder="Senha" style="text-transform: lowercase;">
                </div>
                <button type="submit" class="btn btn-secondary">Entrar</button>
            </form>
            <?php if($msg!=null){echo$msg;$msg=null;}?>
        </div>
    </div>


</div>
</body>
</html>