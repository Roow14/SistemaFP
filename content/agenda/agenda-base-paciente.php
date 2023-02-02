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

// input
if (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
}
if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
}

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

if (!empty($_SESSION['Periodo'])) {
	$PeriodoAgenda = $_SESSION['Periodo'];

	// buscar xxx
	$sql = "SELECT * FROM periodo WHERE Periodo = '$PeriodoAgenda'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$PeriodoAgenda = $row['Periodo'];
			$NomePeriodoAgenda = $row['NomePeriodo'];
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$PeriodoAgenda = NULL;
	$NomePeriodoAgenda = 'Selecionar';
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

// buscar avaliação ativa para utilizar as horas na agenda base
$sql = "SELECT * FROM avaliacao WHERE id_paciente = '$id_paciente' AND Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $id_avaliacao = $row['id_avaliacao'];
    }
} else {
    // não tem
    $id_avaliacao = NULL;
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.janela {
	    background-color: #fafafa;
	    /*min-height: 300px;*/
	    padding: 15px;
	    border-left: 1px solid #ddd;
	    border-right: 1px solid #ddd;
	    border-bottom: 1px solid #ddd;
	    border-radius: 4px;
	}
	.conteudo {

	}
	li {
		list-style: none;
	}
	.Link {
		background-color: transparent;
		border: none;
	}
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
	.ajuste-botao {
		float: right;
	}

	.btn-view {
		display: none;
	}
	td:hover .btn-view {
		display: block;
	}
	.btn-size {
		width:  36px;
		height: 34px;
	}
	.box-1 {
		margin-bottom: 25px;
	} 
	@media only screen and (min-width:  768px) {
		.box {
			display: flex;
			flex-wrap: wrap;
			width: 100%;
		}
		.box-1 {
			width: 50%;
		}
		.box-2 {
			width: 50%;
			padding-left: 25px;
			padding-right: 25px;
		}
	}
	.laranja {
		background-color: #f9deb9;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

		<div id="conteudo">

<h2>Paciente</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
	<li class="active"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<div class="box">
		<div class="box-1">
			<label>Nome:</label> <?php echo $NomePaciente;?><br>
			<label>Horário de preferência:</label> <?php echo $PacientePreferencia;?>
			<?php
			if (!empty($_SESSION['RemoverTerapeuta'])) {
				echo '<a href="agenda-base-paciente-ativar-remocao-2.php" class="btn btn-success">Fechar remoção</a>';
			} else {
				if (!empty($_SESSION['AgendarTerapeuta'])) {
					include 'agenda-base-paciente-filtro.php';
				} else {
					echo '<a href="agenda-base-paciente-ativar-filtro-2.php" class="btn btn-success">Agendar terapeuta</a>';
					echo '<a href="agenda-base-paciente-ativar-remocao-2.php" class="btn btn-default">Remover terapeuta</a>';
				}
			}
			?>
		</div>
		<div class="box-2">
			<label>Terapias por semana (agendado / plano):</label><br>
			<?php
			if (!empty($id_avaliacao)) {
				// buscar xxx
				$sql = "SELECT categoria_paciente.*, categoria.NomeCategoria
		        FROM categoria_paciente
		        INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria
		        WHERE categoria_paciente.id_avaliacao = '$id_avaliacao'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_categoria_paciente = $row['id_categoria_paciente'];
		                $id_categoriaX = $row['id_categoria'];
		                $NomeCategoriaX = $row['NomeCategoria'];
		                $HorasX = $row['Horas'];

		                $sqlA = "SELECT COUNT(id_agenda_paciente_base) AS Soma FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaX' ";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
							// tem
							while($rowA = $resultA->fetch_assoc()) {
								$Soma = $rowA['Soma'];
							}
						// não tem
						} else {
							$Soma = 0;
						}

						if ($Soma == $HorasX) {
							echo $NomeCategoriaX.' ('.$Soma.' / '.$HorasX.')<br>';
						} else {
							echo '<mark class="laranja">'.$NomeCategoriaX.' ('.$Soma.' / '.$HorasX.') - corrigir</mark><br>';
						}
		                
				    }
				} else {
					// não tem
					echo 'Não foi encontrado nenhum plano terapêutico.';
				}

				// buscar xxx
				$sql = "SELECT DISTINCT categoria.NomeCategoria, agenda_paciente_base.id_categoria FROM agenda_paciente_base
				INNER JOIN categoria ON agenda_paciente_base.id_categoria = categoria.id_categoria
				WHERE agenda_paciente_base.id_paciente = '$id_paciente' ";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_categoriaY = $row['id_categoria'];
						$NomeCategoriaY = $row['NomeCategoria'];

						// buscar xxx
						$sqlA = "SELECT * FROM categoria_paciente WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaY' ";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
						    while($rowA = $resultA->fetch_assoc()) {
								// tem
						    }
						} else {
							// não tem
							echo '<mark class="laranja">'.$NomeCategoriaY.' - não está no plano terapêutico</mark><br>';
						}
				    }
				} else {
					// não tem
				}
			} else {
				echo 'Não foi encontrado nenhum plano terapêutico.';
			}
			?>
		</div>
	</div>

	<!-- terapeutas -->
	<div style="margin-top: 15px;">
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
			<tr>
			<th>Hora</th>
			<th class="largura-col">Segunda</th>
			<th class="largura-col">Terça</th>
			<th class="largura-col">Quarta</th>
			<th class="largura-col">Quinta</th>
			<th class="largura-col">Sexta</th>
			</tr>
			</thead>
			<tbody>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM hora WHERE Status = 1";
				$result1 = $conn->query($sql);
				if ($result1->num_rows > 0) {
				    while($row = $result1->fetch_assoc()) {

						// tem
						$id_hora = $row['id_hora'];
						$Hora = $row['Hora'];
						$Periodo = $row['Periodo'];

						echo '<tr>';
						echo '<td>'.$Hora.'</td>';

						echo '<td>';
						$DiaSemana = 2;
						include 'agenda-base-paciente-profissional.php';
						if (!empty($_SESSION['AgendarTerapeuta'])) {
							echo '<input type="button" name="view" value="+"id="'.$id_x.'" class="btn btn-success btn-view view_data" />';
						}
						echo '</td>';

						echo '<td>';
						$DiaSemana = 3;
						include 'agenda-base-paciente-profissional.php';
						if (!empty($_SESSION['AgendarTerapeuta'])) {
							echo '<input type="button" name="view" value="+"id="'.$id_x.'" class="btn btn-success btn-view view_data" />';
						}
						echo '</td>';

						echo '<td>';
						$DiaSemana = 4;
						include 'agenda-base-paciente-profissional.php';
						if (!empty($_SESSION['AgendarTerapeuta'])) {
							echo '<input type="button" name="view" value="+"id="'.$id_x.'" class="btn btn-success btn-view view_data" />';
						}
						echo '</td>';

						echo '<td>';
						$DiaSemana = 5;
						include 'agenda-base-paciente-profissional.php';
						if (!empty($_SESSION['AgendarTerapeuta'])) {
							echo '<input type="button" name="view" value="+"id="'.$id_x.'" class="btn btn-success btn-view view_data" />';
						}
						echo '</td>';

						echo '<td>';
						$DiaSemana = 6;
						include 'agenda-base-paciente-profissional.php';
						if (!empty($_SESSION['AgendarTerapeuta'])) {
							echo '<input type="button" name="view" value="+"id="'.$id_x.'" class="btn btn-success btn-view view_data" />';
						}
						echo '</td>';

						echo '</tr>';
				    }
				} else {
					// não tem
				}
				?>
			</tbody>
			</table>
	</div>
</div>

<!-- agendar terapia -->
<div id="dataModal" class="modal fade">  
	<div class="modal-dialog">
		<?php
		if (!empty($id_unidade)) {
			?>
			<form action="agenda-base-modal-2.php" method="post">
				<div class="modal-content">  
					<div class="modal-header">  
					     <button type="button" class="close" data-dismiss="modal">&times;</button>  
					     <h4 class="modal-title">Agendar</h4>  
					</div>  
					<div class="modal-body" id="detalhe"></div>  
					<div class="modal-footer">  
					     <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>  
						 <button type="submit" class="btn btn-success" >Agendar</button>  
					</div>  
				</div>  
			</form>
			<?php
		} else {
			?>
			<div class="modal-content">  
				<div class="modal-header">  
				     <button type="button" class="close" data-dismiss="modal">&times;</button>  
				     <h4 class="modal-title">Agendar</h4>  
				</div>  
				<div class="modal-body">
					Selecione a categoria, unidade e o período do terapeuta.
				</div>  
				<div class="modal-footer">  
				     <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>  
				</div>  
			</div>  
			<?php
		}
		?>	
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

<script>
$('.view_data').click(function(){  
	let item_id = $(this).attr("id");
	$.ajax({  
		url:"agenda-base-modal.php",  
		method:"post",  
		data:{
			item_id:item_id,
		},  
		success:function(data){  
			$('#detalhe').html(data);  
			$('#dataModal').modal("show");  
		}  
	});  
 }); 
</script>

<!-- mantem a posição após o reload -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
</body>
</html>
