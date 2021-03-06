<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT nome FROM maquina WHERE ip=?");
    $r->execute(array(base64_decode($_GET['ip'])));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$nome = $l['nome'];}

    if((!empty($_GET['ipVelho'])) and (!empty($_POST['idCliente2']))) {
        $r = $db->prepare("UPDATE cliente SET ipMaquina=? WHERE id=?");
        $r->execute(array($_GET['ipVelho'],$_POST['idCliente2']));
        $_SESSION['msgm'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Máquina atribuida!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><br>";
        header("location: pAdmin.php");
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
                        <li class="nav-item active"><a class="nav-link" href="pAdmin.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="admCliente.php">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admMaquina.php">Máquinas</a></li>
                        <li class="nav-item"><a class="nav-link" href="admTecnico.php">Técnicos</a></li>
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
            <h1>Atribuir cliente à <?=$nome?></h1>
            <form action="atrMaquinaCliente.php?ipVelho=<?=base64_decode($_GET['ip'])?>" method="post">
                <div class="form-group">
                    <label for="selectCliente">Cliente</label>
                    <select class="form-control" required name="idCliente2" id="selectCliente">
                        <?php
                            $r = $db->query("SELECT * FROM cliente WHERE ativo=1 AND ipMaquina is null ORDER BY nome");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                                echo "<option value=".$l['id'].">".$l['id']."- ".$l['nome']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='pAdmin.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Atribuir</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>