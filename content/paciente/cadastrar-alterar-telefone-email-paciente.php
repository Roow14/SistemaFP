<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_paciente = $_GET['id_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<div class="row">

	<h3>Telefone, celular e e-mail</h3>
	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

	<div class="row">
	
		<div class="col-lg-6">
			<h3>Cadastrar</h3>
			<form action="adicionar-telefone-email-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">
				<table class="table table-striped table-hover table-condensed">
					<thead>

						<tr>
							<th></th>
							<th>Nº telefone:</th>
							<th>Tipo:</th>
							<th>Observação:</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td><label>Telefone:</label></td>
							<td><input type="text" class="form-control" name="NumeroTel"></td>
							<td>
								<select class="form-control" name="Tipo">
									<option value="">Selecionar</option>
									<option value="1">Comercial</option>
									<option value="2">Residencial</option>
								</select>
							</td>
							<td><input type="text" class="form-control" name="NotaTel" placeholder="ex.: pai, mãe"></td>
						</tr>

						<tr>
							<td><label>Celular:</label></td>
							<td><input type="text" class="form-control" name="NumeroCel"></td>
							<td><input disabled type="text" class="form-control" name=""></td>
							<td><input type="text" class="form-control" name="NotaCel" placeholder="ex.: pai, mãe"></td>
						</tr>

						<tr>
							<td><label>E-mail:</label></td>
							<td><input type="text" class="form-control" name="EmailPaciente"></td>
							<td><input disabled type="text" class="form-control" name=""></td>
							<td><input type="text" class="form-control" name="NotaEmail" placeholder="ex.: pai, mãe"></td>
						</tr>
					</tbody>
				</table>

				<a href="paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
				<button type="submit" class="btn btn-success">Confirmar</button>
			</form>
		</div>

		<div class="col-lg-6">
			<h3>Existentes</h3>
			<?php
			// buscar telefone
			$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente' AND ClasseTel = 1";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Telefone</th>';
				echo '<th>Tipo</th>';
				echo '<th>Observação</th>';
				echo '<th>Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_telefone_paciente = $row['id_telefone_paciente'];
					$NumeroTel = $row['NumeroTel'];
					$NotaTel = $row['NotaTel'];
					$Tipo = $row['Tipo'];
					if ($Tipo == 1) {
						$NomeTipo = 'Comercial';
					} else {
						$NomeTipo = 'Residencial';
					}
					echo '<form action="alterar-telefone-paciente-2.php?id_paciente='.$id_paciente.'&id_telefone_paciente='.$id_telefone_paciente.'" method="post">';
					echo '<tr>';
					echo '<td><input type="text" class="form-control" name="Telefone" value="'.$NumeroTel.'"></td>';

					?>
					<td>
					<select class="form-control" name="Tipo">
						<option value="<?php echo $Tipo;?>"><?php echo $NomeTipo;?></option>
						<option value="1">Comercial</option>
						<option value="2">Residencial</option>
					</select>
					</td>
					<?php

					echo '<td><input type="text" class="form-control" name="NotaTel" value="'.$NotaTel.'"></td>';
					echo '<td style="width: 100px;">';
					echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
					echo '<a href="apagar-telefone-paciente-2.php?id_paciente='.$id_paciente.'&id_telefone_paciente='.$id_telefone_paciente.'" class="btn btn-default">&#x2715;</a>';
					echo '</td>';
					echo '</tr>';
					echo '</form>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
			}

			// buscar celular
			$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente' AND ClasseTel = 2";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Telefone</th>';
				echo '<th>Observação</th>';
				echo '<th>Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_telefone_paciente = $row['id_telefone_paciente'];
					$NumeroTel = $row['NumeroTel'];
					$NotaTel = $row['NotaTel'];
					
					echo '<form action="alterar-telefone-paciente-2.php?id_paciente='.$id_paciente.'&id_telefone_paciente='.$id_telefone_paciente.'" method="post">';
					echo '<tr>';
					echo '<td><input type="text" class="form-control" name="Telefone" value="'.$NumeroTel.'"></td>';

					echo '<td><input type="text" class="form-control" name="NotaTel" value="'.$NotaTel.'"></td>';
					echo '<td style="width: 100px;">';
					echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
					echo '<a href="apagar-telefone-paciente-2.php?id_paciente='.$id_paciente.'&id_telefone_paciente='.$id_telefone_paciente.'" class="btn btn-default">&#x2715;</a>';
					echo '</td>';
					echo '</tr>';
					echo '</form>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
			}

			// buscar e-mail
			$sql = "SELECT * FROM email_paciente WHERE id_paciente = '$id_paciente' ";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>E-mail</th>';
				echo '<th>Observação</th>';
				echo '<th>Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_email_paciente = $row['id_email_paciente'];
					$EmailPaciente = $row['EmailPaciente'];
					$NotaEmail = $row['NotaEmail'];
					
					echo '<form action="alterar-email-paciente-2.php?id_paciente='.$id_paciente.'&id_email_paciente='.$id_email_paciente.'" method="post">';
					echo '<tr>';
					echo '<td><input type="text" class="form-control" name="EmailPaciente" value="'.$EmailPaciente.'"></td>';

					echo '<td><input type="text" class="form-control" name="NotaEmail" value="'.$NotaEmail.'"></td>';
					echo '<td style="width: 100px;">';
					echo '<button type="submit" class="btn btn-default" style="margin-right: 5px;">&#x270E;</button>';
					echo '<a href="apagar-email-paciente-2.php?id_paciente='.$id_paciente.'&id_email_paciente='.$id_email_paciente.'" class="btn btn-default">&#x2715;</a>';
					echo '</td>';
					echo '</tr>';
					echo '</form>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
			}
			?>
		</div>
	</div>
</div>
		</div>
    </div>
</div>
<select class="form-control" name="">
	<option value=""></option>
</select>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
