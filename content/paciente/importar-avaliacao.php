<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$id_paciente = $_GET['id_paciente'];
$_SESSION['id_paciente'] = $_GET['id_paciente'];
$id_avaliacao = $_GET['id_avaliacao'];
$_SESSION['id_avaliacao'] = $_GET['id_avaliacao'];
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<body>

    <div class="wrapper">
        <!-- menu lateral -->
        <?php include '../../content/menu-lateral/menu-lateral.php';?>

        <!-- Page Content Holder -->
        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h3>Importar relatório ou gráfico</h3>

                <form action="importar-avaliacao-2.php" method="post" class="form-inline" enctype="multipart/form-data">
                    <label>Selecione:</label>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" hidden name="submit">
                    </div>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </form>
            </div>

            <!-- Modal ajuda -->
            <div class="modal fade" id="myModal-Ajuda" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Dicas</h4>
                            </div>
                            <div class="modal-body" style="background-color: #fafafa;">
                                <p>aaa</p>

                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>    
                    </div>

                </div>
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
