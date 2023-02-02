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
if (empty($_GET['Origem'])) {
	$FiltroOrigem = NULL;
	$FiltroOrigem1 = NULL;
} else {
	$Origem = $_GET['Origem'];
	$FiltroOrigem = '&Origem='.$Origem;
	$FiltroOrigem1 = '?Origem='.$Origem;
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
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="row">
				<div class="col-sm-3">
					<h3>Cadastrar tipo de exame médico</h3>
					<form action="adicionar-exame.php<?php echo $FiltroOrigem1;?>" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome do exame</label>
							<input type="text" class="form-control" name="NomeExame" required>
						</div>
						<?php
						if (empty($_GET['Origem'])) {
							echo '<a href="configuracao.php" class="btn btn-default">Voltar</a>';
						} else {
							echo '<a href="'.$Origem.'" class="btn btn-default">Voltar</a>';
						}
						;?>
						
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
				</div>

				<div class="col-sm-6">
					<h3>Tipos de exames</h3>
					<?php
					// buscar exame
					$sql = "SELECT * FROM exame ORDER BY NomeExame ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<!-- <td>Diagnóstico</td> -->
						<td>Nome do exame</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_exame = $row['id_exame'];

							$sqlA = "SELECT * FROM exame WHERE id_exame = '$id_exame'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									// $Exame = $rowA['Exame'];
									$NomeExame = $rowA['NomeExame'];
							    }
							} else {
								$NomeExame = 'Selecionar';
							}						

							echo '<form action="alterar-exame.php?id_exame='.$id_exame.''.$FiltroOrigem.'" method="post">';
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeExame" value="'.$NomeExame.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-exame.php?id_exame='.$id_exame.''.$FiltroOrigem.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhum exame cadastrado.';
					}

					if (empty($_SESSION['ErroApagarExame'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> o exame está sendo utilizado e não pode ser apagado.
							<a href="cancelar-mensagem-erro.php<?php echo $FiltroOrigem1;?>" style="float: right;">&#x2716;</a>
						</div>
						<?php
					}

					if (empty($_SESSION['ErroAdicionarExame'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> o exame já existe, digite um outro nome.
							<a href="cancelar-mensagem-erro.php<?php echo $FiltroOrigem1;?>" style="float: right;">&#x2716;</a>
						</div>
						<?php
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
