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
$id_paciente = $_SESSION['id_paciente'];
$id_escola_paciente = $_GET['id_escola_paciente'];

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
	// não tem
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
		/*margin-top: -30px;*/
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="paciente.php">Paciente</a></li>
	<li class="active"><a href="escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../convenio/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
	<h3>Escola</h3>

    <?php
	// buscar xxx
	$sql = "SELECT * FROM escola_paciente WHERE id_escola_paciente = '$id_escola_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_escola_paciente = $row['id_escola_paciente'];
			$id_escola = $row['id_escola'];

			// buscar xxx
			$sqlA = "SELECT * FROM escola WHERE id_escola = '$id_escola'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeEscola = $rowA['NomeEscola'];
			    }
			} else {
			}

			// buscar xxx
			$sqlA = "SELECT * FROM endereco_escola WHERE id_escola = '$id_escola'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$Endereco = $rowA['Endereco'];
					$Numero = $rowA['Numero'];
					$Complemento = $rowA['Complemento'];
					$Cep = $rowA['Cep'];
					$Bairro = $rowA['Bairro'];
					$Cidade = $rowA['Cidade'];
					$Estado = $rowA['Estado'];
					
					$Endereco1 = $Endereco.', '.$Numero.' - '.$Complemento.' - '.$Cep.' - '.$Bairro.' - '.$Cidade.' - '.$Estado;

					// buscar xxx
					$sqlB = "SELECT * FROM estado WHERE Estado = '$Estado'";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
					    while($rowB = $resultB->fetch_assoc()) {
							$NomeEstado = $rowB['NomeEstado'];
					    }
					} else {
						$NomeEstado = 'Selecionar';
					}
			    }
			} else {
				$Endereco1 = NULL;
				$Cep = NULL;
				$Bairro = NULL;
				$Cidade = NULL;
				$Estado = NULL;
			}

			echo 'A escola <b>'.$NomeEscola.'</b> será removida do paciente <b>'.$NomeCompleto.'</b>.';
			echo '<br>';
			echo '<br>';
			echo 'Deseja continuar?';
			echo '<br>';
			echo '<br>';
			echo '<a href="escola-paciente.php" class="btn btn-default" style="margin-right: 5px">Voltar</a>';
			echo '<a href="remover-escola-do-paciente-2.php?id_escola_paciente='.$id_escola_paciente.'" class="btn btn-danger">Remover associação</a><br><br>';
	    }
	} else {
		echo 'Não encontramos nenhuma escola associada ao paciente.';
	}
	?>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
