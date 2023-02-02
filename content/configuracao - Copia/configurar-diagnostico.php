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
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['id_paciente'])) {
} else {
	$id_paciente = $_GET['id_paciente'];
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
					<h3>Cadastrar Diagnóstico</h3>
					<form action="adicionar-diagnostico.php?id_paciente=<?php echo $id_paciente;?>&Origem=<?php echo $Origem;?>" method="post" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome do diagnóstico</label>
							<input type="text" class="form-control" name="NomeDiagnostico" required>
						</div>
						<div class="form-group"> 
							<label>Código do CID</label>
							<input type="text" class="form-control" name="Cid">
						</div>
						<?php
						if (empty($_GET['Origem'])) {
							echo '<a href="configuracao.php" class="btn btn-default">Voltar</a>';
						} else {
							echo '<a href="'.$Origem.'?id_paciente='.$id_paciente.'" class="btn btn-default">Voltar</a>';
						}
						;?>
						
						<button type="submit" class="btn btn-success">Confirmar</button>
					</form>
					<a href="https://cid10.com.br/" target="blank" class="btn btn-default">Consultar CID</a>

				</div>

				<div class="col-sm-6">
					<h3>Diagnósticos</h3>
					<?php
					// buscar diagnóstico
					$sql = "SELECT * FROM diagnostico ORDER BY NomeDiagnostico ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<!-- <td>Diagnóstico</td> -->
						<td>Nome do diagnóstico</td>
						<td>CID</td>
						<td>Ação</td>
						</tr>
						</thead>
						<tbody>
						<?php
					    while($row = $result->fetch_assoc()) {
							$id_diagnostico = $row['id_diagnostico'];
							$Cid = $row['Cid'];

							$sqlA = "SELECT * FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									// $Diagnostico = $rowA['Diagnostico'];
									$NomeDiagnostico = $rowA['NomeDiagnostico'];
							    }
							} else {
								$NomeDiagnostico = 'Selecionar';
							}						

							if (empty($Origem)) {
								echo '<form action="alterar-diagnostico.php?id_diagnostico='.$id_diagnostico.'" method="post">';
							} else {
								echo '<form action="alterar-diagnostico.php?id_diagnostico='.$id_diagnostico.'&Origem='.$Origem.'&id_paciente='.$id_paciente.'" method="post">';
							}
							echo '<tr>';
							echo '<td><input type="text" class="form-control" name="NomeDiagnostico" value="'.$NomeDiagnostico.'"></td>';
							echo '<td><input type="text" class="form-control" name="Cid" value="'.$Cid.'"></td>';
							echo '<td style="width: 100px;">';
							echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
							if (empty($Origem)) {
								echo '<a href="apagar-diagnostico.php?id_diagnostico='.$id_diagnostico.'" class="btn btn-default">&#x2715;</a>';
							} else {
								echo '<a href="apagar-diagnostico.php?id_diagnostico='.$id_diagnostico.'&Origem='.$Origem.'&id_paciente='.$id_paciente.'" class="btn btn-default">&#x2715;</a>';
							}
							echo '</td>';

							echo '</tr>';
							echo '</form>';
					    }
					    ?>
					    </tbody>
						</table>
					    <?php
					} else {
						echo 'Não encontramos nenhum diagnóstico cadastrado.';
					}

					if (empty($_SESSION['ErroApagarDiagnostico'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> o diagnóstico está sendo utilizado e não pode ser apagado.
							<a href="cancelar-mensagem-erro.php?id_paciente=<?php echo $id_paciente;?>&Origem=<?php echo $Origem;?>" style="float: right;">&#x2716;</a>
						</div>
						<?php
					}

					if (empty($_SESSION['ErroAdicionarDiagnostico'])) {
					} else {
						?>
						<div class="alert alert-danger" style="width: 100%;">
							<b>Erro:</b> o diagnóstico já existe, digite um outro nome.
							<a href="cancelar-mensagem-erro.php?id_paciente=<?php echo $id_paciente;?>&Origem=<?php echo $Origem;?>" style="float: right;">&#x2716;</a>
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
