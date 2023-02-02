<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }

    // input
    $id_midia_profissional = $_GET['id_midia_profissional'];

    // iniciar conexão
    include "../conexao/conexao.php";

    // dados da mídia
    $sqlMidia = "SELECT * FROM midia_profissional WHERE id_midia_profissional = '$id_midia_profissional' ";
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
        <?php include '../../content/menu-lateral/menu-lateral-profissional.php';?>

        <div id="content">

            <?php include '../../content/menu-superior/menu-superior.php';?>

            <div id="conteudo">

<h3>Foto</h3>

<ul class="nav nav-tabs">
    <li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
    <li class="active"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
    <li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
    <li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
    <div class="row">
        <!-- foto e conteúdo -->
        <div class="col-sm-6">
            <?php
            // buscar midia
            $sql = "SELECT * FROM midia_profissional WHERE id_midia_profissional = '$id_midia_profissional'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
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
                        }
                    } else {
                    }

                    if (empty($row['id_profissional'])) {
                        echo '<a href="alterar-imagem-profissional.php?id_midia_profissional='.$id_midia_profissional.'" class="btn btn-success">Associar imagem ao profissional</a>';
                    } else {
                        echo '<label>Nome completo: </label> <a href="profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCompleto.'</a><br>';
                        echo '<label>Nome social: </label> '.$NomeCurto.'<br>';
                        echo '<label>Arquivo: </label> '.$ArquivoMidia.'<br>';
                        echo '<a href="profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default">Fechar</a>';
                        echo '<a href="remover-imagem-profissional.php?id_midia_profissional='.$id_midia_profissional.'&id_profissional='.$id_profissional.'" class="btn btn-default">Remover associação com o profissional</a>';
                    }
                }
            } else {
            }
            ?>
        </div>
        <div class="col-sm-6">
            <img src="../../vault/profissional/<?php echo $ArquivoMidia;?>" style="max-width: 300px; float: left; margin-right: 50px; margin-bottom: 50px;">
        </div>
    </div>
</div>

<!-- footer -->
<?php include '../../content/footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

</body>
</html>
