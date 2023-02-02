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
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="row">
				<div class="col-sm-3">
					<h3>Cadastrar Categoria</h3>
					<form action="adicionar-categoria.php" method="post">

						<div class="form-group">
							<label>Nome da Categoria</label>
							<input type="text" class="form-control" name="NomeCategoria">
						</div>
						<a href="configuracao.php" class="btn btn-default">Voltar</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Categorias</h3>
					<?php
					// buscar categoria
					$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<!-- <td>Categoria</td> -->
						<td>Nome da categoria</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_categoria = $row['id_categoria'];

							$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									// $Categoria = $rowA['Categoria'];
									$NomeCategoria = $rowA['NomeCategoria'];
							    }
							} else {
								$NomeCategoria = 'Selecionar';
							}						

							echo '<form action="alterar-categoria.php?id_categoria='.$id_categoria.'" method="post">';
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeCategoria" value="'.$NomeCategoria.'"></td>';

							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-categoria.php?id_categoria='.$id_categoria.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhuma categoria cadastrada.';
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
