<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

	<div id="content">
	    <?php include '../menu-superior/menu-superior.php';?>

	    <div id="conteudo">

<h2>Terapeutas</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="active"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
	<li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">

    <h3>Cadastro de profissional</h3>
    <div class="row">
        <form action="cadastrar-profissional-2.php" method="post" class="form-horizontal">
            <div class="col-lg-6">

                <div class="form-group">
                    <label class="control-label col-sm-3">Nome Completo:</label>
                    <div class="col-sm-9">
                    	<input id="SearchNomeCompleto" type="text" class="form-control" name="NomeCompleto" placeholder="Obrigatório" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Nome social:</label>
                    <div class="col-sm-9">
	                    <input id="SearchNomeSocial" type="text" class="form-control" required name="NomeCurto" contentEditable="true" placeholder="Obrigatório" value="">
	                </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Funcão:</label>
                    <div class="col-sm-9">
	                    <select class="form-control" name="id_funcao">
	                    	<option value="">Selecionar</option>
	                    	<?php
	                    	// buscar função
							$sql = "SELECT * FROM funcao ORDER BY NomeFuncao ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_funcao = $row['id_funcao'];
									$Funcao = $row['Funcao'];
									$NomeFuncao = $row['NomeFuncao'];
									echo '<option value="'.$id_funcao.'">'.$NomeFuncao.'</option>';
							    }
							} else {
							}
	                    	?>
	                    </select>
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
                    <label class="control-label col-sm-3">Registro:</label>
                    <div class="col-sm-9">
                    	<input type="text" class="form-control" name="Registro" placeholder="CRP ou CREFITO">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Registro CRPJ:</label>
                    <div class="col-sm-9">
                    	<input type="text" class="form-control" name="Crpj" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Instituição de ensino:</label>
                    <div class="col-sm-9">
                    	<textarea rows="3" class="form-control" style="width: 100%" name="Graduacao" contentEditable="true"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
            	<div class="form-group">
                    <label class="control-label col-sm-3">E-mail:</label>
                    <div class="col-sm-9">
	                    <input type="mail" class="form-control" name='Email'>
	                </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Telefone:</label>
                    <div class="col-sm-9">
                    	<input type="text" class="form-control" name="Telefone">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Celular:</label>
                    <div class="col-sm-9">
                    	<input type="text" class="form-control" name="Celular">
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
	                    	<option value="">Selecionar</option>
	                        <?php
							// buscar xxx
							$sql = "SELECT * FROM estado ORDER BY NomeEstado ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$Estado = $row['Estado'];
									$NomeEstado = $row['NomeEstado'];
									echo '<option value="'.$Estado.'">'.$NomeEstado.'</option>';
							    }
							} else {
							}
							?>
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
                    	<textarea rows="3" class="form-control" style="width: 100%" name="ProfissionalObservacao" contentEditable="true"></textarea>
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
