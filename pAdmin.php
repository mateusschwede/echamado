<?php
    require_once 'conect.php';
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}
?>

<body id="fundo2">
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
        <div class="col-sm-12" style="padding: 3%;">
            <h1>Bem-vindo!</h1>
            <?php if($_SESSION['msgm']!=null){echo $_SESSION['msgm'];$_SESSION['msgm']=null;}?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <ul class="list-group">
                <?php
                    $r = $db->query("SELECT count(id) FROM chamado");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "<li class='list-group-item list-group-item-success'><h5 class='mb-1'>".$l['count(id)']." chamados registrados</li>";}
                    $r = $db->query("SELECT count(id) FROM cliente");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "<li class='list-group-item list-group-item-warning'><h5 class='mb-1'>".$l['count(id)']." clientes registrados</li>";}
                    $r = $db->query("SELECT count(id) FROM tecnico");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "<li class='list-group-item list-group-item-dark'><h5 class='mb-1'>".$l['count(id)']." técnicos registrados</li>";}
                    $r = $db->query("SELECT count(ip) FROM maquina");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {echo "<li class='list-group-item list-group-item-danger'><h5 class='mb-1'>".$l['count(ip)']." máquinas registradas</li>";}
                ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <br>
            <h3>Clientes sem máquinas</h3>
            <small>*Clientes ativos</small>
            <ul class="list-group">
                <?php
                    $r = $db->query("SELECT * FROM cliente WHERE ativo=1 AND ipMaquina is null ORDER BY nome");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        echo "
                            <li class='list-group-item' id='item3'>
                                <h5 class='mb-1'>(".$l['id'].") ".$l['nome']."</h5>
                                <a class='btn btn-danger btn-sm' href='inativarCliente.php?id=".base64_encode($l['id'])."'>Inativar</a>
                                <a class='btn btn-success btn-sm' href='atrClienteMaquina.php?id=".base64_encode($l['id'])."'>Atribuir</a>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </div>
        <div class="col-sm-6">
            <br>
            <h3>Máquinas sem clientes</h3>
            <small>*Máquinas ativas</small>
            <ul class="list-group">
                <?php
                    $r = $db->query("SELECT * FROM maquina WHERE ativo=1 ORDER BY nome");
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        $r = $db->prepare("SELECT ipMaquina FROM cliente WHERE ipMaquina=?");
                        $r->execute(array($l['ip']));
                        if($r->rowCount()==0) {
                            echo "
                                <li class='list-group-item' id='item3'>
                                    <h5 class='mb-1'>(".$l['ip'].") ".$l['nome']."</h5>
                                    <a class='btn btn-danger btn-sm' href='inativarMaquina.php?ip=".base64_encode($l['ip'])."'>Inativar</a>
                                    <a class='btn btn-success btn-sm' href='atrMaquinaCliente.php?ip=".base64_encode($l['ip'])."'>Atrbuir</a>
                                </li>
                            ";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>


</div>
</body>
</html>