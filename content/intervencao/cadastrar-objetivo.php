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
					<h3>Cadastrar objetivo comportamental</h3>
					<form action="adicionar-objetivo.php" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="NomeObjetivo" required>
						</div>
						<a href="listar-objetivos.php" class="btn btn-default">Listar objetivos</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Objetivos cadastrados</h3>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM prog_objetivo ORDER BY NomeObjetivo ASC";
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
							$id_objetivo = $row['id_objetivo'];
							$NomeObjetivo = $row['NomeObjetivo'];

							// verificar se está sendo utilizado
							$sqlA = "SELECT * FROM prog_objetivo_paciente WHERE id_objetivo = '$id_objetivo'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
							    	// está sendo usado
									$CheckObjetivo = 1;
							    }
							} else {
								// não está
								$CheckObjetivo = 2;
							}						

							echo '<form action="alterar-objetivo.php?id_objetivo='.$id_objetivo.'" method="post">';
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeObjetivo" value="'.$NomeObjetivo.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-objetivo.php?id_objetivo='.$id_objetivo.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não foi encontrado nenhum objetivo cadastrado.';
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
