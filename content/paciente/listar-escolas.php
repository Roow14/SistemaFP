<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

    
            
<div class="">
<div class="">
	
    <?php
	if (empty($_SESSION['AtivarCadastroEscola'])) {
		?>
		<h3>Escolas</h3>
		<a href="ativar-cadastro-escola.php" class="btn btn-default">Cadastrar escola</a><br><br>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM escola ORDER BY NomeEscola ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Escola</th>';
			echo '<th>Endereço</th>';
			echo '<th>Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_escola = $row['id_escola'];
				$NomeEscola = $row['NomeEscola'];

				echo '<tr>';
				echo '<td>'.$NomeEscola.'</td>';

				echo '<td>';
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
						
						echo $Endereco1;
					
				    }
				} else {
					$Endereco1 = NULL;
					$Cep = NULL;
					$Bairro = NULL;
					$Cidade = NULL;
					$Estado = NULL;
				}
				echo '</td>';

			    echo '<td>';
			    echo '<a href="escola.php?id_escola='.$id_escola.'" class="btn btn-default" style="margin-right: 5px;">Ver</a>';
				echo '</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
			echo 'Não encontramos nenhuma escola cadastrada no sistema.';
		}
	} else {
	}
	?>
</div>
<div class="col-lg-6">
	<?php
	if (empty($_SESSION['AtivarCadastroEscola'])) {
	} else {
		?>
		<h3>Cadastrar escola</h3>
		<form action="cadastrar-escola-2.php" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-lg-3">Escola:</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" placeholder="Nome" name="NomeEscola" required>
				</div>
			</div>

			<div class="form-group">
		        <label class="control-label col-lg-3">Rua, Av.:</label>
		        <div class="col-lg-9">
		        	<input type="text" class="form-control" name="Endereco" contentEditable="true">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Nº:</label>
		        <div class="col-lg-9">
		        	<input type="text" class="form-control" name="Numero" contentEditable="true">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Compl.:</label>
		        <div class="col-lg-9">
		        	<input type="text" class="form-control" name="Complemento" contentEditable="true">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Bairro:</label>
		        <div class="col-lg-9">
		        	<input id="SearchBairro" type="text" class="form-control" name="Bairro" contentEditable="true">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Cidade:</label>
		        <div class="col-lg-9">
		        	<input id="SearchCidade" type="text" class="form-control" name="Cidade" contentEditable="true">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Estado (UF):</label>
		        <div class="col-lg-9">
		            <select class="form-control" name="Estado">
		                <option value=''>Selecionar</option>
		                <?php
						// buscar xxx
						$sql = "SELECT * FROM estado ORDER BY NomeEstado ASC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								$Estado = $row['Estado'];
								$NomeEstado = $row['NomeEstado'];
								echo '<option value='.$Estado.'>'.$NomeEstado.'</option>';
						    }
						} else {
						}
						?>
		            </select>
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">CEP:</label>
		        <div class="col-lg-9">
		        	<input type="text" class="form-control" id="Cep" name="Cep" contentEditable="true" placeholder="99999-999">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3">Observação:</label>
		        <div class="col-lg-9">
		        	<textarea rows="5" class="form-control" name="Observacao"></textarea>
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="control-label col-lg-3"></label>
		        <div class="col-lg-9">
		        	<a href="ativar-cadastro-escola.php" class="btn btn-default">Fechar</a>
					<button type="submit" class="btn btn-success">Confirmar</button>
		        </div>
		    </div>
		</form>
		<?php
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
