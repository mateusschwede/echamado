<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if((!empty($_POST['descricao'])) and (!empty($_POST['tipo']))) {
        //dados à add(descricao,tipo,ipMaquina,idCliente)
        $r = $db->prepare("SELECT id,ipMaquina FROM cliente WHERE nome=? AND senha=?");
        $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach($linhas as $l) {
            if($l['ipMaquina']!=null) {
                $r = $db->prepare("INSERT INTO chamado(descricao,tipo,ipMaquina,idCliente) VALUES (?,?,?,?)");
                $r->execute(array($_POST['descricao'],$_POST['tipo'],$l['ipMaquina'],$l['id']));
                $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Chamado adicionado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
                header("location: pCliente.php");
            } else {$_SESSION['msgm'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Cliente não possui máquina!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>"; header("location: pCliente.php");}
        }
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
                        <li class="nav-item"><a class="nav-link" href="cliRelFinalizados.php">Histórico</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" style="color:tomato;"><?=$_SESSION['nome']?>-logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Novo chamado</h1>
            <form action="addChamado.php" method="post">
                <div class="form-group">
                    <textarea class="form-control" rows="3" maxlength="500" required name="descricao" placeholder="descrição" style="text-transform: lowercase; resize: none;"></textarea>
                </div>
                <div class="form-group">
                    <label for="selectTipo">Tipo</label>
                    <select class="form-control" id="selectTipo" required name="tipo">
                        <option value="leve">Leve</option>
                        <option value="moderado">Moderado</option>
                        <option value="urgnte">Urgente!</option>
                    </select>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='pCliente.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Adicionar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>