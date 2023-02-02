<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input 
$id_paciente = $_GET['id_paciente'];
$id_midia_avaliacao = $_GET['id_midia_avaliacao'];
$ArquivoMidia = $_GET['ArquivoMidia'];
$id_avaliacao = $_GET['id_avaliacao'];
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
    .modal {
        display: block;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4); /* <-- this is the culprit */
    }
</style>
</style>

<body>

<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <div class="modal">
                <div class="modal-content" style="max-width: 600px; margin: auto;">
                    <div class="modal-header">
                        <h4>Apagar arquivo</h4>
                    </div>
                    <div class="modal-body" style="background-color: #fafafa;">
                        <b>Cuidado:</b> o arquivo <b><?php echo $ArquivoMidia;?></b> será removido completamente do sistema.<br>
                        Deseja continuar?
                    </div>
                    <div class="modal-footer">
                        <a href="index.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
                        <a href="apagar-arquivo-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_midia_avaliacao=<?php echo $id_midia_avaliacao;?>&ArquivoMidia=<?php echo $ArquivoMidia;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-danger">Apagar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

</body>
</html>