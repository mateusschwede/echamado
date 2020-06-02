<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT id FROM tecnico WHERE nome=? AND senha=?");
    $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$id=$l['id'];}
?>

<body id="fundo">
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12" id="menu">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="pTecnico.php"><img src="https://img.icons8.com/color/48/000000/technical-support.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> EChamado</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="pTecnico.php">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="tecRelFinalizados.php">Finalizados</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" style="color:tomato;"><?=$_SESSION['nome']?>-logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php if($_SESSION['msgm']!=null){echo $_SESSION['msgm'];$_SESSION['msgm']=null;}?>
            <h2>Meus chamados</h2>
            <div class="list-group">
                <?php
                    $r = $db->prepare("SELECT * FROM chamado WHERE idTecnico=? AND situacao='finalizado' ORDER BY dthrCadastro DESC,tipo DESC");
                    $r->execute(array($id));
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
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
                            <li class='list-group-item' id='item1'>
                                <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'>Chamado ".$l['id']."</h5>
                                    <small>".$l['dthrCadastro']."</small>
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
                                <p class='mb-1'>Análise: ".$l['dthrAnalise']."</p>
                                <p class='mb-1'>Finalizado: ".$l['dthrFinalizado']."</p>
                                <p class='mb-1'>Descrição: ".$l['descricao']."</p>
                            </li>
                        ";
                        echo "<br>";
                    }
                ?>
            </div>
            <br>
        </div>
    </div>


</div>
</body>
</html>