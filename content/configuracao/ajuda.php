<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Ajuda</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
    <li class="active"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela col-sm-12">

<div class="row">
<div class="col-sm-12">
	<div style="margin-top: 25px; margin-bottom: 25px;">
	    <?php
		// buscar xxx
		$sql = "SELECT * FROM midia_ajuda ORDER BY ArquivoMidia ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$ArquivoMidia = $row['ArquivoMidia'];
				$id_midia_ajuda = $row['id_midia_ajuda'];
				echo '<p>';
				if (empty($_SESSION['ApagarArquivoAjuda'])) {
				} else {
					echo '<a href="apagar-arquivo-ajuda-2.php?ArquivoMidia='.$ArquivoMidia.'&id_midia_ajuda='.$id_midia_ajuda.'" class="btn btn-danger">Apagar</a> ';
				}
				echo '<a href="../../vault/ajuda/'.$ArquivoMidia.'" class="Link" target="_blank">'.$ArquivoMidia.'</a></p>';
		    }
		} else {
			// não tem
			echo 'Não foi encontrado nenhum arquivo';
		}
		?>
	</div>
	<form action="importar-ajuda-2.php" method="post" class="form-inline" enctype="multipart/form-data">
        <label>Importar arquivo:</label>
        <div class="form-group">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="text" hidden name="submit">
        </div>
        <button type="submit" class="btn btn-success">Confirmar</button>
    </form>
    
    <?php
    if (empty($_SESSION['ApagarArquivoAjuda'])) {
    	echo '<a href="ativar-filtro-apagar-arquivo.php" class="btn btn-default">Apagar arquivo</a>';
	} else {
		echo '<a href="ativar-filtro-apagar-arquivo.php" class="btn btn-success">Cancelar remoção do arquivo</a>';
	}
	?>
</div>


</div>
			</div>
    </div>
</div>

<!-- Modal -->
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>