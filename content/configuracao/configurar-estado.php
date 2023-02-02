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
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="row">

				<div class="col-sm-6">
					<h3>Estados</h3>
					<?php
					// buscar estado
					$sql = "SELECT * FROM estado ORDER BY NomeEstado ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<!-- <td>Diagnóstico</td> -->
						<td>Nome do estado</td>
						<td>UF</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_estado = $row['id_estado'];

							$sqlA = "SELECT * FROM estado WHERE id_estado = '$id_estado'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									// $Exame = $rowA['Exame'];
									$NomeEstado = $rowA['NomeEstado'];
									$Estado = $rowA['Estado'];
							    }
							} else {
								$NomeEstado = NULL;
								$Estado = NULL;
							}						

							echo '<form action="alterar-estado.php?id_estado='.$id_estado.'" method="post">';
							echo '<tr id="'.$id_estado.'">';
							echo '<td><input type="text" class="form-control" name="NomeEstado" value="'.$NomeEstado.'"></td>';
							echo '<td><input type="text" class="form-control" name="Estado" value="'.$Estado.'"></td>';
							echo '<td style="width: 70px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							echo '</td>';

							echo '</tr>';
							echo '</form>';
					    }
					    ?>
					    </tbody>
						</table>
					    <?php
					} else {
						echo 'Não encontramos nenhum Estado cadastrado.';
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
