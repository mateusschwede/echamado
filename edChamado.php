<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT id FROM cliente WHERE nome=? AND senha=?");
    $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$id=$l['id'];}

    $r = $db->prepare("SELECT count(id) FROM notificacao WHERE idCliente=?");
    $r->execute(array($id));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$not = "<small><span class='badge badge-pill badge-danger'>".$l['count(id)']."</span></small>";}

    $r = $db->prepare("SELECT descricao,tipo FROM chamado WHERE id=?");
    $r->execute(array(base64_decode($_GET['id'])));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$descricao = $l['descricao']; $tipo = $l['tipo'];}

    if((!empty($_GET['idVelho'])) and (!empty($_POST['descricao2'])) and (!empty($_POST['tipo2']))) {
        $r = $db->prepare("UPDATE chamado SET descricao=?,tipo=? WHERE id=?");
        $r->execute(array($_POST['descricao2'],$_POST['tipo2'],$_GET['idVelho']));
        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: pCliente.php");
    }
?>

<body id="fundo">
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12" id="menu">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="pCliente.php"><img src="https://img.icons8.com/color/48/000000/technical-support.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> EChamado</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="pCliente.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="mensagem.php">Mensagens<?=$not?></a></li>
                        <li class="nav-item"><a class="nav-link" href="cliRelFinalizados.php">Histórico</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" style="color:tomato;"><?=$_SESSION['nome']?>-logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Editar chamado <?=base64_decode($_GET['id'])?></h1>
            <form action="edChamado.php?idVelho=<?=base64_decode($_GET['id'])?>" method="post">
                <div class="form-group">
                    <textarea class="form-control" rows="3" maxlength="500" required name="descricao2" placeholder="descrição" style="text-transform: lowercase; resize: none;"><?=$descricao?></textarea>
                </div>
                <div class="form-group">
                    <label for="selectTipo">Tipo</label>
                    <select class="form-control" id="selectTipo" required name="tipo2">
                        <option value="<?=$tipo?>"><?=$tipo?>(atual)</option>
                        <option value="leve">Leve</option>
                        <option value="moderado">Moderado</option>
                        <option value="urgente">Urgente!</option>
                    </select>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='pCliente.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Atualizar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>