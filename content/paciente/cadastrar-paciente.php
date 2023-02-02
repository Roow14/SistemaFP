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

	        <h3>Cadastro de paciente</h3>
	        <div class="row">
		        <form action="cadastrar-paciente-2.php" method="post" class="form-horizontal">
		            <div class="col-lg-6">

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Nome Completo:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name="NomeCompleto" placeholder="Obrigatório" required>
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Nome social:</label>
		                    <div class="col-sm-9">
			                    <input type="text" class="form-control" name="NomeCurto" placeholder="Obrigatório" required>
			                </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Data nasc.:</label>
		                    <div class="col-sm-9">
		                   		<input type="date" class="form-control" name='DataNascimento'>
		                   	</div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">CPF:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name='Cpf' id="Cpf" placeholder="999.999.999-99">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-sm-3">RG:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name='Rg' id="Rg" placeholder="99.999.999-9">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-sm-3">Órgão emissor:</label>
		                    <div class="col-sm-9">
			                    <input type="text" class="form-control" name='OrgaoEmissor'>
			                </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Nome do pai:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name="Pai" >
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Nome da mãe:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name="Mae" >
		                    </div>
		                </div>


		            </div>

		            <div class="col-lg-6">

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Rua, Av.:</label>
		                    <div class="col-sm-9">
		                    	<input id="SearchEndereco" type="text" class="form-control" name="Endereco" contentEditable="true" value="">
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Nº:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name="Numero" contentEditable="true" value="">
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Compl.:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" name="Complemento" contentEditable="true" value="">
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Bairro:</label>
		                    <div class="col-sm-9">
		                    	<input id="SearchBairro" type="text" class="form-control" name="Bairro" contentEditable="true" value="">
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Cidade:</label>
		                    <div class="col-sm-9">
		                    	<input id="SearchCidade" type="text" class="form-control" name="Cidade" contentEditable="true" value="">
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">Estado (UF):</label>
		                    <div class="col-sm-9">
			                    <select class="form-control" name="Estado">
			                        <option value=''>Selecionar</option>
			                        <option value='AC'>Acre</option>
			                        <option value='AL'>Alagoas</option>
			                        <option value='AP'>Amapá</option>
			                        <option value='AM'>Amazonas</option>
			                        <option value='BA'>Bahia</option>
			                        <option value='CE'>Ceará</option>
			                        <option value='DF'>Distrito Federal</option>
			                        <option value='ES'>Espírito Santo</option>
			                        <option value='GO'>Goiás</option>
			                        <option value='MA'>Maranhão</option>
			                        <option value='MT'>Mato Grosso</option>
			                        <option value='MS'>Mato Grosso do Sul</option>
			                        <option value='MG'>Minas Gerais</option>
			                        <option value='PA'>Pará</option>
			                        <option value='PB'>Paraíba</option>
			                        <option value='PR'>Paraná</option>
			                        <option value='PE'>Pernambuco</option>
			                        <option value='PI'>Piauí</option>
			                        <option value='RJ'>Rio de Janeiro</option>
			                        <option value='RN'>Rio Grande do Norte</option>
			                        <option value='RS'>Rio Grande do Sul</option>
			                        <option value='RO'>Rondônia</option>
			                        <option value='RR'>Roraima</option>
			                        <option value='SC'>Santa Catarina</option>
			                        <option value='SE'>Sergipe</option>
			                        <option value='SP'>São Paulo</option>
			                        <option value='TO'>Tocantins</option>
			                    </select>
			                </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-sm-3">CEP:</label>
		                    <div class="col-sm-9">
		                    	<input type="text" class="form-control" id="Cep" name="Cep" contentEditable="true" placeholder="99999-999" value="">
		                    </div>
		                </div>
		                
		                <div class="form-group">
		                    <label class="control-label col-sm-3">Observação:</label>
		                    <div class="col-sm-9">
		                    	<textarea rows="1" class="form-control" style="width: 100%" name="PacienteObservacao" contentEditable="true"></textarea>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-sm-3"></label>
		                    <div class="col-sm-9">
		                    	<button type="submit" class="btn btn-success">Confirmar</button>
		                    </div>
		                </div>
		            </div>
		        </form>
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
