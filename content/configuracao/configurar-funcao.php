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
					<h3>Cadastrar função</h3>
					<form action="adicionar-funcao.php" method="post">
<!-- 						<div class="form-group">
							<label>Nº da função</label>
							<input type="number" class="form-control" name="Funcao">
						</div> -->
						<div class="form-group">
							<label>Nome da função</label>
							<input type="text" class="form-control" name="NomeFuncao">
						</div>
						<a href="configuracao.php" class="btn btn-default">Voltar</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Funções</h3>
					<?php
					// buscar função
					$sql = "SELECT * FROM funcao ORDER BY NomeFuncao ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<!-- <td>Nº</td> -->
						<td>Nome da função</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_funcao = $row['id_funcao'];
							// $Funcao = $row['Funcao'];

							$sqlA = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									$NomeFuncao = $rowA['NomeFuncao'];
							    }
							} else {
								$NomeFuncao = 'Selecionar';
							}						

							echo '<form action="alterar-funcao.php?id_funcao='.$id_funcao.'" method="post">';
							echo '<tr>';
							// echo '<td><input type="number" class="form-control" name="Funcao" value="'.$Funcao.'"></td>';
							echo '<td><input type="text" class="form-control" name="NomeFuncao" value="'.$NomeFuncao.'"></td>';

							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-funcao.php?id_funcao='.$id_funcao.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhuma função cadastrada.';
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
