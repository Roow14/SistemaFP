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
					<h3>Cadastrar horário</h3>
					<form action="adicionar-hora.php" method="post">
						<div class="form-group">
							<label>Hora</label>
							<input type="text" class="form-control" name="Hora" placeholder="Ex.: 8:30">
						</div>
						<a href="configuracao.php" class="btn btn-default">Voltar</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
<!-- 					<div style="margin-top: 25px;">
						<p><b>Cuidado:</b></p>
						<a href="recriar-grade.php" class="btn btn-default">Apagar e recriar a grade horária</a>
					</div> -->
				</div>

				<div class="col-sm-6">
					<h3>Grade diária</h3>
					<?php
					// buscar horas
					$sql = "SELECT * FROM hora ORDER BY Ordem ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<td>Ordem</td>
						<td>Hora</td>
						<td>Período</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_hora = $row['id_hora'];
							$Hora = $row['Hora'];
							$Ordem = $row['Ordem'];
							$Periodo = $row['Periodo'];
							$sqlA = "SELECT * FROM periodo WHERE Periodo = '$Periodo'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									$Periodo = $rowA['Periodo'];
									$NomePeriodo = $rowA['NomePeriodo'];
							    }
							} else {
								$NomePeriodo = 'Selecionar';
							}

							echo '<form action="alterar-hora.php?id_hora='.$id_hora.'" method="post">';
							echo '<tr>';
							echo '<td><input type="number" class="form-control" name="Ordem" value="'.$Ordem.'"></td>';
							echo '<td><input type="text" class="form-control" name="Hora" value="'.$Hora.'"></td>';

							// buscar periodo
							echo '<td style="width: 150px;">';
							echo '<select class="form-control" name="Periodo">';
							echo '<option value="'.$Periodo.'">'.$NomePeriodo.'</option>';
							$sqlA = "SELECT * FROM periodo";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									$id_periodo = $rowA['id_periodo'];
									$Periodo = $rowA['Periodo'];
									$NomePeriodo = $rowA['NomePeriodo'];
									echo '<option value="'.$Periodo.'">'.$NomePeriodo.'</option>';
							    }
							} else {
								echo '<option value="">Selecionar</option>';
							}
							echo '</select>';
							echo '</td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-hora.php?id_hora='.$id_hora.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhuma hora cadastrada.';
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
