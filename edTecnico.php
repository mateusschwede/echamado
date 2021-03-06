<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT nome,senha FROM tecnico WHERE id=?");
    $r->execute(array(base64_decode($_GET['id'])));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$nome = $l['nome']; $senha = $l['senha'];}

    if((!empty($_GET['idVelho'])) and (!empty($_POST['nome2'])) and (!empty($_POST['senha2']))) {
        $r = $db->prepare("SELECT nome,senha FROM tecnico WHERE nome=? AND senha=? AND id!=?");
        $r->execute(array($_POST['nome2'],$_POST['senha2'],$_GET['idVelho']));
        if($r->rowCount()==0) {
            $r = $db->prepare("SELECT nome FROM cliente WHERE nome=? AND senha=?");
            $r->execute(array($_POST['nome2'],$_POST['senha2']));
            if($r->rowCount()==0) {
                $r = $db->prepare("UPDATE tecnico SET nome=?,senha=? WHERE  id=?");
                $r->execute(array($_POST['nome2'], $_POST['senha2'], $_GET['idVelho']));
                $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Técnico atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
                header("location: admTecnico.php");
            } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Cliente já existente com esse cadastro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>"; header("location: admTecnico.php");}
        } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Outro técnico já existente!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>"; header("location: admTecnico.php");}
    }
?>

<body id="fundo">
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12" id="menu">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="pAdmin.php"><img src="https://img.icons8.com/color/48/000000/technical-support.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> EChamado</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="pAdmin.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="admCliente.php">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admMaquina.php">Máquinas</a></li>
                        <li class="nav-item active"><a class="nav-link" href="admTecnico.php">Técnicos</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="relatorios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Relatórios</a>
                            <div class="dropdown-menu" aria-labelledby="relatorios">
                                <a class="dropdown-item" href="admRelCliente.php">Chamados por cliente</a>
                                <a class="dropdown-item" href="admRelData.php">Chamados por data</a>
                                <a class="dropdown-item" href="admRelMaquina.php">Chamados por máquina</a>
                                <a class="dropdown-item" href="admRelTecnico.php">Chamados por tecnico</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" style="color:tomato;">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Editar técnico</h1>
            <form action="edTecnico.php?idVelho=<?=base64_decode($_GET['id'])?>" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="nome" required name="nome2" maxlength="50" style="text-transform: lowercase" value="<?=$nome?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="senha" required name="senha2" maxlength="5" style="text-transform: lowercase" value="<?=$senha?>">
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='admTecnico.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Atualizar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>