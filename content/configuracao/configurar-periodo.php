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
					<h3>Cadastrar período</h3>
					<form action="adicionar-periodo.php" method="post">
						<div class="form-group">
							<label>Ordem</label>
							<input type="number" class="form-control" name="Periodo" placeholder="">
						</div>
						<div class="form-group">
							<label>Nome do período</label>
							<input type="text" class="form-control" name="NomePeriodo" placeholder="">
						</div>
						<a href="configuracao.php" class="btn btn-default">Voltar</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Período</h3>
					<?php
					// buscar horas
					$sql = "SELECT * FROM periodo ORDER BY Periodo ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<td>Ordem</td>
						<td>Período</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_periodo = $row['id_periodo'];
							$Periodo = $row['Periodo'];
							$NomePeriodo = $row['NomePeriodo'];
							echo '<form action="alterar-periodo.php?id_periodo='.$id_periodo.'" method="post">';
							echo '<tr>';
							echo '<td><input type="number" class="form-control" name="Periodo" value="'.$Periodo.'"></td>';
							echo '<td><input type="text" class="form-control" name="NomePeriodo" value="'.$NomePeriodo.'"></td>';

							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-periodo.php?id_periodo='.$id_periodo.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhum período cadastrado.';
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
