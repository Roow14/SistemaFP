<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-intervencao.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior-intervencao.php';?>

<div id="conteudo">
    <h3>Atividades</h3>
    <div class="row">
	    <div class="col-lg-6">
	    	<?php
			// buscar xxx
			$sql = "SELECT * FROM prog_atividade_titulo ORDER BY NomeTitulo ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Título</th>';
				echo '<th style="width: 60px;">Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_atividade_titulo = $row['id_atividade_titulo'];
					$NomeTitulo = $row['NomeTitulo'];
					echo '<tr>';
					echo '<td style="vertical-align: middle;">'.$NomeTitulo.'</td>';
					echo '<td><a href="cadastrar-atividade-1.php?id_atividade_titulo='.$id_atividade_titulo.'" class="btn btn-default">Abrir</a></td>';
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
				echo 'Não foi encontrado nenhuma atividade.';
			}
			?>
	    </div>
	</div>
</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
