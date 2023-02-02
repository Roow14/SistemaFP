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
$id_escola = $_GET['id_escola'];
$id_paciente = $_SESSION['id_paciente'];
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

// buscar xxx
$sql = "SELECT * FROM escola WHERE id_escola = '$id_escola'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeEscola = $row['NomeEscola'];
		$Observacao = $row['Observacao'];
    }
} else {
	$Observacao = NULL;
}

// buscar xxx
$sql = "SELECT * FROM endereco_escola WHERE id_escola = '$id_escola'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Endereco = $row['Endereco'];
		$Numero = $row['Numero'];
		$Complemento = $row['Complemento'];
		$Cep = $row['Cep'];
		$Bairro = $row['Bairro'];
		$Cidade = $row['Cidade'];
		$Estado = $row['Estado'];
		
		if (empty($Complemento)) {
			$Endereco1 = $Endereco.', '.$Numero;
		} else {
			$Endereco1 = $Endereco.', '.$Numero.' - '.$Complemento;
		}

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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="paciente.php">Paciente</a></li>
	<li class="active"><a href="escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<div class="row">
        <div class="col-lg-6">
			<h3>Escola</h3>
			<label>Escola:</label> <?php echo $NomeEscola;?><br>
			<label>Endereço:</label> <?php echo $Endereco1;?><br>
			<label>CEP:</label> <?php echo $Cep;?><br>
			<label>Bairro:</label> <?php echo $Bairro;?><br>
			<label>Cidade/Estado:</label> <?php echo $Cidade;?> / <?php echo $Estado;?><br>
			<?php
			echo '<label>Telefone:</label> ';
			// buscar telefone
			$sql = "SELECT * FROM telefone_escola WHERE id_escola = '$id_escola' AND ClasseTel = 1";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_telefone_escola = $row['id_telefone_escola'];
					$NumeroTel = $row['NumeroTel'];
					$NotaTel = $row['NotaTel'];
					$Tipo = $row['Tipo'];
					if ($Tipo == 1) {
						$NomeTipo = 'Comercial';
					} else {
						$NomeTipo = 'Residencial';
					}
					echo $NumeroTel.' - '.$NomeTipo.' - '.$NotaTel.'<br>';
			    }
			} else {
				echo '<br>';
			}
			
			echo '<label>Celular:</label> ';
			// buscar celular
			$sql = "SELECT * FROM telefone_escola WHERE id_escola = '$id_escola' AND ClasseTel = 2";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_telefone_escola = $row['id_telefone_escola'];
					$NumeroTel = $row['NumeroTel'];
					$NotaTel = $row['NotaTel'];
					echo $NumeroTel.' - '.$NotaTel.'<br>';
			    }
			} else {
				echo '<br>';
			}
			echo '<label>E-mail:</label> ';
			// buscar e-mail
			$sql = "SELECT * FROM email_escola WHERE id_escola = '$id_escola' ";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_email_escola = $row['id_email_escola'];
					$EmailEscola = $row['EmailEscola'];
					$NotaEmail = $row['NotaEmail'];
					echo $EmailEscola.' - '.$NotaEmail.'<br>';
			    }
			} else {
				echo '<br>';
			}

			echo '<label>Observação:</label> '.$Observacao.'<br>';

			echo '<a href="escola-paciente.php" class="btn btn-default">Voltar</a>';

			// if (empty($_GET['Origem'])) {
			// 	echo '<a href="listar-escolas.php" class="btn btn-default">Fechar</a>';
			// } else {
			// 	$Origem = $_GET['Origem'];
			// 	echo '<a href="'.$Origem.'" class="btn btn-default">Voltar</a>';
			// }
			?>

			<a href="alterar-escola.php?id_escola=<?php echo $id_escola;?>" class="btn btn-default">Alterar</a>
			<?php
			if (empty($_SESSION['AtivarRemocaoEscola'])) {
				echo '<a href="ativar-remocao-escola.php?id_escola='.$id_escola.'" class="btn btn-default">Apagar</a>';
			} else {
			}
			?>
			<a href="cadastrar-telefone-email-escola.php?id_escola=<?php echo $id_escola;?>" class="btn btn-default">Cadastrar telefone e e-mail</a>

			<?php
			if (empty($_SESSION['AtivarRemocaoEscola'])) {
			} else {
				?>
				<div class="alert alert-danger" style="margin-top: 15px;">
					<b>Cuidado:</b> os dados da escola serão removidos completamente do sistema.<br>
					Deseja continuar?<br>
					<div style=" margin-top: 15px;">
						<a href="ativar-remocao-escola.php?id_escola=<?php echo $id_escola;?>" class="btn btn-default">Fechar</a>
						<a href="apagar-escola-2.php?id_escola=<?php echo $id_escola;?>" class="btn btn-danger">Apagar</a>
					</div>
				</div>
				<?php
			}
			?>
        </div>

        <!-- <div class="col-lg-6">
        	<h3>Aluno (paciente)</h3>
        	<?php
			// buscar xxx
			$sql = "SELECT * FROM escola_paciente WHERE id_escola = '$id_escola'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Paciente</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_paciente = $row['id_paciente'];
					echo '<tr>';
					// buscar xxx
					$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomeCompleto = $rowA['NomeCompleto'];
							
							echo '<td>';
							echo '<a href="paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a>';
							echo '</td>';
					    }
					} else {
					}
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
				echo 'Não encontramos nenhum paciente.';
			}
			?>
        </div> -->
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
