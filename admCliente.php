<?php
require_once 'conect.php';
session_start();
if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}
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
                        <li class="nav-item active"><a class="nav-link" href="admCliente.php">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admMaquina.php">Máquinas</a></li>
                        <li class="nav-item"><a class="nav-link" href="admTecnico.php">Tecnicos</a></li>
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
            <h1>Clientes</h1>
            <?php if($_SESSION['msgm']!=null){echo $_SESSION['msgm'];$_SESSION['msgm']=null;}?>
            <a class="btn btn-secondary btn-sm" href="addCliente.php">Adicionar</a>
            <div class="list-group">
                <?php
                    $r = $db->query("SELECT * FROM cliente WHERE ativo=1 ORDER BY nome");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        echo "
                            <li class='list-group-item' id='item1'>
                                <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'>".$l['id']."- ".$l['nome']."</h5>
                                    <small>".$l['ipMaquina']."</small>
                                </div>
                                <p class='mb-1'>Senha: ".$l['senha']."</p>
                                <a class='btn btn-warning btn-sm' href='edCliente.php?id=".base64_encode($l['id'])."'>Editar</a>
                                <a class='btn btn-danger btn-sm' href='inativarCliente.php?id=".base64_encode($l['id'])."'>Inativar</a>
                            </li>
                        ";
                    }
                ?>
            </div>
            <br>
            <h4>Inativos</h4>
            <div class="list-group">
                <?php
                    $r = $db->query("SELECT * FROM cliente WHERE ativo=0 ORDER BY nome");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        echo "
                            <li class='list-group-item' id='item2'>
                                <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'>".$l['id']."- ".$l['nome']."</h5>
                                    <small>".$l['ipMaquina']."</small>
                                </div>
                                <p class='mb-1'>Senha: ".$l['senha']."</p>
                                <a class='btn btn-success btn-sm' href='ativarCliente.php?id=".base64_encode($l['id'])."'>Ativar</a>
                            </li>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>


</div>
</body>
</html>