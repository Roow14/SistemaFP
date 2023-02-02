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
	// buscar xxx
	$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_categoriaX = $row['id_categoria'];
			$NomeCategoriaX = $row['NomeCategoria'];
			$FiltroCategoria = 'WHERE id_categoria = '.$id_categoriaX;
	    }
	} else {
		// não tem
	}
} else {
	$id_categoriaX = $_SESSION['id_categoria'];

	if ($id_categoriaX == 99) {
		$FiltroCategoria = NULL;
		$NomeCategoriaX = 'Todas as categorias';
	} else {
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
}

if (empty($_SESSION['id_periodo'])) {
	$id_periodoX = 1;
    $NomePeriodoX = 'Manhã';
    $FiltroPeriodo = 'WHERE Periodo = 1';
    $FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1';
} else {
    $id_periodoX = $_SESSION['id_periodo'];
	// buscar xxx
	if ($id_periodoX == 10) {
		$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2' ;
		$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1 OR categoria_profissional.id_periodo = 2';
		$NomePeriodoX = 'Manhã e tarde';
	} elseif ($id_periodoX == 11) {
		$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3' ;
		$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 2 OR categoria_profissional.id_periodo = 3';
		$NomePeriodoX = 'Tarde e noite';
	} else {
		$FiltroPeriodo = NULL;
		// buscar xxx
		$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodoX'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_periodo = $row['id_periodo'];
				$NomePeriodoX = $row['NomePeriodo'];
				$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
				$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = '.$id_periodo;
		    }
		} else {
			// não tem
			$id_periodoX = 1;
		    $NomePeriodoX = 'Manhã';
		    $FiltroPeriodo = NULL;
		    $FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1';
		}
	}
	
}

if (empty($_SESSION['id_unidade'])) {
	// não tem
	$id_unidadeX = 1;
	$NomeUnidadeX = 'Matriz';
} else {
	$id_unidadeX = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidadeX'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidadeX = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
    body {
        background-color: #f2dede;
    }
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div style="padding: 0 25px;">

            <h3>Agenda</h3>

            <!-- filtros -->
            <div>
	            <form action="aplicar-filtro-data.php" method="post" class="form-inline" style="position: relative; float: left; margin-right: 15px;">
	            	<label>Data</label>
					<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
					
					<button class="btn btn-success">Confirmar</button>
					<a href="agendar-data-anterior-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">&lsaquo; Anterior</a>
					<a href="agendar-data-proxima-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">Próxima &rsaquo;</a>
	            </form>

	            <form action="aplicar-filtro-categoria-profissional.php" method="post" class="form-inline" style="position: relative; float: left;">
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
							echo '<option value="99">Todas as categorias</option>';
						} else {
						}
						?>
	            	</select>

	            	<div class="form-group">
						<label>Período</label>
						<select class="form-control" name="id_periodo" required>
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

					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="id_unidade" required>
							<option value="<?php echo $id_unidadeX;?>"><?php echo $NomeUnidadeX;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY Unidade ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_unidade = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>

	            	<button type="submit" class="btn btn-success">Confirmar</button>
	            </form>
	            <div style="clear: both;"></div>
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
	        
			<!-- categoria -->
			<?php
			// buscar dados
			$sql = "SELECT * FROM categoria $FiltroCategoria ORDER BY NomeCategoria ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				// echo '<th>Categoria</th>';
				echo '<th>Terapeuta</th>';
				// echo '<th>Função</th>';
				// buscar xxx
				$sqlA = "SELECT * FROM hora $FiltroPeriodo ORDER BY Ordem ASC";
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
							$id_funcao = $rowA['id_funcao'];
							// buscar dados
							echo '<tr>';
							
							// buscar dados
							echo '<td>';
							$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
							$resultB = $conn->query($sqlB);
							if ($resultB->num_rows > 0) {
							    while($rowB = $resultB->fetch_assoc()) {
									$NomeCurto = $rowB['NomeCurto'];
									echo '<a href="agenda-profissional.php?id_profissional='.$id_profissional.'&id_periodo='.$id_periodoX.'&id_unidade='.$id_unidadeX.'" class="Link">'.$NomeCurto.'</a>';
									

									$sqlC = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
									$resultC = $conn->query($sqlC);
									if ($resultC->num_rows > 0) {
									    while($rowC = $resultC->fetch_assoc()) {
											$NomeFuncao = $rowC['NomeFuncao'];
											// echo $NomeFuncao;
											if (empty($NomeFuncao)) {
												echo ' - <span style="font-size:0.8em;">'.$NomeCategoria.'</span>';
											} else {
												echo ' - <span style="font-size:0.8em;">'.$NomeCategoria.' ('.$NomeFuncao.'</span>)';
											}
											
									    }
									} else {
										// echo '';
										$NomeFuncao = NULL;
										echo ' - <span style="font-size:0.8em;">'.$NomeCategoria.'</span>';
									}
							    }
							} else {
								echo '';
							}
							echo '</td>';

							$sqlB = "SELECT * FROM hora $FiltroPeriodo ORDER BY Ordem ASC";
							$resultB = $conn->query($sqlB);
							if ($resultB->num_rows > 0) {
							    while($rowB = $resultB->fetch_assoc()) {
									$id_hora = $rowB['id_hora'];
									// buscar xxx
									$sqlC = "SELECT * FROM agenda_paciente WHERE Data = '$DataAgenda' AND id_hora = '$id_hora' AND id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidadeX'";
									$resultC = $conn->query($sqlC);
									if ($resultC->num_rows > 0) {
									    while($rowC = $resultC->fetch_assoc()) {
											// $id_sessao = $rowC['id_sessao'];
											$id_paciente = $rowC['id_paciente'];
											// $id_sessao_paciente = $rowC['id_sessao_paciente'];

											// buscar xxx
											$sqlD = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
											$resultD = $conn->query($sqlD);
											if ($resultD->num_rows > 0) {
											    while($rowD = $resultD->fetch_assoc()) {
													$NomeCurtoPaciente = $rowD['NomeCurto'];
													echo '<td><a href="agenda-paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCurtoPaciente.'</a></td>';
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
