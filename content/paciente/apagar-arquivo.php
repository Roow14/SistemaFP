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
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>

<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <h2>Apagar arquivo</h2>
            <div class="alert alert-danger">
                <b>Cuidado:</b> o arquivo <b><?php echo $ArquivoMidia;?></b> será removido completamente do sistema.<br>
                Deseja continuar?
                <div style="margin-top: 15px;">
                    <a href="listar-avaliacoes.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
                    <a href="apagar-arquivo-2.php?id_paciente=<?php echo $id_paciente;?>&id_midia_avaliacao=<?php echo $id_midia_avaliacao;?>" class="btn btn-danger">Apagar</a>
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