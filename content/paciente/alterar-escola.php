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
	$Endereco = NULL;
	$Numero = NULL;
	$Complemento = NULL;
	$NomeEstado = NULL;

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
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="active"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<div class="row">
		<div class="col-lg-6">
			<form action="alterar-escola-2.php?id_escola=<?php echo $id_escola;?>" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-lg-3">Escola:</label>
					<div class="col-lg-9">
						<input type="text" class="form-control" placeholder="Nome" name="NomeEscola" value="<?php echo $NomeEscola;?>" required>
					</div>
				</div>

				<div class="form-group">
			        <label class="control-label col-lg-3">Rua, Av.:</label>
			        <div class="col-lg-9">
			        	<input type="text" class="form-control" name="Endereco" contentEditable="true" value="<?php echo $Endereco;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Nº:</label>
			        <div class="col-lg-9">
			        	<input type="text" class="form-control" name="Numero" contentEditable="true" value="<?php echo $Numero;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Compl.:</label>
			        <div class="col-lg-9">
			        	<input type="text" class="form-control" name="Complemento" contentEditable="true" value="<?php echo $Complemento;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Bairro:</label>
			        <div class="col-lg-9">
			        	<input id="SearchBairro" type="text" class="form-control" name="Bairro" contentEditable="true" value="<?php echo $Bairro;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Cidade:</label>
			        <div class="col-lg-9">
			        	<input id="SearchCidade" type="text" class="form-control" name="Cidade" contentEditable="true" value="<?php echo $Cidade;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Estado (UF):</label>
			        <div class="col-lg-9">
			            <select class="form-control" name="Estado">
			                <option value='<?php echo $Estado;?>'><?php echo $NomeEstado;?></option>
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
			        	<input type="text" class="form-control" id="Cep" name="Cep" contentEditable="true" placeholder="99999-999" value="<?php echo $Cep;?>">
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3">Observação:</label>
			        <div class="col-lg-9">
			        	<textarea rows="5" class="form-control" name="Observacao"><?php echo $Observacao;?></textarea>
			        </div>
			    </div>

			    <div class="form-group">
			        <label class="control-label col-lg-3"></label>
			        <div class="col-lg-9">
			        	<a href="escola.php?id_escola=<?php echo $id_escola;?>" class="btn btn-default">Fechar alteração</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
			        </div>
			    </div>
			</form>
		</div>
	</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
