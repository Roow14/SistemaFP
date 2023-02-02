<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
    .box-visao {
        margin-bottom: 15px;
    }
    .box-visao-conteudo {
        background-color: #fafafa;
        padding: 15px;
        text-align: center;
    }
    .box-visao-nota {
        width: 100%;
        background-color: #fafafa;
        padding: 15px;
        height: 300px;
    }
    .box-visao textarea {
        border: none;
    }
    .box-verde {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    .box-azul {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
    }
    .box-laranja {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc;
    }
    .box-prata {
        color: #666;
        background-color: #fafafa;
        border-color: #d9d9d9;
    }
    .box-vermelho {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
    a .box-azul:hover {
        background-color: #bce8f1;
    }
    a .box-verde:hover {
        background-color: #d6e9c6;
    }
    a .box-laranja:hover {
        background-color: #faebcc;
    }
    a .box-prata:hover {
        background-color: #e6e6e6;
    }
    a .box-vermelho:hover {
        background-color: #e9c8c8;
    }
    .dica {
        color: #ccc;
    }
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <h2>Agenda</h2>
            <div class="row" style="margin-top: 25px;">

                <div class="box-visao col-sm-3">
                    <a href="../configuracao/relatorio-agenda-do-dia.php">
                        <div class="box-visao-conteudo box-prata">
                            <h4>Agenda do dia</h4>
                            <span>Presença</span>
                        </div>
                    </a>
                </div>

                <div class="box-visao col-sm-3">
                    <a href="../configuracao/criar-agenda-da-semana.php">
                        <div class="box-visao-conteudo box-prata">
                            <h4>Criar agenda</h4>
                            <span>Diario</span>
                        </div>
                    </a>
                </div>

                <div class="box-visao col-sm-3">
                    <a href="../paciente/">
                        <div class="box-visao-conteudo box-prata">
                            <h4>Agenda base</h4>
                            <span>Lista</span>
                        </div>
                    </a>
                </div>
	        </div>
         </div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
