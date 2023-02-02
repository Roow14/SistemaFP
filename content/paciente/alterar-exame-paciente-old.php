<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }
    
    // conexão com banco
    include '../conexao/conexao.php';

    // aplicar filtro por nome
    if (empty($_POST['SearchArquivo'])) {
        unset($_SESSION['SearchArquivo']);
    } else {
        $_SESSION['SearchArquivo'] = $_POST['SearchArquivo'];
    }

    if (isset($_SESSION['SearchArquivo'])) {
        $SearchArquivo = $_SESSION['SearchArquivo'];
        $FiltroArquivo = 'AND (exame_paciente.ArquivoMidia LIKE "%'.$_SESSION['SearchArquivo'].'%") ';

    } else {
        $FiltroArquivo = NULL;
        unset($_SESSION['SearchArquivo']);
        $SearchArquivo = NULL;
    }
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<style type="text/css">
    .paciente img {
        transform: scale(1);
        transition: ease all 1s;
        position: relative;
    }
    .paciente img:hover {
        transform: scale(2);
        transition: ease all 1s;
        z-index: 9999;
    }
</style>

<body>

    <div class="wrapper">
        <!-- menu lateral -->
        <?php include '../../content/menu-lateral/menu-lateral-paciente.php';?>

        <!-- Page Content Holder -->
        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h3>Associar exame ao paciente</h3>
                <!-- <a href="" class="btn-icon" data-toggle="modal" data-target="#myModal-Ajuda"><i class="material-icons">help_outline</i></a> -->

                <!-- filtros -->
                <form action="" method="post" class="form-inline" style="margin-bottom: 25px;">
                    <label>Aplicar filtro:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nome do arquivo" name='SearchArquivo' value="<?php echo $SearchArquivo;?>"></input>
                    </div>

<!--                     <div class="form-group">
                        <select type="text" class="form-control" name="Status">
                            <option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                            <option value="3">Ativo e inativo</option>
                            
                        </select>
                    </div> -->
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </form>

                <!-- garrafas -->
                <div class="row">
<?php
// buscar exame_paciente
$sql = "SELECT exame_paciente.*, paciente.* FROM exame_paciente LEFT JOIN paciente ON exame_paciente.id_paciente = paciente.id_paciente WHERE exame_paciente.Status = 1 $FiltroArquivo";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id_exame_paciente = $row['id_exame_paciente'];
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
                if ($Status == 1) {
                    $NomeStatus = 'Ativo';
                } else {
                    $NomeStatus = 'Inativo';
                }
            }
        } else {
        }
        echo '<div class="col-lg-4" style="margin-bottom:25px;">';
        echo '<div class="row">';
        echo '<div class="col-lg-4 paciente"><img src="../../vault/exame/'.$ArquivoMidia.'" style="width:100%;"></div>';
        echo '<div class="col-lg-8">';
        if (empty($row['id_paciente'])) {
            if (empty($_GET['id_paciente'])) {
                echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
                echo '<a href="associar-exame_paciente.php?id_exame_paciente='.$id_exame_paciente.'&id_paciente='.$id_paciente.'" class="btn btn-success">Associar exame ao paciente</a>';
            } else {
                $id_pacienteXXX = $_GET['id_paciente'];
                echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
                echo '<a href="associar-exame_paciente-4.php?id_exame_paciente='.$id_exame_paciente.'&id_paciente='.$id_pacienteXXX.'" class="btn btn-success">Associar paciente ao exame</a>';
            }
            
        } else {
            echo '<label>Nome completo:</label> <a href="paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a><br>';
            echo '<label>Nome social:</label> '.$NomeCurto.'<br>';
            echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
            echo '<label>Status:</label> '.$NomeStatus.'<br>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
}
?>
            </div>    
            </div>

        </div>
    </div>

    <!-- footer -->
    <!-- jquery -->
    <?php include '../../js/jquery-custom.php';?>
</body>
</html>
