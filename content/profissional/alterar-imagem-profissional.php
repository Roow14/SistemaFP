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
    $FiltroProfissional = 'AND (profissional.NomeCompleto LIKE "%'.$_SESSION['SearchProfissional'].'%" OR profissional.NomeCurto LIKE "%'.$_SESSION['SearchProfissional'].'%" OR midia_profissional.ArquivoMidia LIKE "%'.$_SESSION['SearchProfissional'].'%") ';

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
    .janela {
        background-color: #fafafa;
        /*min-height: 300px;*/
        padding: 15px;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        border-radius: 4px;
    }
    .conteudo {

    }
    li {
        list-style: none;
    }
    .Link {
        background-color: transparent;
        border: none;
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

<h2>Terapeutas</h2>

<ul class="nav nav-tabs">
    <li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
    <li class="active"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
    <li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
    <li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
    <!-- filtro -->
    <form action="" method="post" class="form-inline" style="margin-bottom: 25px;">
        <label>Aplicar filtro:</label>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nome" name='SearchProfissional' value="<?php echo $SearchProfissional;?>"></input>
        </div>
        <button type="submit" class="btn btn-success">Confirmar</button>
    </form>

    <div class="row">
        <?php
        // buscar midia_profissional
        $sql = "SELECT DISTINCT midia_profissional.*, profissional.* FROM profissional 
        INNER JOIN midia_profissional ON midia_profissional.id_profissional = profissional.id_profissional
        WHERE midia_profissional.Status = 1 $FiltroProfissional ORDER BY profissional.NomeCompleto ASC  ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id_midia_profissional = $row['id_midia_profissional'];
                $id_profissional = $row['id_profissional'];
                $ArquivoMidia = $row['ArquivoMidia'];
                $NomeCompleto = $row['NomeCompleto'];
                $NomeCurto = $row['NomeCurto'];
                $Status = $row['Status'];
                if ($Status == 1) {
                    $NomeStatus = 'Ativo';
                } else {
                    $NomeStatus = 'Inativo';
                }

                // buscar xxx
                $sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional'";
                $resultA = $conn->query($sqlA);
                if ($resultA->num_rows > 0) {
                    while($rowA = $resultA->fetch_assoc()) {
                        // tem
                        $Check1 = 1;
                    }
                } else {
                    // não tem
                    $Check1 = 0;
                }

                // buscar xxx
                $sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional'";
                $resultA = $conn->query($sqlA);
                if ($resultA->num_rows > 0) {
                    while($rowA = $resultA->fetch_assoc()) {
                        // tem
                        $Check2 = 1;
                    }
                } else {
                    // não tem
                    $Check2 = 0;
                }

                $Check = $Check1 + $Check2;
                ?>
                <div class="col-sm-3" style="height: 400px;">
                    <div style="padding: 15px;">
                        <img src="../../vault/profissional/<?php echo $ArquivoMidia;?>" style="height:150px;">
                    </div>
                    <div style="padding: 0 15px 15px 15px;">
                        <?php
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
                        ?>
                        <a href="midia-profissional.php?id_profissional=<?php echo $id_profissional;?>&id_midia_profissional=<?php echo $id_midia_profissional;?>" class="btn btn-default">Abrir</a>
                        <?php
                        if ($Check > 0) {
                            echo '<a href="apagar-midia-profissional.php?id_midia_profissional='.$id_midia_profissional.'" class="btn btn-default">Apagar</a>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        } else {
        }
        ?>
    </div>
</div>

<!-- footer -->
<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
