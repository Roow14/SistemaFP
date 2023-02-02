<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }

    // input
    $id_midia_exame = $_GET['id_midia_exame'];
    $id_paciente = $_GET['id_paciente'];
    $id_pedido_medico = $_GET['id_pedido_medico'];

    // iniciar conexão
    include "../conexao/conexao.php";

    // dados da mídia
    $sqlMidia = "SELECT * FROM midia_exame WHERE id_midia_exame = '$id_midia_exame' ";
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
        <?php include '../../content/menu-lateral/menu-lateral-paciente.php';?>

        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h2>Exame</h2>

                <!-- mídia e conteúdo -->
                <div style="margin-bottom: 15px;">
                    <?php
                    // buscar midia
                    $sql = "SELECT * FROM midia_exame WHERE id_midia_exame = '$id_midia_exame'";
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
                                echo '<a href="alterar-exame_paciente.php?id_midia_exame='.$id_midia_exame.'" class="btn btn-success">Associar exame ao paciente</a>';
                            } else {
                                echo '<label>Nome completo: </label> <a href="paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a><br>';
                                echo '<label>Arquivo: </label> '.$ArquivoMidia.'<br>';
                                echo '<a href="pedido-medico.php?id_pedido_medico='.$id_pedido_medico.'&id_paciente='.$id_paciente.'" class="btn btn-default">Voltar</a>';
                                echo '<a href="apagar-exame-2.php?id_midia_exame='.$id_midia_exame.'&id_paciente='.$id_paciente.'" class="btn btn-default">Apagar exame</a>';
                            }
                        }
                    } else {
                    }
                    ?>
                </div>
                <div>
                    <!-- <img src="../../vault/exame/<?php echo $ArquivoMidia;?>" style="width: 100%;"> -->
                    <?php
                    $Arquivo = '../../vault/exame/'.$ArquivoMidia;
                    readfile($Arquivo); 
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
