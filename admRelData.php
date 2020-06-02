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
                                <a class="dropdown-item" href="admRelCliente.php">Chamados por cliente</a>
                                <a class="dropdown-item active" href="admRelData.php">Chamados por data</a>
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
            <h1>Chamados por data</h1>
            <form action="admRelData.php" method="post">
                <div class="form-group">
                    <label for="dataChamado">Data</label>
                    <input type="date" required name="dia" id="dataChamado" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Verificar</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <br>
            <?php
            if(!empty($_POST['dia'])) {
                $r = $db->prepare("SELECT * FROM chamado WHERE DATE(dthrCadastro)=? ORDER BY dthrCadastro DESC,situacao,tipo DESC");
                $r->execute(array($_POST['dia']));
                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas as $l) {
                    switch ($l['situacao']) {
                        case "pendente":
                            $borda = "item2";
                            break;
                        case "andamento":
                            $borda = "item3";
                            break;
                        default:
                            $borda = "item1";
                            break;
                    }
                    switch ($l['tipo']) {
                        case "leve":
                            $cor = "#28A745";
                            break;
                        case "moderado":
                            $cor = "#FFC107";
                            break;
                        default:
                            $cor = "#DC3545";
                            break;
                    }
                    echo "
                            <li class='list-group-item' id=".$borda.">
                                <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'>Chamado ".$l['id']."</h5>
                                    <small><b>".$l['dthrCadastro']."</b></small>
                                </div>
                                <p class='mb-1'>Tipo: <span style='color: ".$cor."'><b>".$l['tipo']."</b></span></p>
                                <p class='mb-1'>Situação: ".$l['situacao']."</p>
                        ";
                    $r2 = $db->prepare("SELECT nome FROM maquina WHERE ip=?");
                    $r2->execute(array($l['ipMaquina']));
                    $linhas2 = $r2->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas2 as $l2) {$nomeMaquina = $l2['nome'];}
                    echo "
                                <p class='mb-1'>Máquina: (".$l['ipMaquina'].") ".$nomeMaquina."</p>
                        ";
                    $r3 = $db->prepare("SELECT nome FROM tecnico WHERE id=?");
                    $r3->execute(array($l['idTecnico']));
                    $linhas3 = $r3->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas3 as $l3) {$nomeTecnico = $l3['nome'];}
                    echo "
                                <p class='mb-1'>Técnico: (".$l['idTecnico'].") ".$nomeTecnico."</p>
                        ";
                    $r4 = $db->prepare("SELECT nome FROM cliente WHERE id=?");
                    $r4->execute(array($l['idCliente']));
                    $linhas4 = $r4->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas4 as $l4) {$nomeCliente = $l4['nome'];}
                    echo "
                                <p class='mb-1'>Cliente: (".$l['idCliente'].") ".$nomeCliente."</p>
                        ";
                    if($l['dthrAnalise']!=null) {echo "<p class='mb-1'>Análise: ".$l['dthrAnalise']."</p>";}
                    if($l['dthrFinalizado']!=null) {echo "<p class='mb-1'>Finalizado: ".$l['dthrFinalizado']."</p>";}
                    echo "
                                <p class='mb-1'>Descrição: ".$l['descricao']."</p>
                            </li>
                        ";
                    echo "<br>";
                }
            }
            ?>
        </div>
    </div>


</div>
</body>
</html>