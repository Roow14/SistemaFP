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
</style>

<nav id="sidebar" class="hidden-print">
    <div class="sidebar-header">
        <img src="/fisiopeti/img/logo-fisiopeti.png" style="width: 100%;">
    </div>

    <?php
    if ($_SESSION['UsuarioNivel'] > 1) {
        ?>
        <ul class="list-unstyled components">
            <li><a href="/fisiopeti/content/agenda/visao-geral.php">Visão geral</a></li>
            <li><a href="/fisiopeti/content/paciente/paciente.php?id_paciente=<?php echo $id_paciente;?>">Dados do paciente</a></li>
            <!-- <li><a href="/fisiopeti/content/paciente/diagnostico-paciente.php?id_paciente=<?php echo $id_paciente;?>">Diagnóstico</a></li> -->
            <li><a href="/fisiopeti/content/paciente/convenio-paciente.php?id_paciente=<?php echo $id_paciente;?>">Convênio</a></li>
            <li><a href="/fisiopeti/content/avaliacao/index.php?id_paciente=<?php echo $id_paciente;?>">Plano terapêutico</a></li>
            <li><a href="/fisiopeti/content/exame/index.php?id_paciente=<?php echo $id_paciente;?>">Dados médicos</a></li>
            <li><a href="/fisiopeti/content/agenda/agenda-paciente.php?id_paciente=<?php echo $id_paciente;?>">Agenda</a></li>
            <!-- <li>
                <a href="#Exame" data-toggle="collapse" aria-expanded="false">Exame</a>
                <ul class="collapse list-unstyled" id="Exame">
                    <li><a href="/fisiopeti/content/paciente/listar-pedidos-medicos.php?id_paciente=<?php echo $id_paciente;?>">Listar exames do paciente</a></li>
                    <li><a href="/fisiopeti/content/paciente/cadastrar-pedido-medico.php?id_paciente=<?php echo $id_paciente;?>">Cadastrar exame do paciente</a></li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="#Terapia" data-toggle="collapse" aria-expanded="false">Terapia</a>
                <ul class="collapse list-unstyled" id="Terapia">
                    <li><a href="/fisiopeti/content/paciente/listar-terapias-solicitadas.php?id_paciente=<?php echo $id_paciente;?>">Encaminhamento médico</a></li>
                    <li><a href="/fisiopeti/content/paciente/listar-terapias-realizadas.php?id_paciente=<?php echo $id_paciente;?>">Terapias realizadas</a></li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="#Avaliacao" data-toggle="collapse" aria-expanded="false">Avaliação</a>
                <ul class="collapse list-unstyled" id="Avaliacao">
                    <li><a href="/fisiopeti/content/paciente/listar-avaliacoes.php?id_paciente=<?php echo $id_paciente;?>">Listar avaliações</a></li>
                    <li><a href="/fisiopeti/content/paciente/cadastrar-avaliacao.php?id_paciente=<?php echo $id_paciente;?>">Cadastrar avaliação</a></li>
                </ul>
            </li> -->
            <!-- <li><a href="/fisiopeti/content/paciente/categoria-paciente.php?id_paciente=<?php echo $id_paciente;?>">Categoria</a></li> -->
            <!-- <li><a href="/fisiopeti/content/paciente/listar-sessoes.php?id_paciente=<?php echo $id_paciente;?>">Sessões</a></li> -->
            <li><a href="/fisiopeti/content/agenda/agenda-paciente.php?id_paciente=<?php echo $id_paciente;?>">Agenda do paciente</a></li>
            <!-- <li><a href="/fisiopeti/content/relatorio/sessoes-realizadas-por-paciente.php?id_paciente=<?php echo $id_paciente;?>">Sessões</a></li> -->
            <!-- <li><a href="/fisiopeti_aba/content/paciente/paciente.php?id_paciente=<?php echo $id_paciente;?>">Agenda FP+</a></li> -->
        </ul>

        <ul class="list-unstyled components">
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

            <li style="margin-bottom: 10px;">
                <form action="/fisiopeti/content/profissional/pesquisar-profissional.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Profissional" name="PesquisaProfissional">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
        <?php
    } else {
        ?>
        <ul class="list-unstyled components">
            <li><a href="/fisiopeti/content/paciente/paciente.php?id_paciente=<?php echo $id_paciente;?>">Dados do paciente</a></li>
            <li><a href="/fisiopeti/content/paciente/diagnostico-paciente.php?id_paciente=<?php echo $id_paciente;?>">Diagnóstico</a></li>
            <li><a href="/fisiopeti/content/agenda/agenda-paciente.php?id_paciente=<?php echo $id_paciente;?>">Agenda do paciente</a></li>
        </ul>

        <ul class="list-unstyled components">
            <li><a href="/fisiopeti/content/agenda/agenda-profissional.php?id_profissional=<?php echo $UsuarioID;?>">Agenda FP</a></li>
            <li><a href="/fisiopeti/content/profissional/profissional.php?id_profissional=<?php echo $UsuarioID;?>">Profissional</a></li>
            <li><a href="/fisiopeti/content/paciente/listar-pacientes-1.php">Listar pacientes</a></li>
        </ul>
        <?php
    }
    ?>
</nav>

