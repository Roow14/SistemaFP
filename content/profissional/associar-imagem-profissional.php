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
    $id_midia_profissional = $_GET['id_midia_profissional'];

    // aplicar filtro por nome
    if (empty($_POST['SearchProfissional'])) {
        unset($_SESSION['SearchProfissional']);
    } else {
        $_SESSION['SearchProfissional'] = $_POST['SearchProfissional'];
    }

    if (isset($_SESSION['SearchProfissional'])) {
        $SearchProfissional = $_SESSION['SearchProfissional'];
        $FiltroProfissional = 'AND (profissional.NomeCompleto LIKE "%'.$_SESSION['SearchProfissional'].'%" OR profissional.NomeCurto LIKE "%'.$_SESSION['SearchProfissional'];

    } else {
        $FiltroProfissional = NULL;
        unset($_SESSION['SearchProfissional']);
        $SearchProfissional = NULL;
    }

    // aplicar filtro por status
    if (isset($_POST['Status'])) {
        $_SESSION['Status'] = $_POST['Status'];
        $Status = $_POST['Status'];
        if ($Status == 1) {
            $FiltroStatus = 'profissional.Status = 1';
            $NomeStatus = 'Ativo';
        } elseif ($Status == 2) {
            $FiltroStatus = 'profissional.Status = 2';
            $NomeStatus = 'Inativo';
        } else {
            $FiltroStatus = '(profissional.Status = 1 OR profissional.Status = 2)';
            $NomeStatus = 'Ativo e inativo';
        }
    } elseif (isset($_SESSION['Status'])) {
        $Status = $_SESSION['Status'];
        if ($Status == 1) {
            $FiltroStatus = 'profissional.Status = 1';
            $NomeStatus = 'Ativo';
        } elseif ($Status == 2) {
            $FiltroStatus = 'profissional.Status = 2';
            $NomeStatus = 'Inativo';
        } else {
            $FiltroStatus = '(profissional.Status = 1 OR profissional.Status = 2)';
            $NomeStatus = 'Ativo e inativo';
        }

    } else {
        $FiltroStatus = 'profissional.Status = 1';
        $NomeStatus = 'Ativo';
        $Status = 1;
    }

    unset($_SESSION['MsgErro']);
?>
<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../../content/header/head.php';?>

<style type="text/css">
    .profissional img {
        max-width: 80px;
        transform: scale(1);
        transition: ease all 1s;
    }
    .profissional img:hover {
        transform: scale(2);
        transition: ease all 1s;
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

                <h3>Associação foto e profissional</h3>
                <!-- <a href="" class="btn-icon" data-toggle="modal" data-target="#myModal-Ajuda"><i class="material-icons">help_outline</i></a> -->
<div class="row">
    <div class="col-lg-8">
        <!-- filtros -->
        <form action="" method="post" class="form-inline" style="margin-bottom: 25px;">
            <label>Aplicar filtro:</label>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Nome" name='SearchProfissional' value="<?php echo $SearchProfissional;?>"></input>
            </div>

            <div class="form-group">
                <select type="text" class="form-control" name="Status">
                    <option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                    <option value="3">Ativo e inativo</option>
                    
                </select>
            </div>
            <button type="submit" class="btn btn-success">Confirmar</button>
        </form>

        <?php
            $sql = "SELECT  *  FROM profissional WHERE $FiltroStatus $FiltroProfissional AND profissional.Nivel != 3 ORDER BY NomeCompleto ASC ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Foto</th>';
                echo '<th>Arquivo</th>';
                echo '<th>Nome</th>';
                echo '<th>Nome social</th>';
                echo '<th>Status</th>';
                echo '<th style="text-align:right;">Ação</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                // tem
                while($row = $result->fetch_assoc()) {
                    $id_profissional = $row['id_profissional'];
                    $NomeCompleto = $row['NomeCompleto'];
                    $NomeCurto = $row['NomeCurto'];
                    $Status = $row['Status'];
                    if ($Status == 1) {
                        $NomeStatus = 'Ativo';
                    } else {
                        $NomeStatus = 'Inativo';
                    }

                    // buscar dados da imagem
                    $sqlA = "SELECT * FROM midia_profissional WHERE id_profissional = '$id_profissional'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        while($rowA = $resultA->fetch_assoc()) {
                            $ArquivoMidia = $rowA['ArquivoMidia'];
                            $Midia = '../../vault/profissional/'.$ArquivoMidia;
                        }
                    } else {
                        $ArquivoMidia = 'imagem-default.jpg';
                        $Midia = '../../img/imagem-default.jpg';
                    }

                    // verificar se o profissional tem uma midia associada
                    $sqlA = "SELECT * FROM midia_profissional WHERE id_profissional = '$id_profissional'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        while($rowA = $resultA->fetch_assoc()) {
                            $CheckMidia = 1;
                        }
                    } else {
                        $CheckMidia = 2;
                    }

                    echo '<tr>';
                    echo '<td style="vertical-align:middle;" class="profissional"><img src="'.$Midia.'"></td>';
                    echo '<td style="vertical-align:middle;">'.$ArquivoMidia.'</td>';
                    echo '<td style="vertical-align:middle;"><a href="profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCompleto.'</a>';
                    echo '<td style="vertical-align:middle;">'.$NomeCurto.'</td>';
                    echo '<td style="vertical-align:middle;">'.$NomeStatus.'</td>';
                    if ($CheckMidia == 1) {
                        echo '<td></td>';
                    } else {
                        echo '<td style="text-align:right; vertical-align:middle;"><a href="associar-imagem-profissional-2.php?id_profissional='.$id_profissional.'&id_midia_profissional='.$id_midia_profissional.'" class="btn btn-default">Associar</a></td>';
                    }
                    
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</tbody>';
            } else {
                echo 'Não encontamos nenhum profissional.';
            }
        ?>
    </div>
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
