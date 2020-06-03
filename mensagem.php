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
                        <li class="nav-item"><a class="nav-link" href="pCliente.php">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="mensagem.php">Mensagens<?=$not?></a></li>
                        <li class="nav-item"><a class="nav-link" href="cliRelFinalizados.php">Histórico</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" style="color:tomato;"><?=$_SESSION['nome']?>-logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php if($_SESSION['msgm']!=null){echo $_SESSION['msgm'];$_SESSION['msgm']=null;}?>
            <h2>Mensagens recebidas</h2>
            <div class="list-group">
                <?php
                $r = $db->prepare("SELECT * FROM notificacao WHERE idCliente=? ORDER BY id DESC");
                $r->execute(array($id));
                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas as $l) {
                    switch ($l['tipo']) {
                        case "analise":
                            echo "
                                <li class='list-group-item' id='item3'>
                                    <div class='d-flex w-100 justify-content-between'>
                                        <h5 class='mb-1'>Chamado em análise</h5>
                                    </div>
                                    <p class='mb-1'>".$l['conteudo']."</p>
                                    <a class='btn btn-danger btn-sm' href='remMensagem.php?id=".base64_encode($l['id'])."'>Excluir</a>
                                </li>
                            ";
                            break;
                        default:
                            echo "
                                <li class='list-group-item' id='item1'>
                                    <div class='d-flex w-100 justify-content-between'>
                                        <h5 class='mb-1'>Chamado finalizado!</h5>
                                    </div>
                                    <p class='mb-1'>".$l['conteudo']."</p>
                                    <a class='btn btn-danger btn-sm' href='remMensagem.php?id=".base64_encode($l['id'])."'>Excluir</a>
                                </li>
                            ";
                            break;
                    }
                }
                ?>
            </div>
        </div>
    </div>


</div>
</body>
</html>