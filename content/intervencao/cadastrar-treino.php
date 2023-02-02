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
    <?php include '../menu-lateral/menu-lateral-intervencao.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior-intervencao.php';?>

        <div id="conteudo">

			<div class="row">
				<div class="col-sm-6">
					<h3>Cadastrar treino - etapa 1</h3>
					<form action="cadastrar-treino-2.php" method="post" class="form-horizontal">

						<div class="form-group">
							<label class="control-label col-sm-5">Nome do paciente:</label>
							<div class="col-sm-7">
								<select class="form-control" name="id_paciente" required>
									<option value="">Selecionar</option>
									<?php
									// buscar xxx
									$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
											$id_paciente = $row['id_paciente'];
											$NomeCompleto = $row['NomeCompleto'];
											echo '<option value="'.$id_paciente.'">'.$NomeCompleto.'</option>';
									    }
									} else {
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-5">Objetivo comportamental:</label>
							<div class="col-sm-7">
								<select class="form-control" name="id_objetivo" required>
									<option value="">Selecionar</option>
									<?php
									// buscar xxx
									$sql = "SELECT * FROM prog_objetivo ORDER BY NomeObjetivo ASC";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
											$id_objetivo = $row['id_objetivo'];
											$NomeObjetivo = $row['NomeObjetivo'];
											echo '<option value="'.$id_objetivo.'">'.$NomeObjetivo.'</option>';
									    }
									} else {
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-5">Procedimento:</label>
							<div class="col-sm-7">
								<?php
								// buscar xxx
								$sql = "SELECT * FROM prog_procedimento ORDER BY NomeProcedimento ASC";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										$id_procedimento = $row['id_procedimento'];
										$NomeProcedimento = $row['NomeProcedimento'];
										echo '<div class="checkbox">';
										echo '<label><input type="checkbox" name="id_procedimento[]" value="'.$id_procedimento.'">'.$NomeProcedimento.'</label>';
										echo '</div>';
								    }
								} else {
								}
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-5">Reforçador:</label>
							<div class="col-sm-7">
								<?php
								// buscar xxx
								$sql = "SELECT * FROM prog_reforcador ORDER BY NomeReforcador ASC";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										$id_reforcador = $row['id_reforcador'];
										$NomeReforcador = $row['NomeReforcador'];
										echo '<div class="checkbox">';
										echo '<label><input type="checkbox" name="id_reforcador[]" value="'.$id_reforcador.'">'.$NomeReforcador.'</label>';
										echo '</div>';
								    }
								} else {
								}
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-5">Profissional:</label>
							<div class="col-sm-7">
								<select class="form-control" name="id_profissional">
								<option value="">Selecionar</option>						
								<?php
								// buscar xxx
								$sql = "SELECT * FROM profissional WHERE Status = 1 AND Nivel != 3 ORDER BY NomeCompleto ASC";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										$id_profissional = $row['id_profissional'];
										$NomeCompleto = $row['NomeCompleto'];
										echo '<option value="'.$id_profissional.'">'.$NomeCompleto.'</option>';
								    }
								} else {
								}
								?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-5"></label>
							<div class="col-sm-7">
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</div>
					</form>
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
