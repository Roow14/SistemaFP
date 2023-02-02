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

// input
if (!empty($_POST['PesquisaBairro'])) {
	$PesquisaBairro = $_POST['PesquisaBairro'];
	$FiltroBairro = 'AND endereco_profissional.Bairro LIKE "%'.$PesquisaBairro.'%"';
} else {
	$FiltroBairro = NULL;
	$PesquisaBairro = NULL;
}

if (!empty($_POST['PesquisaCidade'])) {
	$PesquisaCidade = $_POST['PesquisaCidade'];
	$FiltroCidade = 'AND endereco_profissional.Cidade LIKE "%'.$PesquisaCidade.'%"';
} else {
	$FiltroCidade = NULL;
	$PesquisaCidade = NULL;
}

if (!empty($_POST['id_categoria'])) {
	$id_categoria = $_POST['id_categoria'];
	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		$NomeCategoria = NULL;
	}
	$FiltroCategoria = 'AND categoria_profissional.id_categoria = '. $id_categoria;
} else {
	$id_categoria = NULL;
	$FiltroCategoria = NULL;
	$NomeCategoria = 'Selecionar';
}

if (!empty($_POST['id_unidade'])) {
	$id_unidade = $_POST['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		$NomeUnidade = NULL;
	}
	$FiltroUnidade = 'AND categoria_profissional.id_unidade = '. $id_unidade;
} else {
	$id_unidade = NULL;
	$FiltroUnidade = NULL;
	$NomeUnidade = 'Selecionar';
}

if (!empty($_POST['id_periodo'])) {
	$id_periodo = $_POST['id_periodo'];
	// buscar xxx
	$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomePeriodo = $row['NomePeriodo'];
	    }
	} else {
		$NomePeriodo = NULL;
	}
	$FiltroPeriodo = 'AND categoria_profissional.id_periodo = '. $id_periodo;
} else {
	$id_periodo = NULL;
	$FiltroPeriodo = NULL;
	$NomePeriodo = 'Selecionar';
}

// filtro
if (!empty($_POST['StatusProfissional'])) {
	$StatusProfissional = $_POST['StatusProfissional'];
	if ($StatusProfissional == 1) {
		$NomeStatusProfissional = 'Ativo';
		$FiltroStatus = 'WHERE profissional.Status = '. $StatusProfissional;
	} elseif ($StatusProfissional == 3) {
		$NomeStatusProfissional = 'Ativos e inativos';
		$FiltroStatus = 'WHERE (profissional.Status = 1 OR profissional.Status = 2)';
	} else {
		$NomeStatusProfissional = 'Inativo';
		$FiltroStatus = 'WHERE profissional.Status = '. $StatusProfissional;
	}
} else {
	$StatusProfissional = 1;
	$FiltroStatus = 'WHERE profissional.Status = 1';
	$NomeStatusProfissional = 'Ativo';	
}

$sql = "SELECT COUNT(profissional.id_profissional) AS Soma FROM categoria_profissional
INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional
$FiltroStatus $FiltroCategoria $FiltroUnidade $FiltroPeriodo
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = NULL;
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
	<li class="active"><a href="terapeutas-funcao.php">Terapeutas/função</a></li>
	<li class="inactive"><a href="terapeutas-disponiveis.php">Terapeutas disponíveis</a></li>
	<li class="inactive"><a href="terapeutas-login.php">Terapeutas c/login</a></li>
</ul>

<div class="janela">
<h3>Terapeutas por região</h3>

<form action="" method="post" class="form-inline">

	<div class="form-group">
    	<label>Filtrar por função:</label>
        <select name="id_categoria" class="form-control">
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
			<option value="">Limpar filtro</option>
		</select>
    </div>

    <div class="form-group">
    	<label>Unidade:</label>
        <select name="id_unidade" class="form-control">
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
			<option value="">Limpar filtro</option>
		</select>
    </div>

    <div class="form-group">
    	<label>Período:</label>
        <select name="id_periodo" class="form-control">
			<option value="<?php echo $id_periodo;?>"><?php echo $NomePeriodo;?></option>
			<?php
			$sqlA = "SELECT * FROM periodo ORDER BY NomePeriodo ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_periodoX = $rowA['id_periodo'];
					$NomePeriodoX = $rowA['NomePeriodo'];
					echo '<option value="'.$id_periodoX.'">'.$NomePeriodoX.'</option>';
			    }
			} else {
				// não tem
				$NomePeriodoX = NULL;
			}
			?>
			<option value="">Limpar filtro</option>
		</select>
    </div>


    <div class="form-group">
    	<label>Status:</label>
		<select name="StatusProfissional" class="form-control">
			<option value="<?php echo $StatusProfissional;?>"><?php echo $NomeStatusProfissional;?></option>
			<option value="1">Ativo</option>
			<option value="2">Inativo</option>
			<option value="3">Todos</option>
		</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>

<li><label>Total:</label> <?php echo $Soma;?></li>
	
<?php
// buscar xxx
$sql = "SELECT categoria_profissional.*, profissional.NomeCompleto FROM categoria_profissional
INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional
$FiltroStatus $FiltroCategoria $FiltroUnidade $FiltroPeriodo
ORDER BY profissional.NomeCompleto ASC
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Função</th>';
	echo '<th>Unidade</th>';
	echo '<th>Período</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$NomeCompleto = $row['NomeCompleto'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$id_periodo = $row['id_periodo'];

		// buscar xxx
		$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCategoria = $rowA['NomeCategoria'];
		    }
		} else {
			// não tem
			$NomeCategoria = NULL;
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
			$NomeUnidade = NULL;
		}
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			// não tem
			$NomePeriodo = NULL;
		}

		echo '<tr>';
		echo '<td><a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeCategoria.'</td>';
		echo '<td>'.$NomeUnidade.'</td>';
		echo '<td>'.$NomePeriodo.'</td>';
		echo '</tr>';
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