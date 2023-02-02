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
if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
} elseif (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
} else {
	$id_paciente = NULL;
}

if (isset($id_paciente)) {
	// buscar xxx
	$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_paciente = $row['id_paciente'];
			$NomePaciente = $row['NomeCompleto'];
			$id_periodo = $row['id_periodo'];
			$id_unidade = $row['id_unidade'];

			if ($id_periodo == 10) {
				$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2';
			} elseif ($id_periodo == 11) {
				$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3';
			} else {
				$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
			}

			// buscar xxx
			$sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$PacientePreferencia = $rowA['PacientePreferencia'];
			    }
			} else {
				// não tem
				$PacientePreferencia = NULL;
			}

			// buscar xxx
			$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$NomePeriodo = $rowA['NomePeriodo'];
					$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
			    }
			} else {
				// não tem
				// mensagem de alerta
				echo "<script type=\"text/javascript\">
				    alert(\"Erro: cadastrar o período de atendimento.\");
				    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
				    </script>";
				exit;
			}
			// buscar xxx
			$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$NomeUnidade = $rowA['NomeUnidade'];
			    }
			} else {
				// não tem
				// mensagem de alerta
				echo "<script type=\"text/javascript\">
				    alert(\"Erro: cadastrar a unidade de atendimento.\");
				    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
				    </script>";
				exit;
			}
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$id_paciente = NULL;
	$NomePaciente = 'Selecionar paciente';
	$FiltroPeriodo = NULL;
	$id_unidade = NULL;
	$id_periodo = NULL;
	$NomePeriodo = NULL;
	$NomeUnidade = NULL;
	$PacientePreferencia = NULL;
}

if (empty($_SESSION['id_categoria'])) {
	// não tem
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
} else {
	$id_categoria = $_SESSION['id_categoria'];

	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_categoria = $row['id_categoria'];
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		// não tem
	}
}

if (empty($_SESSION['id_unidade'])) {
	// não tem
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
} else {
	$id_unidade = $_SESSION['id_unidade'];

	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_unidade = $row['id_unidade'];
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
}

if (empty($_SESSION['id_hora'])) {
	// não tem
	$id_hora = NULL;
	$Hora = 'Selecionar';
} else {
	$id_hora = $_SESSION['id_hora'];

	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora' AND Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_hora = $row['id_hora'];
			$Hora = $row['Hora'];
	    }
	} else {
		// não tem
	}
}

if (empty($_SESSION['DiaSemana'])) {
	$DiaSemana = NULL;
	$NomeDiaSemana = 'Selecionar';
} else {
	$DiaSemana = $_SESSION['DiaSemana'];
	if ($DiaSemana == 2) {
		$NomeDiaSemana = 'Segunda';
	} elseif ($DiaSemana == 3) {
		$NomeDiaSemana = 'Terça';
	} elseif ($DiaSemana == 4) {
		$NomeDiaSemana = 'Quarta';
	} elseif ($DiaSemana == 5) {
		$NomeDiaSemana = 'Quinta';
	} elseif ($DiaSemana == 6) {
		$NomeDiaSemana = 'Sexta';
	} else {
		$NomeDiaSemana = NULL;
	}
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.largura-col {
		width: 20%;
	}
	.largura-col span {
		font-weight: 300;
		font-size: 16px;
	}
	.link-apagar {
		color: orange;
	}
	.link-apagar:hover {
		color: red;
	}
	.cabecalho {
		margin-top: -15px;
	}
	.btn-custom {
		padding: 3px 5px;
    	border-radius: 15px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div style="padding: 0 25px;">
        	<div class="cabecalho">
        		<h3>Agenda base da criança</h3>
        		<span style="margin-right: 25px;"><label>Nome:</label> <?php echo $NomePaciente;?></span>
        		<span style="margin-right: 25px;"><label>Horários de preferência:</label> <?php echo $PacientePreferencia;?></span>
			</div>
			
			<div class="hidden-print">
				<h4>Agendar terapeuta <a href="" type="button" data-toggle="modal" data-target="#Ajuda" class="Link">&#9432;</a></h4>
				<form action="agenda-base-paciente-agendar-terapeuta-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
					<div class="form-group">
		            	<label>Dia da semana:</label>
						<select class="form-control" name="DiaSemana" value="<?php echo $DiaSemana;?>" required>
							<option value="<?php echo $DiaSemana;?>"><?php echo $NomeDiaSemana;?></option>
							<option value="2">Segunda</option>
							<option value="3">Terça</option>
							<option value="4">Quarta</option>
							<option value="5">Quinta</option>
							<option value="6">Sexta</option>
						</select>
					</div>
					<div class="form-group">
		            	<label>Horário:</label>
						<select class="form-control" name="id_hora" value="<?php echo $id_hora;?>" required>
							<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora WHERE Status = 1 ORDER BY Ordem ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_horaX = $row['id_hora'];
									$Hora = $row['Hora'];
									echo '<option value="'.$id_horaX.'">'.$Hora.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoriaX" required>
							<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_categoriaX = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<option value="'.$id_categoriaX.'">'.$NomeCategoria.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="id_unidadeX" required>
							<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_unidadeX = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidadeX.'">'.$NomeUnidade.'</option>';
							    }
							    echo '<option value="">Limpar filtro</option>';
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-success">Confirmar</button>
					<a href="agenda-paciente-limpar-filtro.php" class="btn btn-default">Limpar filtro</a>
				</form>
				<form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
					<div class="form-group">
						<label>Terapeuta</label>
						<select class="form-control" name="id_profissionalX" required>
							<option value="">Selecionar</option>




							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$PeriodoY = $row['Periodo'];
							    }
							} else {
								// não tem
							}
						
							// buscar xxx
							$sql = "SELECT profissional.* 
							FROM categoria_profissional 
							INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional 
							WHERE categoria_profissional.id_categoria = '$id_categoria' 
							AND categoria_profissional.id_periodo = '$PeriodoY' 
							AND categoria_profissional.id_unidade = '$id_unidade' 
							AND profissional.Status = 1 
							ORDER BY profissional.NomeCompleto ASC";
							
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissionalX = $row['id_profissional'];
									$NomeProfissional = $row['NomeCompleto'];

									// verificar se o profissional está agendado neste horário
									$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissionalX' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
									$resultA = $conn->query($sqlA);
									if ($resultA->num_rows > 0) {
									    while($rowA = $resultA->fetch_assoc()) {
											// tem
											echo '<option value="">--- '.$NomeProfissional.' ---</option>';
									    }
									} else {
										// não tem
										echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
									}
							    }
							} else {
								// não tem
							}

							?>
						</select>
                        <form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
                            <div class="form-group">
                                <label>Aplicador</label>
                                <select class="form-control" name="id_profissionalX" required>
                                    <option value="">Selecionar</option>

                                    <?php
                                    // buscar xxx
                                    $sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            // tem
                                            $PeriodoY = $row['Periodo'];
                                        }
                                    } else {
                                        // não tem
                                    }

                                    // buscar xxx
                                    $sql = "SELECT profissional.* 
							FROM categoria_profissional 
							INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional 
							WHERE categoria_profissional.id_categoria = '$id_categoria' 
							AND categoria_profissional.id_periodo = '$PeriodoY' 
							AND categoria_profissional.id_unidade = '$id_unidade' 
							AND profissional.Status = 1 
							ORDER BY profissional.NomeCompleto ASC";

                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            // tem
                                            $id_profissionalX = $row['id_profissional'];
                                            $NomeProfissional = $row['NomeCompleto'];

                                            // verificar se o profissional está agendado neste horário
                                            $sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissionalX' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
                                            $resultA = $conn->query($sqlA);
                                            if ($resultA->num_rows > 0) {
                                                while($rowA = $resultA->fetch_assoc()) {
                                                    // tem
                                                    echo '<option value="">--- '.$NomeProfissional.' ---</option>';
                                                }
                                            } else {
                                                // não tem
                                                echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
                                            }
                                        }
                                    } else {
                                        // não tem
                                    }

                                    ?>
                                </select>

                            </div>
					</div>


            <form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
                <div class="form-group">
                    <label>Andar</label>
                    <select class="form-control" name="id_profissionalX" required>
                        <option value="">Selecionar</option>

                    </select>
                </div>
                <form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
                    <div class="form-group">
                        <label>Sala</label>
                        <select class="form-control" name="id_profissionalX" required>
                            <option value="">Selecionar</option>

                        </select>
                    </div>
                    <form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
                        <div class="form-group">
                            <label>Mesa</label>
                            <select class="form-control" name="id_profissionalX" required>
                                <option value="">Selecionar</option>

                                <?php
                                    // buscar xxx
                                    $sql = "SELECT * FROM `asm`";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            // tem
                                            $PeriodoY = $row['Periodo'];
                                        }
                                    } else {
                                        // não tem
                                    }
                                ?>

                            </select>
                        </div>
                    </form>
				<br><button type="submit" class="btn btn-success">Confirmar</button>
                        <a href="agenda-base-paciente.php" class="btn btn-success hidden-print">&lsaquo; Ver agenda</a>
			</div>
		</div>
    </div>
</div>

<!-- ajuda -->
<div id="Ajuda" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agendar terapeuta</h4>
			</div>
			<div class="modal-body">
				<p>Primeiramente, verfique se existe um terapeuta agendado no horário desejado. Se existir, clique no botão "X" e cancele o terapeuta.</p>
				<p>Em seguida selecione o dia da semana, hora, categoria, unidade e clique em confirmar.</p>
	            <p>Para finalizar, selecione o terapeuta e clique em confirmar.</p>
	            <p><b>Notas:</b></p>
	            <p>No <b>campo terapeuta</b> aparecerão somente os terapeutas que preenchem os requisitos do filtro aplicado: dia da semana, categoria e unidade.<br>
	            O sinal --- indica que o terapeuta já tem uma agenda para este horário.</p>
	            <p><b>Limpar filtro</b>: remove os filtros de dia da semana, categoria e unidade.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- filtro -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Ver agenda base de outra criança</h4>
			</div>
			<form action="agenda-base-paciente-selecionar-paciente.php" method="post" class="form-inline" style="margin-bottom: 15px;">
				<div class="modal-body">
	            	<!-- filtros -->
					<div class="form-group">
						<label>Nome</label>
						<select class="form-control" name="id_paciente" required>
							<option value="<?php echo $id_paciente;?>"><?php echo $NomePaciente;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_pacienteX = $row['id_paciente'];
									$NomePacienteX = $row['NomeCompleto'];
									echo '<option value="'.$id_pacienteX.'">'.$NomePacienteX.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- alterar dados -->
<div id="Alterar" class="modal " role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form action="" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agendar terapeuta</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
		            	<label>Data:</label>
						<input type="date" class="form-control" name="DataAgenda">
					</div>
					<div class="form-group">
		            	<label>Horário:</label>
						<select class="form-control" name="id_hora" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora ORDER BY Ordem ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_hora = $row['id_hora'];
									$Hora = $row['Hora'];
									echo '<option value="'.$id_hora.'">'.$Hora.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoriaX" data-toggle="tooltip" title="Selecione uma categoria e ative o campo de seleção do profissional." required>
							<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_categoriaX = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<option value="'.$id_categoriaX.'">'.$NomeCategoria.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="id_unidadeX" required>
							<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_unidadeX = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidadeX.'">'.$NomeUnidade.'</option>';
							    }
							    echo '<option value="">Limpar filtro</option>';
							} else {
								// não tem
							}
							?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- alterar dados -->
<div id="AgendarTerapeuta" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form action="agendar-terapeuta.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agendar terapeuta - passo 2</h4>
				</div>
				<div class="modal-body">
	            	<label>Data:</label>
					<input type="date" class="form-control" name="DataAgenda">
				</div>
				<div class="modal-body">
	            	<label>Horário:</label>
					<select class="form-control" name="id_hora" required>
						<option value="">Selecionar</option>
						<?php
						// buscar xxx
						$sql = "SELECT * FROM hora ORDER BY Ordem ASC ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_hora = $row['id_hora'];
								$Hora = $row['Hora'];
								echo '<option value="'.$id_hora.'">'.$Hora.'</option>';
						    }
						} else {
							// não tem
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
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
