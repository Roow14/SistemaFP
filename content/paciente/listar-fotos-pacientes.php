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
    if (empty($_POST['SearchPaciente'])) {
        unset($_SESSION['SearchPaciente']);
    } else {
        $_SESSION['SearchPaciente'] = $_POST['SearchPaciente'];
    }

    if (isset($_SESSION['SearchPaciente'])) {
        $SearchPaciente = $_SESSION['SearchPaciente'];
        $FiltroPaciente = 'AND (paciente.NomeCompleto LIKE "%'.$_SESSION['SearchPaciente'].'%" OR paciente.NomeCurto LIKE "%'.$_SESSION['SearchPaciente'].'%")';

    } else {
        $FiltroPaciente = NULL;
        unset($_SESSION['SearchPaciente']);
        $SearchPaciente = NULL;
    }
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<style type="text/css">
    .paciente {
        float: left;
        margin-right: 25px;
    }
    .paciente img {
        transform: scale(1);
        transition: ease all 1s;
        z-index: 1;
        position: relative;
    }
    .paciente img:hover {
        transform: scale(3);
        transition: ease all 1s;
        z-index: 2;
    }
</style>

<body>

    <div class="wrapper">
        <!-- menu lateral -->
        <?php include '../../content/menu-lateral/menu-lateral.php';?>

        <!-- Page Content Holder -->
        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

                <h3>Fotos dos pacientes</h3>
                <!-- <a href="" class="btn-icon" data-toggle="modal" data-target="#myModal-Ajuda"><i class="material-icons">help_outline</i></a> -->

                <!-- filtros -->
                <form action="" method="post" class="form-inline" style="margin-bottom: 25px;">
                    <label>Aplicar filtro:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nome do paciente" name='SearchPaciente' value="<?php echo $SearchPaciente;?>"></input>
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

                <div class="row">
<?php
// buscar midia_paciente
$sql = "SELECT midia_paciente.*, paciente.* FROM midia_paciente LEFT JOIN paciente ON midia_paciente.id_paciente = paciente.id_paciente WHERE midia_paciente.Status = 1 $FiltroPaciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id_midia_paciente = $row['id_midia_paciente'];
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
        echo '<div class="col-sm-4" style="margin-bottom:25px;">';
        echo '<div class="row paciente">';
        echo '<div class="col-sm-4"><img src="../../vault/paciente/'.$ArquivoMidia.'" style="width:100%;"></div>';
        echo '<div class="col-sm-8">';
        
        if (empty($row['id_paciente'])) {
        } else {
            echo '<label>Nome: </label> <a href="paciente.php?id_paciente='.$id_paciente.'" class="Link"> <b>'.$NomeCompleto.'</b></a><br>';
            echo '<label>Nome social: </label> '.$NomeCurto.'<br>';
        }
        echo '<label>Foto:</label> '.$ArquivoMidia.'<br>';
        if (empty($row['id_paciente'])) {
            echo '<a href="associar-imagem-paciente.php?id_midia_paciente='.$id_midia_paciente.'" class="btn btn-success">Associar paciente</a>';
        } else {
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
