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

// conexão com banco
include '../conexao/conexao.php';

// limpar filtro por nome
if (empty($_GET['Limpar'])) {
} else {
	unset($_SESSION['id_hora']);
}

// filtrar por dia da semana
if (isset($_POST['DiaSemana'])) {
	$DiaSemana = $_POST['DiaSemana'];
	$_SESSION['DiaSemana'] = $DiaSemana;
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
		$NomeDiaSemana = NULL;
	}
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = '.$DiaSemana;
} elseif (isset($_SESSION['DiaSemana'])) {
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
	} elseif ($DiaSemana == 7) {
		$NomeDiaSemana = 'Sábado';
	}  else {
		$NomeDiaSemana = NULL;
	}
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = '.$DiaSemana;
} else {
	$DiaSemana = 2;
	$_SESSION['DiaSemana'] = 2;
	$NomeDiaSemana = 'Segunda';
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = 2';
}

// filtrar por hora
if (isset($_POST['id_hora'])) {
	if (empty($_POST['id_hora'])) {
		$id_hora = NULL;
		$Hora = 'Todos';
		$FiltroHora = NULL;
	} else {
		$id_hora = $_POST['id_hora'];
		$_SESSION['id_hora'] = $id_hora;
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$Hora = $row['Hora'];
				$FiltroHora = 'AND agenda_paciente_base.id_hora ='.$id_hora;
		    }
		} else {
			// não tem
		}
	}
		
} elseif (isset($_SESSION['id_hora'])) {
	$id_hora = $_SESSION['id_hora'];
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
			$FiltroHora = 'AND agenda_paciente_base.id_hora ='.$id_hora;
	    }
	} else {
		// não tem
	}
} else {
	$id_hora = NULL;
	$Hora = 'Todos';
	$FiltroHora = NULL;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda base</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="active"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela col-sm-12">

<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>

<div class="row">
<div class="col-sm-12">
	<?php
	// pacientes ativos
	$sql = "SELECT COUNT(id_paciente) AS PacientesAtivos FROM paciente WHERE Status = 1 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$PacientesAtivos = $row['PacientesAtivos'];
			echo '<li><label>Pacientes ativos:</label> '.$PacientesAtivos.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Pacientes ativos:</label> 0<li>';
	}

	// pacientes ativos e com agenda
	$sql = "SELECT COUNT(DISTINCT id_paciente) AS PacientesAtivos FROM agenda_paciente_base WHERE Status = 1 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$PacientesAtivos = $row['PacientesAtivos'];
			echo '<li><label>Pacientes ativos e com agenda:</label> '.$PacientesAtivos.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Pacientes ativos e <b>sem</b> agenda:</label> 0<li>';
	}

	// pacientes inativos
	$sql = "SELECT COUNT(id_paciente) AS PacientesInativos FROM paciente WHERE Status = 2 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$PacientesInativos = $row['PacientesInativos'];
			echo '<li><label>Pacientes inativos:</label> '.$PacientesInativos.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Pacientes inativos:</label> 0<li>';
	}


	// terapeutas ativos
	$sql = "SELECT COUNT(id_profissional) AS TerapeutasAtivos FROM profissional WHERE Status = 1 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$TerapeutasAtivos = $row['TerapeutasAtivos'];
			echo '<li><label>Terapeutas ativos:</label> '.$TerapeutasAtivos.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Terapeutas ativos:</label> 0<li>';
	}

	// terapeutas ativos e com agenda
	$sql = "SELECT COUNT(DISTINCT id_profissional) AS TerapeutasAtivosX FROM agenda_paciente_base WHERE Status = 1 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$TerapeutasAtivosX = $row['TerapeutasAtivosX'];
			echo '<li><label>Terapeutas ativos e <b>com</b> agenda:</label> '.$TerapeutasAtivosX.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Terapeutas ativos e <b>sem</b> agenda:</label> 0<li>';
	}

	// terapeutas inativos
	$sql = "SELECT COUNT(id_profissional) AS TerapeutasInativos FROM profissional WHERE Status = 2 ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// tem
		while($row = $result->fetch_assoc()) {
			$TerapeutasInativos = $row['TerapeutasInativos'];
			echo '<li><label>Terapeutas inativos:</label> '.$TerapeutasInativos.'<li>';
		}
	// não tem
	} else {
		echo '<li><label>Terapeutas inativos:</label> 0<li>';
	}

	// agenda do paciente sem terapeuta
	$sql = "SELECT paciente.NomeCompleto, agenda_paciente_base.id_paciente
	FROM agenda_paciente_base 
	INNER JOIN paciente ON agenda_paciente_base.id_paciente = paciente.id_paciente 
	WHERE agenda_paciente_base.id_profissional = NULL";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_paciente = $row['id_paciente'];
			echo '<li><label>Paciente com agenda e sem terapeuta:</label> '.$id_paciente.'<li>';
	    }
	} else {
		// não tem
		echo '<li><label>Paciente com agenda e sem terapeuta:</label> Nenhum<li>';
	}
	?>
	<p>Listar pacientes na agenda base e não tem terapeuta associado <a href="listar-pacientes-sem-terapeuta.php" class="btn btn-default">Avançar</a></p>
	<p>Listar terapeutas <a href="listar-terapeutas.php" class="btn btn-default">Avançar</a></p>
	<p>Listar terapeutas duplicados <a href="listar-terapeutas-duplicados.php" class="btn btn-default">Avançar</a></p>
	<p>Listar pacientes <a href="listar-pacientes.php" class="btn btn-default">Avançar</a></p>
	<p>Listar pacientes duplicados <a href="listar-pacientes-duplicados.php" class="btn btn-default">Avançar</a></p>
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