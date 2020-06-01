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
                        <li class="nav-item"><a class="nav-link" href="admCliente.php">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="admMaquina.php">Máquinas</a></li>
                        <li class="nav-item"><a class="nav-link" href="admTecnico.php">Técnicos</a></li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="relatorios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Relatórios</a>
                            <div class="dropdown-menu" aria-labelledby="relatorios">
                                <a class="dropdown-item active" href="admRelCliente.php">Chamados por cliente</a>
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
            <h1>Chamados por cliente</h1>
            <form action="admRelCliente.php" method="post">
                <div class="form-group">
                    <label for="selectCliente">Cliente</label>
                    <select class="form-control" required name="idCliente" id="selectCliente">
                        <?php
                            $r = $db->query("SELECT id,nome,ativo FROM cliente ORDER BY nome,ativo");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                                if($l['ativo']==0) {echo "<option value=".$l['id'].">".$l['id']."- ".$l['nome']." (inativo)</option>";}
                                else {echo "<option value=".$l['id'].">".$l['id']."- ".$l['nome']."</option>";}
                            }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='admCliente.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Verificar</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
                if(!empty($_POST['idCliente'])) {
                    //Executa aqui
                }
            ?>
        </div>
    </div>


</div>
</body>
</html>