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

// filtrar por unidade
if (!empty($_SESSION['id_unidade'])) {
	$id_unidade = $_SESSION['id_unidade'];

	if ($id_unidade == 5) {
		// conexão com banco
		include '../conexao/conexao-coral.php';
	} else {
		// conexão com banco
		include '../conexao/conexao.php';
	}

	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
	}
} else {
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
}

// filtrar por hora
if (!empty($_SESSION['Data'])) {
	$Data = $_SESSION['Data'];
} else {
	$Data = 'Todos';
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
	    }
	} else {
		// não tem
	}
} else {
	$id_hora = NULL;
	$Hora = 'Todos';
}

// filtrar por dia da semana
if (!empty($_SESSION['DiaSemana'])) {
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
	}
} else {
	$NomeDiaSemana = 'Selecionar';
	$DiaSemana = NULL;
}

// filtrar por categoria
if (!empty($_SESSION['id_categoria'])) {
	$id_categoria = $_SESSION['id_categoria'];

	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
	}
} else {
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
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
<h3>Terapeutas disponíveis</h3>
<h3>Agenda base</h3>
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

<h3>Agenda do dia</h3>
<form action="terapeutas-disponiveis-agenda-2.php" method="post" class="form-inline">

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
    	<label>Data:</label>
    	<input type="date" class="form-control" name="Data" value="<?php echo $Data;?>" required>
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>