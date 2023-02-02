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
					<h3>Cadastrar terapia</h3>
					<form action="adicionar-terapia.php<?php echo $FiltroOrigem1;?>" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome da terapia</label>
							<input type="text" class="form-control" name="NomeTerapia" required>
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
					<h3>Terapias</h3>
					<?php
					// buscar terapia
					$sql = "SELECT * FROM terapia ORDER BY NomeTerapia ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<td>Nome da terapia</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_terapia = $row['id_terapia'];

							$sqlA = "SELECT * FROM terapia WHERE id_terapia = '$id_terapia'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									$NomeTerapia = $rowA['NomeTerapia'];
							    }
							} else {
								$NomeTerapia = 'Selecionar';
							}						

							echo '<form action="alterar-terapia.php?id_terapia='.$id_terapia.''.$FiltroOrigem.'" method="post">';
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeTerapia" value="'.$NomeTerapia.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if ($Nivel == 3) {
								echo '<a href="apagar-terapia.php?id_terapia='.$id_terapia.''.$FiltroOrigem.'" class="btn btn-default">&#x2715;</a>';
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
						echo 'Não encontramos nenhuma terapia cadastrada.';
					}

					if (empty($_SESSION['ErroApagarTerapia'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> a terapia está sendo utilizado e não pode ser apagada.
							<a href="cancelar-mensagem-erro.php<?php echo $FiltroOrigem1;?>" style="float: right;">&#x2716;</a>
						</div>
						<?php
					}

					if (empty($_SESSION['ErroAdicionarTerapia'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> a terapia já existe, digite um outro nome.
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
