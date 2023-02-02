<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;

// input
$id_paciente = $_GET['id_paciente'];
$id_pedido_medico = $_GET['id_pedido_medico'];
$_SESSION['id_paciente'] = $_GET['id_paciente'];
$_SESSION['id_pedido_medico'] = $_GET['id_pedido_medico'];

// conexão com banco
include '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<body>

    <div class="wrapper">
        <!-- menu lateral -->
        <?php include '../../content/menu-lateral/menu-lateral-paciente.php';?>

        <!-- Page Content Holder -->
        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h3>Importar exame</h3>

                <form action="importar-exame-2.php" method="post" class="form-inline" enctype="multipart/form-data">
                    <label>Selecione o exame:</label>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" hidden name="submit">
                    </div>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../../content/footer/footer.php';?>

    <!-- jquery -->
    <?php include '../../js/jquery-custom.php';?>

    <!-- tooltip -->
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</body>
</html>
