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
	.ajuste-dica {
		margin-top: 5px;
		margin-left: 15px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Paciente</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="index.php">Cadastrar paciente</a></li>
</ul>

<div class="janela">
	<div class="row">
		<form action="cadastrar-paciente-novo-2.php" method="post" class="form-horizontal">
	        <div class="col-sm-6">
	        	<h3>Dados do paciente</h3>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome Completo:</label>
	                <div class="col-sm-9">
	                	<input id="SearchNome" type="text" class="form-control" name="NomeCompleto" placeholder="Obrigatório" required>
	                	<div id='SugestaoNome' class="ajuste-dica" style='color: orange; cursor: pointer;'></div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Data nasc.:</label>
	                <div class="col-sm-9">
	               		<input type="date" class="form-control" name='DataNascimento' required>
	               	</div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">CPF:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name='Cpf' id="Cpf" placeholder="">
	                </div>
	            </div>
	            <!-- <div class="form-group">
	                <label class="control-label col-sm-3">RG:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name='Rg' id="Rg" placeholder="">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Órgão emissor:</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name='OrgaoEmissor'>
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome do pai:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Pai" placeholder="Obrigatório" required>
	                </div>
	            </div>
	             <div class="form-group">
	                <label class="control-label col-sm-3">Nome da mãe:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Mae" placeholder="Obrigatório" required>
	                </div>
	            </div>
	            <!-- <div class="form-group">
	                <label class="control-label col-sm-3">Observação:</label>
	                <div class="col-sm-9">
	                	<textarea rows="3" class="form-control" name="PacienteObservacao"></textarea>
	                </div>
	            </div> -->
	        </div>

	        <div class="col-sm-6">
	            <h3>Convênio</h3>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome:</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="id_convenio" required>
	                		<option value="">Selecionar</option>
	                		<?php
							// buscar xxx
							$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1 ORDER BY NomeConvenio ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_convenioX = $row['id_convenio'];
									$NomeConvenioX = $row['NomeConvenio'];
									echo '<option value="'.$id_convenioX.'">'.$NomeConvenioX.'</option>';
							    }
							} else {
								// não tem
							}
							?>
	                	</select>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nº da carteirinha:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="NumeroConvenio">
	                </div>
	            </div>
	            <!-- <div class="form-group">
	                <label class="control-label col-sm-3">Observação:</label>
	                <div class="col-sm-9">
	                	<textarea rows="3" class="form-control" name="NotaConvenio"></textarea>
	                </div>
	            </div> -->

	            
	        </div>

	        <div class="col-sm-6">
	        	<h3>Complemento</h3>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Processo:</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="id_processo" required>
	                		<option value="">Selecionar</option>
	                		<?php
							// buscar xxx
							$sql = "SELECT * FROM processo WHERE Status = 1 ORDER BY Processo ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_processoX = $row['id_processo'];
									$ProcessoX = $row['Processo'];
									echo '<option value="'.$id_processoX.'">'.$ProcessoX.'</option>';
							    }
							} else {
								// não tem
							}
							?>
	                	</select>
	                </div>
	            </div>
	        	
	        	<div class="form-group">
	                <label class="control-label col-sm-3"></label>
	                <div class="col-sm-9">
	                	<button type="submit" class="btn btn-success">Confirmar e avançar</button>
	                </div>
	            </div>
	        </div>
	    </form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="telefone" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-telefone-paciente-novo-2.php" method="post" class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar telefone</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
		                <label class="control-label col-sm-3">Número:</label>
		                <div class="col-sm-9">
		                	<input type="text" class="form-control" name="NumeroTel" required>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="control-label col-sm-3">Classe:</label>
		                <div class="col-sm-9">
		                	<select class="form-control" name="ClasseTel" required>
								<option value="">Selecionar</option>
								<option value="1">Telefone</option>
								<option value="2">Celular</option>
							</select>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="control-label col-sm-3">Observação:</label>
		                <div class="col-sm-9">
		                	<textarea rows="3" class="form-control" name="NotaTel" placeholder="Pai, mãe, avó" required></textarea>
		                </div>
		            </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="email" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Dicas</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <p>aaa</p>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<!-- pesquisa dinâmica -->
<?php include 'pesquisa-dinamica.php';?>

</body>
</html>