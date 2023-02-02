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
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

    
            
<div class="">
<div class="">
	<h3>Escolas</h3>

	<form action="associar-escola-paciente.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline" style="margin-bottom: 15px;">
		<label>Selecionar escola</label>
		<select class="form-control" name="id_escola">
			<option value="">Selecionar</option>
			<?php
			// buscar xxx
			$sql = "SELECT * FROM escola ORDER BY NomeEscola ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_escola = $row['id_escola'];
					$NomeEscola = $row['NomeEscola'];
					echo '<option value="'.$id_escola.'">'.$NomeEscola.'</option>';
			    }
			} else {
			}
			?>
		</select>
		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>
	<div>
		<a href="listar-escolas.php" class="btn btn-default">Cadastrar/listar escolas</a>
	</div>
	<br>

    <?php
	// buscar xxx
	$sql = "SELECT * FROM escola_paciente WHERE id_paciente = '$id_paciente'";
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

			$Origem = 'escola-paciente.php?id_paciente='.$id_paciente;

			echo '<label>Nome da escola:</label> '.$NomeEscola.'<br>';
			echo '<label>Endereço:</label> '.$Endereco1.'<br>';
			echo '<a href="escola.php?id_paciente='.$id_paciente.'&id_escola='.$id_escola.'&Origem='.$Origem.'" class="btn btn-default">Ver</a>';
			echo '<a href="remover-escola-do-paciente-2.php?id_escola_paciente='.$id_escola_paciente.'&Origem='.$Origem.'" class="btn btn-default">Remover escola</a><br><br>';
	    }
	} else {
		echo 'Não encontramos nenhuma escola associada ao paciente.';
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
</body>
</html>
