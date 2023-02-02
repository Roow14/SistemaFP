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
    if (empty($_POST['SearchProfissional'])) {
        unset($_SESSION['SearchProfissional']);
    } else {
        $_SESSION['SearchProfissional'] = $_POST['SearchProfissional'];
    }

    if (isset($_SESSION['SearchProfissional'])) {
        $SearchProfissional = $_SESSION['SearchProfissional'];
        $FiltroProfissional = 'AND (profissional.NomeCompleto LIKE "%'.$_SESSION['SearchProfissional'].'%" OR profissional.NomeCurto LIKE "%'.$_SESSION['SearchProfissional'].'%") ';

    } else {
        $FiltroProfissional = NULL;
        unset($_SESSION['SearchProfissional']);
        $SearchProfissional = NULL;
    }
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<style type="text/css">
    .profissional img {
        transform: scale(1);
        transition: ease all 1s;
        position: relative;
    }
    .profissional img:hover {
        transform: scale(2);
        transition: ease all 1s;
        z-index: 9999;
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

                <h3>Associar imagem ao profissional</h3>
                <!-- <a href="" class="btn-icon" data-toggle="modal" data-target="#myModal-Ajuda"><i class="material-icons">help_outline</i></a> -->

                <!-- filtros -->
                <form action="" method="post" class="form-inline" style="margin-bottom: 25px;">
                    <label>Aplicar filtro:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nome" name='SearchProfissional' value="<?php echo $SearchProfissional;?>"></input>
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
// buscar midia_profissional
$sql = "SELECT midia_profissional.*, profissional.* FROM midia_profissional LEFT JOIN profissional ON midia_profissional.id_profissional = profissional.id_profissional WHERE midia_profissional.Status = 1 $FiltroProfissional";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id_midia_profissional = $row['id_midia_profissional'];
        $id_profissional = $row['id_profissional'];
        $ArquivoMidia = $row['ArquivoMidia'];

        // buscar xxx
        $sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
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
        echo '<div class="col-lg-4 profissional"><img src="../../vault/profissional/'.$ArquivoMidia.'" style="width:100%;"></div>';
        echo '<div class="col-lg-8">';
        if (empty($row['id_profissional'])) {
            if (empty($_GET['id_profissional'])) {
                echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
                echo '<a href="associar-imagem-profissional.php?id_midia_profissional='.$id_midia_profissional.'&id_profissional='.$id_profissional.'" class="btn btn-success">Associar imagem ao profissional</a>';
            } else {
                $id_profissionalXXX = $_GET['id_profissional'];
                echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
                echo '<a href="associar-imagem-profissional-4.php?id_midia_profissional='.$id_midia_profissional.'&id_profissional='.$id_profissionalXXX.'" class="btn btn-success">Associar profissional à imagem</a>';
            }
            
        } else {
            echo '<label>Nome completo:</label> <a href="profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCompleto.'</a><br>';
            echo '<label>Nome social:</label> '.$NomeCurto.'<br>';
            echo '<label>Foto: </label> '.$ArquivoMidia.'<br>';
            echo '<label>Status:</label> '.$NomeStatus.'<br>';
            // echo '<a href="associar-imagem-profissional-3.php?id_midia_profissional='.$id_midia_profissional.'&id_profissional='.$id_profissional.'" class="btn btn-default">Selecionar</a>';
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
