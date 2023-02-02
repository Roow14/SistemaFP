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
if (!empty($_POST['PesquisaTerapeuta'])) {
	$PesquisaTerapeuta = $_POST['PesquisaTerapeuta'];
	$FiltroTerapeuta = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaTerapeuta.'%"';
} else {
	$FiltroTerapeuta = NULL;
	$PesquisaTerapeuta = NULL;
}

if (!empty($_POST['id_unidade'])) {
	$id_unidade = $_POST['id_unidade'];
	if ($id_unidade == 5) {
		include '../conexao/conexao-coral.php';
	}
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


// filtro login
if (!empty($_POST['StatusLogin'])) {
	$StatusLogin = $_POST['StatusLogin'];
	if ($StatusLogin == 1) {
		$NomeStatusLogin = 'Tem acesso';
		$FiltroLogin = 'AND profissional.Usuario IS NOT NULL';
	} else {
		$NomeStatusLogin = 'Não tem acesso';
		$FiltroLogin = 'AND profissional.Usuario IS NULL';
	}
} else {
	$StatusLogin = NULL;
	$FiltroLogin = NULL;
	$NomeStatusLogin = 'Selecionar';	
}

$sql = "SELECT COUNT(DISTINCT profissional.id_profissional) AS Soma FROM profissional
$FiltroStatus $FiltroTerapeuta $FiltroLogin AND profissional.Nivel != 3
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
// $Soma = NULL;
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
	<li class="inactive"><a href="terapeutas-disponiveis.php">Terapeutas disponíveis</a></li>
	<li class="active"><a href="terapeutas-login.php">Terapeutas c/login</a></li>
</ul>

<div class="janela">
<h3>Terapeutas com login no sistema</h3>

<form action="" method="post" class="form-inline">

	<div class="form-group">
    	<label>Filtrar por terapeuta:</label>
        <input type="text" class="form-control" name="PesquisaTerapeuta" value="<?php echo $PesquisaTerapeuta;?>">
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
    	<label>Status:</label>
		<select name="StatusProfissional" class="form-control">
			<option value="<?php echo $StatusProfissional;?>"><?php echo $NomeStatusProfissional;?></option>
			<option value="1">Ativo</option>
			<option value="2">Inativo</option>
			<option value="3">Todos</option>
		</select>
    </div>

    <div class="form-group">
    	<label>Login:</label>
		<select name="StatusLogin" class="form-control">
			<option value="<?php echo $StatusLogin;?>"><?php echo $NomeStatusLogin;?></option>
			<option value="1">Tem acesso</option>
			<option value="2">Não tem acesso</option>
			<option value="">Todos</option>
		</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>

<li><label>Total:</label> <?php echo $Soma;?></li>
	
<?php
// buscar xxx
// $sql = "SELECT DISTINCT profissional.*, categoria_profissional.id_unidade FROM profissional INNER JOIN categoria_profissional ON profissional.id_profissional = categoria_profissional.id_profissional $FiltroStatus $FiltroTerapeuta $FiltroUnidade ORDER BY profissional.NomeCompleto ASC";

$sql = "SELECT DISTINCT profissional.* FROM profissional
$FiltroStatus $FiltroTerapeuta $FiltroLogin AND profissional.Nivel != 3
ORDER BY profissional.NomeCompleto ASC
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Login</th>';
	echo '<th>Unidade</th>';
	echo '<th>Status</th>';
	echo '<th>Tipo</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$NomeCompleto = $row['NomeCompleto'];
		// $id_unidade = $row['id_unidade'];
		$Usuario = $row['Usuario'];
		$Status = $row['Status'];
		$Nivel = $row['Nivel'];

		if (!empty($Usuario)) {
			if ($Nivel == 1) {
				$NomeNivel = 'Usuário';
			} elseif ($Nivel == 2) {
				$NomeNivel = 'Administrador';
			} else {
				$NomeNivel = NULL;
			}
		} else {
			$NomeNivel = NULL;
		}

		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}

		// buscar xxx
		$sqlA = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' $FiltroUnidade";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_unidade = $rowA['id_unidade'];
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
		    }
		} else {
			// não tem
			$id_unidade = NULL;
		}

				


		echo '<tr>';
		echo '<td><a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link" target="blank">'.$id_profissional.'</a></td>';
		echo '<td><a href="../profissional/profissional.php?id_profissional='.$id_profissional.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$Usuario.'</td>';
		echo '<td>'.$NomeUnidade.'</td>';
		echo '<td>'.$NomeStatus.'</td>';
		echo '<td>'.$NomeNivel.'</td>';
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