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
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM prog_treino_paciente WHERE id_treino_paciente = '$id_treino_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_objetivo_paciente = $row['id_objetivo_paciente'];
		$id_profissional = $row['id_profissional'];

		// buscar xxx
		$sqlA = "SELECT prog_objetivo.* FROM prog_objetivo_paciente INNER JOIN prog_objetivo ON prog_objetivo_paciente.id_objetivo = prog_objetivo.id_objetivo WHERE prog_objetivo_paciente.id_objetivo_paciente = '$id_objetivo_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeObjetivo = $rowA['NomeObjetivo'];
		    }
		} else {
		}

    }
} else {
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.Largura {
		width: 100px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-intervencao.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior-intervencao.php';?>

        <div id="conteudo">

			<div class="row">
<div class="col-sm-5">
	<h3>Treino</h3>
	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
	<label>Objetivo comportamental:</label> <?php echo $NomeObjetivo;?><br>
	<label>Procedimentos:</label><br>
	<?php
	// buscar xxx
	$sql = "SELECT prog_procedimento.* FROM prog_procedimento_paciente INNER JOIN prog_procedimento ON prog_procedimento_paciente.id_procedimento = prog_procedimento.id_procedimento WHERE prog_procedimento_paciente.id_objetivo_paciente = '$id_objetivo_paciente' ORDER BY prog_procedimento.NomeProcedimento ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<ul>';
	    while($row = $result->fetch_assoc()) {
			$id_procedimento = $row['id_procedimento'];
			$NomeProcedimento = $row['NomeProcedimento'];
			echo '<li>'.$NomeProcedimento.'</li>';
	    }
	    echo '</ul>';
	} else {
	}
	?>

	<label>Reforçador:</label><br>
	
	<?php
	// buscar xxx
	$sql = "SELECT prog_reforcador.* FROM prog_reforcador_paciente INNER JOIN prog_reforcador ON prog_reforcador_paciente.id_reforcador = prog_reforcador.id_reforcador WHERE prog_reforcador_paciente.id_objetivo_paciente = '$id_objetivo_paciente' ORDER BY prog_reforcador.NomeReforcador ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<ul>';
	    while($row = $result->fetch_assoc()) {
			$id_reforcador = $row['id_reforcador'];
			$NomeReforcador = $row['NomeReforcador'];
			echo '<li>'.$NomeReforcador.'</li>';
	    }
	    echo '</ul>';
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCompleto = $row['NomeCompleto'];
	    }
	} else {
		// não tem
		$NomeCompleto = NULL;
	}

	echo '<label>Profissional:</label> '.$NomeCompleto.'<br>';

	if (empty($_GET['Origem'])) {
		echo '<a href="listar-treinos.php" class="btn btn-default">Listar treinos</a>';
	} else {
		$Origem = $_GET['Origem'];
		echo '<a href="'.$Origem.'?id_paciente='.$id_paciente.'" class="btn btn-default">&lsaquo; Voltar</a>';
	}
	?>
	
	<a href="alterar-treino.php?id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Alterar</a>
</div>

<div class="col-sm-12">
	<h3>Atividade</h3>

	<div>
		

		<!-- atividades -->
		<div>
			<?php
			// buscar xxx
			$sql = "SELECT * FROM prog_treino_paciente WHERE id_objetivo_paciente = '$id_objetivo_paciente' ";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_treino_paciente = $row['id_treino_paciente'];

					// buscar xxx
					$sqlA = "SELECT prog_atividade.*, prog_atividade_paciente.*  FROM prog_atividade_paciente INNER JOIN prog_atividade ON prog_atividade.id_atividade = prog_atividade_paciente.id_atividade WHERE prog_atividade_paciente.id_treino_paciente = '$id_treino_paciente' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
						echo '<table class="table table-striped table-hover table-condensed">';
						echo '<thead>';
						echo '<tr>';
						echo '<th>Nome</th>';
						echo '<th class="Largura">Acertos</th>';
						echo '<th class="Largura">Erros</th>';
						echo '<th class="Largura">Total</th>';
						echo '<th class="Largura">Dicas</th>';
						echo '<th>Observação</th>';
						echo '<th class="Largura">Ação</th>';
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$id_atividade_titulo = $rowA['id_atividade_titulo'];
							$id_atividade = $rowA['id_atividade'];
							$id_atividade_paciente = $rowA['id_atividade_paciente'];
							$NomeAtividade = $rowA['NomeAtividade'];
							$Acertos = $rowA['Acertos'];
							$Erros = $rowA['Erros'];
							$Total = $rowA['Total'];
							$Dica = $rowA['Dica'];
							echo '<tr>';
							echo '<td style="vertical-align: middle;">'.$NomeAtividade.'</td>';
							echo '<td><input type="number" class="form-control" name="Acertos" value="'.$Acertos.'"></td>';
							echo '<td><input type="number" class="form-control" name="Erros" value="'.$Erros.'"></td>';
							echo '<td><input type="number" class="form-control" name="Total" value="'.$Total.'"></td>';
							echo '<td><input type="number" class="form-control" name="Dica" value="'.$Dica.'"></td>';
							echo '<td><textarea rows="1" class="form-control"></textarea></td>';
							echo '<td>';
							echo '<button type="submit" class="btn btn-success" style="margin-right: 5px;">&#x2714;</button>';
							echo '<a href="remover-atividade-treino.php?id_paciente='.$id_paciente.'&id_atividade_paciente='.$id_atividade_paciente.'&id_treino_paciente='.$id_treino_paciente.'" class="btn btn-default">&#x2716;</a>';
							echo '</td>';
							echo '</tr>';
					    }
					    echo '</tbody>';
						echo '</table>';

						?>
						<!-- adicionar atividade -->
						<form action="adicionar-atividade-ao-objetivo-2.php?id_atividade_titulo=<?php echo $id_atividade_titulo;?>&id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
							<div class="form-group">
								<label>Adicionar passo a passo:</label>
								<select class="form-control" name="id_atividade" required>
									<option value="">Selecionar</option>
									<?php
									// buscar xxx
									$sql = "SELECT * FROM prog_atividade ORDER BY NomeAtividade ASC";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
											$id_atividade = $row['id_atividade'];
											$NomeAtividade = $row['NomeAtividade'];
											echo '<option value="'.$id_atividade.'">'.$NomeAtividade.'</option>';
									    }
									} else {
									}
									?>
								</select>
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</form>
						<?php
					} else {
						// não tem
						?>
						<!-- adicionar atividade -->
						<form action="associar-atividade-ao-objetivo-2.php?id_objetivo_paciente=<?php echo $id_objetivo_paciente;?>&id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
							<div class="form-group">
								<label>Associar atividade padrão:</label>
								<select class="form-control" name="id_atividade_titulo" required>
									<option value="">Selecionar</option>
									<?php
									// buscar xxx
									$sql = "SELECT * FROM prog_atividade_titulo ORDER BY NomeTitulo ASC";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
											$id_atividade_titulo = $row['id_atividade_titulo'];
											$NomeTitulo = $row['NomeTitulo'];
											echo '<option value="'.$id_atividade_titulo.'">'.$NomeTitulo.'</option>';
									    }
									} else {
									}
									?>
								</select>
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</form>
						<?php
 					}
			    }
			} else {
				// não tem
			}
			?>
		</div>
	</div>

			
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
