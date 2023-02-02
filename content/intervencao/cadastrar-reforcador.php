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
				<div class="col-sm-3">
					<h3>Cadastrar reforcador</h3>
					<form action="adicionar-reforcador.php" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="NomeReforcador" required>
						</div>
						<a href="listar-reforcadores.php" class="btn btn-default">Listar reforçadores</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Reforçadores cadastrados</h3>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM prog_reforcador ORDER BY NomeReforcador ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<th>Nome</th>
						<th>Ação</th>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_reforcador = $row['id_reforcador'];
							$NomeReforcador = $row['NomeReforcador'];			

							echo '<form action="alterar-reforcador.php?id_reforcador='.$id_reforcador.'" method="post">';
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeReforcador" value="'.$NomeReforcador.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-reforcador.php?id_reforcador='.$id_reforcador.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não foi encontrado nenhum reforcador cadastrado.';
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
