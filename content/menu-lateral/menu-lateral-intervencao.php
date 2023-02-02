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

<nav id="sidebar">
    <div class="sidebar-header">
        <img src="/fisiopeti/img/logo-fisiopeti.png" style="width: 100%;">
    </div>

    <?php
    if ($_SESSION['UsuarioNivel'] > 1) {
        ?>
        <ul class="list-unstyled components">
            <li>
                <a href="#Objetivo" data-toggle="collapse" aria-expanded="false">Objetivo comportamental</a>
                <ul class="collapse list-unstyled" id="Objetivo">
                    <li><a href="/fisiopeti/content/intervencao/listar-objetivos.php">Listar objetivos</a></li>
                    <li><a href="/fisiopeti/content/intervencao/cadastrar-objetivo.php">Cadastrar, alterar objetivo</a></li>
                </ul>
            </li>

            <li>
                <a href="#Procedimento" data-toggle="collapse" aria-expanded="false">Procedimento</a>
                <ul class="collapse list-unstyled" id="Procedimento">
                    <li><a href="/fisiopeti/content/intervencao/listar-procedimentos.php">Listar procedimentos</a></li>
                    <li><a href="/fisiopeti/content/intervencao/cadastrar-procedimento.php">Cadastrar, alterar procedimento</a></li>
                </ul>
            </li>

            <li>
                <a href="#Reforcador" data-toggle="collapse" aria-expanded="false">Reforçadores</a>
                <ul class="collapse list-unstyled" id="Reforcador">
                    <li><a href="/fisiopeti/content/intervencao/listar-reforcadores.php">Listar reforçadores</a></li>
                    <li><a href="/fisiopeti/content/intervencao/cadastrar-reforcador.php">Cadastrar, alterar  reforçador</a></li>
                </ul>
            </li>

            <li>
                <a href="#Atividade" data-toggle="collapse" aria-expanded="false">Atividade</a>
                <ul class="collapse list-unstyled" id="Atividade">
                    <li><a href="/fisiopeti/content/intervencao/listar-atividades.php">Listar atividades</a></li>
                    <li><a href="/fisiopeti/content/intervencao/cadastrar-atividade.php">Cadastrar, alterar atividade</a></li>
                </ul>
            </li>

            <li>
                <a href="#Treino" data-toggle="collapse" aria-expanded="false">Treino</a>
                <ul class="collapse list-unstyled" id="Treino">
                    <li><a href="/fisiopeti/content/intervencao/listar-treinos.php">Listar treinos</a></li>
                    <li><a href="/fisiopeti/content/intervencao/cadastrar-treino.php">Cadastrar treino</a></li>
                </ul>
            </li>

            <li>
                <a href="#Paciente" data-toggle="collapse" aria-expanded="false">Paciente</a>
                <ul class="collapse list-unstyled" id="Paciente">
                    <li><a href="/fisiopeti/content/intervencao/listar-pacientes-intervencao.php">Listar pacientes</a></li>
                </ul>
            </li>

            <li>
                <form action="/fisiopeti/content/intervencao/pesquisar-paciente-intervencao.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Paciente" name="PesquisaPaciente">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>

            <li>
                <form action="/fisiopeti/content/intervencao/pesquisar-profissional-intervencao.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Profissional" name="PesquisaProfissional">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
            <br>
        </ul>


        <?php
    } else {
        ?>

        <?php
    }
    ?>

        
        
</nav>

