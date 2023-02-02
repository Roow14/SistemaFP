<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// input
$id_unidade = $_SESSION['id_unidade'];
$id_categoria = $_SESSION['id_categoria'];
$DiaSemana = $_SESSION['DiaSemana'];

if ($id_unidade == 5) {
	// conexão com banco
	include '../conexao/conexao-coral.php';
} else {
	// conexão com banco
	include '../conexao/conexao.php';
}

// filtrar por hora
if (!empty($_SESSION['id_hora'])) {
	$id_hora = $_SESSION['id_hora'];
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
			// $FiltroHora = 'AND agenda_paciente_base.id_hora ='.$id_hora;
			$FiltroHora = 'AND hora.id_hora ='.$id_hora;
	    }
	} else {
		// não tem
	}
} else {
	$id_hora = NULL;
	$Hora = 'Todos';
	$FiltroHora = NULL;
}

// filtrar por dia da semana
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
} elseif ($DiaSemana == 7) {
	$NomeDiaSemana = 'Sábado';
}  else {
}
$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = '.$DiaSemana;


// filtrar por categoria
$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCategoria = $row['NomeCategoria'];
    }
} else {
}
$FiltroCategoria = 'AND agenda_paciente_base.id_categoria = '. $id_categoria;
// $FiltroCategoria = 'AND categoria_profissional.id_categoria = '. $id_categoria;

// filtrar por unidade
$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeUnidade = $row['NomeUnidade'];
    }
} else {
}
$FiltroUnidade = 'AND agenda_paciente_base.id_unidade = '. $id_unidade;

// $sql = "SELECT COUNT(profissional.id_profissional) AS Soma FROM categoria_profissional
// INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional
// $FiltroStatus $FiltroCategoria $FiltroUnidade $FiltroPeriodo
// ";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
// 	// tem
// 	while($row = $result->fetch_assoc()) {
// 		$Soma = $row['Soma'];
// 	}
// // não tem
// } else {
// 	$Soma = NULL;
// }
$Soma = NULL;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Relatório</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="index.php">Pacientes/região</a></li>
	<li class="inactive"><a href="pacientes-idade.php">Por idade</a></li>
	<li class="inactive"><a href="terapeutas-regiao.php">Terapeutas/região</a></li>
	<li class="inactive"><a href="terapeutas-funcao.php">Terapeutas/função</a></li>
	<li class="active"><a href="terapeutas-disponiveis.php">Terapeutas disponíveis</a></li>
	<li class="inactive"><a href="terapeutas-login.php">Terapeutas c/login</a></li>
</ul>

<div class="janela">
<h3>Terapeutas disponíveis - Agenda base</h3>

<form action="terapeutas-disponiveis-base-2.php" method="post" class="form-inline">

	<div class="form-group">
    	<label>Filtrar por função:</label>
        <select name="id_categoria" class="form-control" required>
			<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
			<?php
			$sqlA = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoriaX = $rowA['id_categoria'];
					$NomeCategoriaX = $rowA['NomeCategoria'];
					echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
			    }
			} else {
				// não tem
				$NomeCategoriaX = NULL;
			}
			?>
		</select>
    </div>

    <div class="form-group">
    	<label>Unidade:</label>
        <select name="id_unidade" class="form-control" required>
			<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
			<?php
			$sqlA = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_unidadeX = $rowA['id_unidade'];
					$NomeUnidadeX = $rowA['NomeUnidade'];
					echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
			    }
			} else {
				// não tem
				$NomeUnidadeX = NULL;
			}
			?>
		</select>
    </div>

    <div class="form-group">
    	<label>Dia da semana:</label>
		<select class="form-control" name="DiaSemana" required>
			<option value="<?php echo $DiaSemana;?>"><?php echo $NomeDiaSemana;?></option>
			<option value="2">Segunda</option>
			<option value="3">Terça</option>
			<option value="4">Quarta</option>
			<option value="5">Quinta</option>
			<option value="6">Sexta</option>
			<option value="7">Sábado</option>
		</select>
    </div>

    <div class="form-group">
    	<label>Hora:</label>
		<select class="form-control" name="id_hora">
			<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
			<?php
			// buscar xxx
			$sql = "SELECT * FROM hora WHERE Status = 1 ORDER BY Hora ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_horaX = $row['id_hora'];
					$HoraX = $row['Hora'];
					echo '<option value="'.$id_horaX.'">'.$HoraX.'</option>';
			    }
			} else {
				// não tem
			}
			?>
			<option value="">Limpar filtro</option>
		</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>

<!-- <li><label>Total:</label> <?php echo $Soma;?></li> -->

<?php
// buscar xxx
$sql = "SELECT * FROM hora WHERE Status = 1
$FiltroHora
ORDER BY Ordem ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Hora</th>';
	echo '<th>Terapeuta</th>';
	echo '<th>Ação terapeuta</th>';
	echo '<th>Paciente</th>';
	echo '<th>Ação paciente</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_hora = $row['id_hora'];
		$Hora = $row['Hora'];
		$id_periodo = $row['Periodo'];

		// buscar xxx
		$sqlA = "SELECT profissional.*
		FROM categoria_profissional
		INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional
		WHERE profissional.Status = 1 AND categoria_profissional.id_periodo = '$id_periodo' AND categoria_profissional.id_categoria = '$id_categoria' AND categoria_profissional.id_unidade = '$id_unidade' ORDER BY profissional.NomeCompleto ASC";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_profissional = $rowA['id_profissional'];
				$NomeProfissional = $rowA['NomeCompleto'];

				// buscar xxx
				$sqlB = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_profissional = '$id_profissional' ";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$id_paciente = $rowB['id_paciente'];

						// buscar xxx
						$sqlC = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
						$resultC = $conn->query($sqlC);
						if ($resultC->num_rows > 0) {
						    while($rowC = $resultC->fetch_assoc()) {
								// tem
								$NomePaciente = $rowC['NomeCompleto'];
						    }
						} else {
							// não tem
							$NomePaciente = NULL;
						}

				    }
				} else {
					// não tem
					$NomePaciente = NULL;
					$id_paciente = NULL;
				}

				echo '<tr>';
				echo '<td>'.$Hora.'</td>';
				echo '<td><a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link" target="blank">'.$NomeProfissional.'</a></td>';
				echo '<td><a href="../agenda/agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default" target="blank">Agenda base</a></td>';
				echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomePaciente.'</a></td>';
				if (!empty($id_paciente)) {
					echo '<td><a href="../agenda/agenda-base-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default" target="blank">Agenda base</a></td>';
				} else {
					echo '<td></td>';
				}
				
				echo '</tr>';
		    }
		} else {
			// não tem
		}
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>