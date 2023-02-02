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

// input
$id_atividade_titulo = $_GET['id_atividade_titulo'];

// buscar xxx
$sql = "SELECT * FROM prog_atividade_titulo WHERE id_atividade_titulo = '$id_atividade_titulo' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeTitulo = $row['NomeTitulo'];
    }
} else {
	// não tem
}

// buscar xxx
$Usuario = $_SESSION['UsuarioID'];
$sql = "SELECT * FROM profissional WHERE id_profissional = '$Usuario'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Nivel = $row['Nivel'];
    }
} else {
}
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

			<div class="row">
				<div class="col-lg-5">
					<h3>Atividade</h3>
					<form action="alterar-titulo-atividade-2.php?id_atividade_titulo=<?php echo $id_atividade_titulo;?>" method="post" class="form-inline">
						<label>Título:</label>
						<input type="text" class="form-control" name="NomeTitulo" value="<?php echo $NomeTitulo;?>">
						<button type="submit" class="btn btn-default">Alterar</button>
					</form>

					<h3>Cadastrar passo a passo</h3>
					<form action="adicionar-atividade.php?id_atividade_titulo=<?php echo $id_atividade_titulo;?>" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome:</label>
							<input type="text" class="form-control" name="NomeAtividade" required>
						</div>
						<a href="listar-atividades.php" class="btn btn-default">Listar atividades</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-lg-7">
					<h3>Passo a passo</h3>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM prog_atividade WHERE id_atividade_titulo = '$id_atividade_titulo' ORDER BY Ordem ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<th style="width: 100px;">Ordem</th>
						<th>Nome</th>
						<th>Ação</th>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_atividade = $row['id_atividade'];
							$NomeAtividade = $row['NomeAtividade'];
							$Ordem = $row['Ordem'];			

							echo '<form action="alterar-atividade.php?id_atividade='.$id_atividade.'&id_atividade_titulo='.$id_atividade_titulo.'" method="post">';
							echo '<tr>';
							echo '<td><input type="number" class="form-control" name="Ordem" value="'.$Ordem.'"></td>';
							echo '<td><input type="text" class="form-control" name="NomeAtividade" value="'.$NomeAtividade.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-atividade.php?id_atividade='.$id_atividade.'&id_atividade_titulo='.$id_atividade_titulo.'" class="btn btn-default">&#x2715;</a>';
							} else {}
							echo '</td>';

							echo '</tr>';
							echo '</form>';
					    }
					    ?>
					    </tbody>
						</table>
					    <?php
					} else {
						echo 'Não foi encontrado nenhuma atividade cadastrada.';
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
