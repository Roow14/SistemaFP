<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) 
{
session_destroy();
header("Location: ../../index.html"); exit;
}

$UsuarioID = $_SESSION['UsuarioID'];
?>

<style type="text/css">
    .input-group {
        padding-left: 15px; 
        padding-right: 15px; 
        margin-top: 5px;

    }
    .input-group input {
        background-color: #f1f1f1;

    }
    .input-group button {
        color: #fff;
        background-color: #5cb85c;
        border-color: #4cae4c;

    }
    
    .input-group button:hover {
        color: #fff;
        background-color: #449d44;

    }
    li .badge {
        position: relative;
        float: right;
        padding: 6px 12px;
        margin-top: -32px;
        margin-right: 15px;

    }
    #sidebar ul.components {
        padding: 0;
        border-bottom: 1px solid #999;


    }
nav#sidebar {
    background: rgba(0,0,0,0.3);
}

</style>

<nav id="sidebar" class="hidden-print">
    <div class="sidebar-header">
        <img src="/fisiopeti/img/logo-fisiopeti.png" style="width: 100%;">
    </div>

    <?php
    if ($_SESSION['UsuarioNivel'] > 1) {
        ?>
        <ul class="list-unstyled components">
            <li><a href="/fisiopeti/content/agenda/">Agenda</a></li>
            <!-- <li><a href="/fisiopeti/content/agenda/visao-geral.php">Visão geral</a></li>  -->
            <li>
                <a href="#Paciente" data-toggle="collapse" aria-expanded="false">Paciente</a>
                <ul class="collapse list-unstyled" id="Paciente">
                    <li><a href="/fisiopeti/content/paciente/">Listar pacientes</a></li>
                    <li><a href="/fisiopeti/content/paciente/cadastrar-paciente-novo.php">Cadastrar paciente</a></li>
                </ul>
            </li>

            <li>
                <a href="#Profissional" data-toggle="collapse" aria-expanded="false">Terapeuta</a>
                <ul class="collapse list-unstyled" id="Profissional">
                    <li><a href="/fisiopeti/content/profissional/listar-profissionais.php">Listar terapeutas</a></li>
                    <li><a href="/fisiopeti/content/profissional/cadastrar-profissional.php">Cadastrar terapeuta</a></li>
                </ul>
            </li>
            <li><a href="/fisiopeti/content/convenio/home.php">Convênio</a></li>
            <li><a href="/fisiopeti/content/analise/">Relatório</a></li>
            <li><a href="/fisiopeti/content/agenda/visao-geral.php">Visão geral</a></li>

            <li>
                <form action="/fisiopeti/content/paciente/pesquisar-paciente.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Paciente" name="PesquisaPaciente">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>

            <li>
                <form action="/fisiopeti/content/profissional/pesquisar-profissional.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Profissional" name="PesquisaProfissional">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>

            <li><a href="/fisiopeti/content/configuracao/configuracao.php">Configuração</a></li>
        </ul>
        <?php
    } else {
        ?>
        <ul class="list-unstyled components">
            <li><a href="/fisiopeti/content/profissional/agenda-profissional.php?id_profissional=<?php echo $UsuarioID;?>">Agenda</a></li>
            <li><a href="/fisiopeti/content/profissional/profissional.php?id_profissional=<?php echo $UsuarioID;?>">Profissional</a></li>
            <li><a href="/fisiopeti/content/paciente/listar-pacientes-1.php">Listar pacientes</a></li>
        </ul>
        <?php
    }
    ?>
</nav>