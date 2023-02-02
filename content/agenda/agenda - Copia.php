<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}

// filtro por categoria
if (empty($_SESSION['id_categoria'])) {
	$id_categoriaX = NULL;
	$NomeCategoriaX = 'Selecionar';
	$FiltroCategoria = NULL;
} else {
	$id_categoriaX = $_SESSION['id_categoria'];
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoriaX = $row['NomeCategoria'];
	    }
	} else {
	}
	$FiltroCategoria = 'WHERE id_categoria = '.$id_categoriaX;
}

if (empty($_SESSION['id_periodo'])) {
	$id_periodoX = 1;
    $NomePeriodoX = 'Manhã';
    $FiltroPeriodo = 'WHERE Periodo = 1';
    $FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1';

} else {
    $id_periodoX = $_SESSION['id_periodo'];
	// buscar xxx
	$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodoX'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_periodo = $row['id_periodo'];
			$NomePeriodoX = $row['NomePeriodo'];
			$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
			$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = '.$id_periodo;
	    }
	} else {
		$id_periodoX = 1;
	    $NomePeriodoX = 'Manhã';
	    $FiltroPeriodo = NULL;
	    $FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1';
	}
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

            <h3>Agenda</h3>
            <div style="position: relative; float: left; margin-right: 25px;">
	            <form action="aplicar-filtro-data.php" method="post" class="form-inline">
	            	<label>Data</label>
					<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
					<a href="agendar-data-anterior-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">&lsaquo; Anterior</a>
					<a href="agendar-data-proxima-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">Próxima &rsaquo;</a>
					<button class="btn btn-success">Confirmar</button>
	            </form>
	            <div>
	            	<?php
	            	// dia da semana
					$Data = date("d-m-Y", strtotime($DataAgenda));
					setlocale(LC_TIME,"pt");
					$DiaSemana = (strftime("%A", strtotime($Data)));
					echo '<label>Dia da semana:</label> '.$DiaSemana;
	            	?>
	            </div>
			</div>
			<div style=" float: left;">
	            <form action="aplicar-filtro-categoria-profissional.php" method="post" class="form-inline">
	            	<label>Categoria:</label>
	            	<select class="form-control" name="id_categoriaX">
	            		<?php
						// buscar xxx
						$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
						    while($row = $result->fetch_assoc()) {
								$id_categoriaX = $row['id_categoria'];
								$NomeCategoriaX = $row['NomeCategoria'];
								echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
						    }
							echo '<option value="">Limpar filtro</option>';
						} else {
						}
						?>
	            	</select>

	            	<div class="form-group" style="margin-bottom: 5px;">
						<label>Período</label>
						<select class="form-control" name="id_periodo">
							<option value="<?php echo $id_periodoX;?>"><?php echo $NomePeriodoX;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM periodo ORDER BY Periodo ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_periodo = $row['id_periodo'];
									$NomePeriodo = $row['NomePeriodo'];
									echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>

	            	<button type="submit" class="btn btn-success">Confirmar</button>
	            </form>
	        </div>

	        <div style="clear: both;"></div>

			<div style="margin-top: 25px;">
				<?php
				// buscar dados
				$sql = "SELECT * FROM categoria $FiltroCategoria ORDER BY NomeCategoria ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					echo '<table class="table table-striped table-hover table-condensed">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>Categoria</th>';
					echo '<th>Profissional</th>';
					echo '<th>Função</th>';
					// buscar xxx
					$sqlA = "SELECT * FROM hora $FiltroPeriodo ORDER BY Ordem";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$Hora = $rowA['Hora'];
							echo '<th>'.$Hora.'</th>';
					    }
					} else {
					}
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
				    while($row = $result->fetch_assoc()) {
				    	$id_categoria = $row['id_categoria'];
				    	$NomeCategoria = $row['NomeCategoria'];

				    	// buscar dados
						$sqlA = "SELECT categoria_profissional.*, profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' $FiltroPeriodo1 ORDER BY profissional.NomeCurto ASC";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
							
						    while($rowA = $resultA->fetch_assoc()) {
								$id_profissional = $rowA['id_profissional'];
								// buscar dados
								echo '<tr>';
				    			echo '<td>'.$NomeCategoria.'</td>';
								
								echo '<td>';
								$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
								$resultB = $conn->query($sqlB);
								if ($resultB->num_rows > 0) {
								    while($rowB = $resultB->fetch_assoc()) {
										$NomeCurto = $rowB['NomeCurto'];
										echo '<a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCurto.'</a>';
								    }
								} else {
									echo '';
								}
								echo '</td>';
								
								$id_funcao = $rowA['id_funcao'];
								// buscar dados
								echo '<td>';
								$sqlC = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
								$resultC = $conn->query($sqlC);
								if ($resultC->num_rows > 0) {
								    while($rowC = $resultC->fetch_assoc()) {
										$NomeFuncao = $rowC['NomeFuncao'];
										echo $NomeFuncao;
								    }
								} else {
									echo '';
								}
								echo '</td>';

								$sqlB = "SELECT * FROM hora $FiltroPeriodo ORDER BY Ordem";
								$resultB = $conn->query($sqlB);
								if ($resultB->num_rows > 0) {
								    while($rowB = $resultB->fetch_assoc()) {
										$id_hora = $rowB['id_hora'];
										// buscar xxx
										$sqlC = "SELECT * FROM sessao WHERE DataSessao = '$DataAgenda' AND id_hora = '$id_hora' AND id_profissional = '$id_profissional' AND id_categoria = '$id_categoria'";
										$resultC = $conn->query($sqlC);
										if ($resultC->num_rows > 0) {
										    while($rowC = $resultC->fetch_assoc()) {
												$id_sessao = $rowC['id_sessao'];
												$id_paciente = $rowC['id_paciente'];
												$id_sessao_paciente = $rowC['id_sessao_paciente'];

												// buscar xxx
												$sqlD = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
												$resultD = $conn->query($sqlD);
												if ($resultD->num_rows > 0) {
												    while($rowD = $resultD->fetch_assoc()) {
														$NomeCurtoPaciente = $rowD['NomeCurto'];
														echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCurtoPaciente.'</a></td>';
												    }
												} else {
												}
										    }
										} else {
											echo '<td></td>';
										}
								    }
								} else {
								}
								echo '</tr>';
						    }
						} else {
						}
						
				    }
				    echo '</tbody>';
					echo '</table>';
				} else {
					echo 'Não encontramos nenhuma categoria.';
				}
				?>
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
