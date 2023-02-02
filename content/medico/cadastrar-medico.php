<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
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

	        <h3>Cadastro do médico</h3>
	        <form action="cadastrar-medico-2.php" method="post" class="form-horizontal">
	            <div class="row">
	            	<div class="col-lg-6">
		            	<div class="form-group">
							<label class="control-label col-lg-3">Nome:</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="NomeMedico" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">Registro CRM:</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="Crm">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">E-mail:</label>
							<div class="col-lg-9">
								<input type="email" class="form-control" name="EmailMedico">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">Celular:</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="Celular">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">Telefone:</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="Telefone">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3">Observação:</label>
							<div class="col-lg-9">
								<textarea rows="5" class="form-control" name="Anotacao"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3"></label>
							<div class="col-lg-9">
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</div>
					</div>
	            </div>
	        </form>

	        <?php
	        if (empty($_SESSION['ErroMedicoExistente'])) {

	        } else {
	        	?>
	        	<div class="alert alert-info col-lg-6">
	        		<a href="cancelar-mensagem.php?Origem=cadastrar-medico.php" style="float: right;">&#x2715;</a>
	        		<b>Erro:</b> o médico se encontra cadastrado no sistema.
	        	</div>
	        	<?php
	        }
			?>
	     </div>
	</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
