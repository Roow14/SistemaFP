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
$_SESSION['id_paciente'] = $_GET['id_paciente'];
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['DataSessao'])) {
} else {
	$_SESSION['DataAgenda'] = $_GET['DataSessao'];
}


if (isset($_GET['id_sessao_paciente'])) {
	$id_sessao_paciente = $_GET['id_sessao_paciente'];
	$_SESSION['id_sessao_paciente'] = $_GET['id_sessao_paciente'];
} elseif (isset($_SESSION['id_sessao_paciente'])) {
	$id_sessao_paciente = $_SESSION['id_sessao_paciente'];
} else {

}

if (isset($_GET['id_categoria'])) {
	$id_categoria = $_GET['id_categoria'];
	$_SESSION['id_categoria'] = $_GET['id_categoria'];
	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
	}
} elseif (isset($_SESSION['id_categoria'])) {
	$id_categoria = $_SESSION['id_categoria'];
	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
	}
} else {

}

if (empty($_GET['id_periodo'])) {
} else {
	$id_periodo = $_GET['id_periodo'];
	$_SESSION['id_periodo'] = $_GET['id_periodo'];
}

if (empty($_GET['id_unidade'])) {
} else {
	$id_unidade = $_GET['id_unidade'];
	$_SESSION['id_unidade'] = $_GET['id_unidade'];
}

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$id_periodo = $row['id_periodo'];
		$id_unidade = $row['id_unidade'];

		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			$NomePeriodo = 'Nenhum';
		}

		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeUnidade = $rowA['NomeUnidade'];
		    }
		} else {
			$NomeUnidade = 'Nenhum';
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM sessao_paciente WHERE id_sessao_paciente = '$id_sessao_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$SessaoInicial = $row['SessaoInicial'];
		$SessaoAgendada = $row['SessaoAgendada'];
		$SessaoFinal = $row['SessaoFinal'];
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$PacientePreferencia = $row['PacientePreferencia'];
    }
} else {
	$PacientePreferencia = NULL;
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.mesma-linha {
		clear: both;
	    display: inline-block;
	    overflow: hidden;
	    white-space: nowrap;
	}
	.link-apagar {
		color: #5cb85c;
		font-weight: 600;
	}
	.link-apagar:hover {
		color: #f0ad4e;
		font-weight: 600;
	}
	@media screen and (min-width: 900px) {
		.form-left {
			float: left;
		}
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="">
<div class="">
	<h3>Agendar sessão</h3>
	<span style="margin-right: 25px;"><label>Nome do paciente:</label> <?php echo $NomeCompleto;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Preferência de período:</label> <?php echo $NomePeriodo;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Preferência de unidade:</label> <?php echo $NomeUnidade;?></span>
	<br>
	<span style="margin-right: 25px; display: inline-block;"><label>Id:</label> <?php echo $id_sessao_paciente;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Categoria:</label> <?php echo $NomeCategoria;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Nº sessões:</label> <?php echo $SessaoInicial;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Nº sessões agendadas:</label> <?php echo $SessaoAgendada;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Preferência de data e horário:</label> <?php echo $PacientePreferencia;?></span>
</div>

<?php
	// buscar
	if (empty($_SESSION['id_categoria'])) {
		$id_categoria = NULL;
		$NomeCategoria = 'Selecionar';
		$FiltroCategoria = NULL;
	} else {
		$id_categoria = $_SESSION['id_categoria'];
		// buscar dados
		$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$NomeCategoria = $row['NomeCategoria'];
		    }
		} else {
		}
		$FiltroCategoria = 'WHERE id_categoria = '.$id_categoria;
	}

	// buscar
	if (empty($_SESSION['id_periodo'])) {
		$id_periodo = NULL;
		$NomePeriodo = 'Selecionar';
		$FiltroPeriodo = NULL;
	} else {
		$id_periodo = $_SESSION['id_periodo'];
		// buscar dados
		$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$NomePeriodo = $row['NomePeriodo'];
				$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
				$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = '.$id_periodo;
		    }
		} else {
		}
	}

	// buscar
	if (empty($_SESSION['id_unidade'])) {
		$id_unidade = NULL;
		$NomeUnidade = 'Selecionar';
		$FiltroUnidade = NULL;
	} else {
		$id_unidade = $_SESSION['id_unidade'];
		// buscar dados
		$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$NomeUnidade = $row['NomeUnidade'];
				$FiltroUnidade = 'AND categoria_profissional.id_unidade = '.$id_unidade;
		    }
		} else {
		}
	}
?>

<!-- filtros -->
<div style="margin-top: 15px;">
	<div class="form-left" style="margin-bottom: 5px;">
		
		<?php
		if (empty($_GET['Origem'])) {
			?>
			<a href="listar-sessoes.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default" style="margin-right: 25px;">&lsaquo; Voltar</a>
			<?php
		} else {
			?>
			<a href="<?php echo $Origem;?>?id_paciente=<?php echo $id_paciente;?>&id_sessao_paciente=<?php echo $id_sessao_paciente;?>" class="btn btn-default" style="margin-right: 25px;">&lsaquo; Voltar</a>
			<?php
		}
		?>
	</div>
	<div class="form-left" style="margin-bottom: 5px;">
        <form action="aplicar-filtro-data.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">

        	<label>Data</label>
			<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
			<span>
	        	<?php
	        	// dia da semana
				$Data = date("d-m-Y", strtotime($DataAgenda));
				setlocale(LC_TIME,"pt");
				$DiaSemana = (strftime("%A", strtotime($Data)));
				echo '<label>Dia da semana:</label> '.$DiaSemana;
	        	?>
	        </span>
			<a href="agendar-data-anterior-1.php?DataAgenda=<?php echo $DataAgenda;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">&lsaquo; Anterior</a>
			<a href="agendar-data-proxima-1.php?DataAgenda=<?php echo $DataAgenda;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Próxima &rsaquo;</a>
			<button class="btn btn-success">Confirmar</button>
        </form>
        
	</div>
	<div style="clear: both;">
		<form action="salvar-configuracao-agenda-paciente.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
			<div class="form-group">
				<label>Período</label>
				<select class="form-control" name="id_periodo">
					<option value="<?php echo $id_periodo;?>"><?php echo $NomePeriodo;?></option>
					<?php
					// buscar xxx
					$sqlA = "SELECT * FROM periodo";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomePeriodo = $rowA['NomePeriodo'];
							$id_periodo = $rowA['id_periodo'];

							echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
					    }
					} else {
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<label>Unidade</label>
				<select class="form-control" name="id_unidade">
					<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
					<?php
					// buscar xxx
					$sqlA = "SELECT * FROM unidade";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomeUnidade = $rowA['NomeUnidade'];
							$id_unidade = $rowA['id_unidade'];

							echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
					    }
					} else {
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success">Confirmar</button>
			</div>
		</form>
	</div>
</div>

<div style="margin-top: 15px; text-align: center;">
	<?php
	if (empty($_SESSION['ErroPacienteAgendado'])) {
		
	} else {
		?>
		<div class="alert alert-danger">
			<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&Origem=agendar-sessao.php" style="float: right;">&#x2716;</a>
			<b>Erro:</b> o paciente já tem uma agenda marcada para esta data.<br>
			Favor escolher outra data.
		</div>
		<?php
	}
	?>
</div>

<div style="margin-top: 15px;">
	<?php
	// buscar dados
	$sql = "SELECT * FROM categoria $FiltroCategoria ORDER BY NomeCategoria ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		// echo '<th>Categoria</th>';
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
			$sqlA = "SELECT categoria_profissional.*, profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' $FiltroUnidade $FiltroPeriodo1 ORDER BY profissional.NomeCurto ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
				
			    while($rowA = $resultA->fetch_assoc()) {
					$id_profissional = $rowA['id_profissional'];
					// buscar dados
					echo '<tr id="'.$id_profissional.'">';
					
					echo '<td>';
					$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
					    while($rowB = $resultB->fetch_assoc()) {
							$NomeCurto = $rowB['NomeCurto'];
							echo '<a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCurto.'</a>';
					    }
					} else {
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
							$Hora = $rowB['Hora'];

							echo '<td>';

							// buscar xxx
							$sqlD = "SELECT * FROM agenda_profissional WHERE id_profissional = '$id_profissional' AND DataSessao = '$DataAgenda' AND id_hora = '$id_hora'";
							$resultD = $conn->query($sqlD);
							if ($resultD->num_rows > 0) {
							    while($rowD = $resultD->fetch_assoc()) {
									$id_sessao = $rowD['id_sessao'];
									$id_pacienteX = $rowD['id_paciente'];

									// buscar xxx
									$sqlE = "SELECT * FROM paciente WHERE id_paciente = '$id_pacienteX'";
									$resultE = $conn->query($sqlE);
									if ($resultE->num_rows > 0) {
									    while($rowE = $resultE->fetch_assoc()) {
											$NomeCurto = $rowE['NomeCurto'];

											if ($id_pacienteX == $_SESSION['id_paciente']) {
												echo '<div style="display: inline-block;">';
										    	echo '<a href="remover-agenda-sessao-profissional.php?id_sessao='.$id_sessao.'&id_paciente='.$id_pacienteX.'&id_sessao_paciente='.$id_sessao_paciente.'" data-toggle="tooltip" title="Clique para remover" class="link-apagar">'.$NomeCurto.'</a>';
										    	echo '</div>';
											} else {
												echo $NomeCurto;
											}
									    }
									} else {
									}								
							    }
							} else {
								$id_paciente = $_SESSION['id_paciente'];
								echo '<a href="agendar-sessao-profissional.php?id_profissional='.$id_profissional.'&id_paciente='.$id_paciente.'&DataSessao='.$DataAgenda.'&id_hora='.$id_hora.'&id_categoria='.$id_categoria.'&id_unidade='.$id_unidade.'&id_sessao_paciente='.$id_sessao_paciente.'" class="btn btn-default">&#x2713;</a>';
							}

							echo '</td>';
							
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
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
</script>
</body>
</html>
