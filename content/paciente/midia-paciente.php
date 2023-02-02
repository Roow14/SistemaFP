<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }

    // input
    $id_midia_paciente = $_GET['id_midia_paciente'];

    // iniciar conexão
    include "../conexao/conexao.php";

    // dados da mídia
    $sqlMidia = "SELECT * FROM midia_paciente WHERE id_midia_paciente = '$id_midia_paciente' ";
    $resultMidia = $conn->query($sqlMidia);
    if ($resultMidia->num_rows > 0) {
        while($rowMidia = $resultMidia->fetch_assoc()) {
            $ArquivoMidia = $rowMidia['ArquivoMidia'];
        }
    } else {
    }
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<body>

    <div class="wrapper">
        <!-- menu lateral -->
        <?php include '../../content/menu-lateral/menu-lateral.php';?>

        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h2>Mídia</h2>

                <!-- mídia e conteúdo -->
                <div>
                    <img src="../../vault/paciente/<?php echo $ArquivoMidia;?>" style="max-width: 300px; float: left; margin-right: 50px; margin-bottom: 50px;">

                    <?php
                    // buscar midia
                    $sql = "SELECT * FROM midia_paciente WHERE id_midia_paciente = '$id_midia_paciente'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $id_paciente = $row['id_paciente'];
                            $ArquivoMidia = $row['ArquivoMidia'];

                            // buscar xxx
                            $sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
                            $resultA = $conn->query($sqlA);
                            if ($resultA->num_rows > 0) {
                                while($rowA = $resultA->fetch_assoc()) {
                                    $NomeCompleto = $rowA['NomeCompleto'];
                                    $NomeCurto = $rowA['NomeCurto'];
                                    $Status = $rowA['Status'];
                                }
                            } else {
                            }

                            if (empty($row['id_paciente'])) {
                                echo '<a href="alterar-imagem-paciente.php?id_midia_paciente='.$id_midia_paciente.'" class="btn btn-success">Associar imagem ao paciente</a>';
                            } else {
                                echo '<label>Nome completo: </label> <a href="paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a><br>';
                                echo '<label>Nome social: </label> '.$NomeCurto.'<br>';
                                echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
                                echo '<a href="remover-imagem-paciente.php?id_midia_paciente='.$id_midia_paciente.'&id_paciente='.$id_paciente.'" class="btn btn-default">Remover associação com o paciente</a>';
                            }
                        }
                    } else {
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../../content/footer/footer.php';?>

    <!-- jquery -->
    <?php include '../../js/jquery-custom.php';?>

</body>
</html>
