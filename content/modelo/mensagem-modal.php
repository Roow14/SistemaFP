<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_categoria_profissional = $_GET['id_categoria_profissional'];

// mensagem de alerta
// echo "<script type=\"text/javascript\">
//     alert(\"Atenção: a categoria associada ao profissional será apagado. Deseja continuar? \");
//     window.location = \"listar-categoria-profissionais-apagar-1.php?id_categoria_profissional=$id_categoria_profissional\"
//     </script>";
// exit;

// voltar
// header("Location: listar-categoria-profissionais.php");
// exit;
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

        	<!-- Modal -->
<div class="" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="" method="post">

                <div class="modal-header">
                	<a href="listar-categoria-profissionais.php" class="close">&times;</a>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <p><b>Cuidado!</b> A categoria será removida do sistema.<br>Deseja continuar?</p>

                </div>
                
                <div class="modal-footer">
                	<a href="listar-categoria-profissionais.php" class="btn btn-default">Voltar</a>
                    <a href="listar-categoria-profissionais-apagar-1.php?id_categoria_profissional=<?php echo $id_categoria_profissional;?>" class="btn btn-danger">Apagar</a>
                </div>
            </form>    
        </div>

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


