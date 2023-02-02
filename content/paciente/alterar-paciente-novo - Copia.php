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
$id_paciente = $_SESSION['id_paciente'];
include 'dados-paciente.php';

// buscar xxx
$sql = "SELECT * FROM paciente_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$PacienteObservacao = $row['PacienteObservacao'];
    }
} else {
	$PacienteObservacao = NULL;
}

// buscar xxx
$sql = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$PacientePreferencia = $row['PacientePreferencia'];
    }
} else {
	$PacientePreferencia = NULL;
}

include 'verificar-paciente.php';
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="index.php">Lista</a></li>
	<li class="active"><a href="paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../convenio/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
	<li class="inactive"><a href="">Agenda</a></li>
</ul>

<div class="janela">
	<div class="row">
		<form action="alterar-paciente-novo-2.php" method="post" class="form-horizontal">
	        <div class="col-sm-6">
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome Completo:</label>
	                <div class="col-sm-9">
	                	<input type="text" id="SearchNome" class="form-control" name="NomeCompleto" value="<?php echo $NomeCompleto;?>" placeholder="Obrigatório" required>
	                	<div id='SugestaoNome' class="ajuste-dica" style='color: orange; cursor: pointer;'></div>
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome Social:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="NomeCurto" value="<?php echo $NomeCurto;?>" placeholder="Obrigatório" required>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Data nasc.:</label>
	                <div class="col-sm-9">
	               		<input type="date" class="form-control" value="<?php echo $DataNascimento;?>" name='DataNascimento'>
	               	</div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">CPF:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name='Cpf' id="Cpf" value="<?php echo $Cpf;?>" placeholder="">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">RG:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name='Rg' id="Rg" value="<?php echo $Rg;?>" placeholder="">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Órgão emissor:</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name='OrgaoEmissor' value="<?php echo $OrgaoEmissor;?>">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Nome do pai:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Pai" placeholder="Obrigatório" value="<?php echo $Pai;?>" required>
	                </div>
	            </div>
	             <div class="form-group">
	                <label class="control-label col-sm-3">Nome da mãe:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Mae" placeholder="Obrigatório" value="<?php echo $Mae;?>" required>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-sm-3">Observação:</label>
	                <div class="col-sm-9">
	                	<textarea id="editor" class="form-control" name="PacienteObservacao"><?php echo $PacienteObservacao;?></textarea>
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Uso de imagem:</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="UsoImagem">
	                		<option value="<?php echo $UsoImagem;?>"><?php echo $NomeUsoImagem;?></option>
	                		<option value="1">Sim</option>
	                		<option value="2">Não</option>
	                	</select>
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Período:</label>
	                <div class="col-sm-9">
	                	<select name="id_periodo" class="form-control">
		                	<?php
		                	echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
							// buscar xxx
							$sql = "SELECT * FROM periodo ORDER BY NomePeriodo ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_periodoX = $row['id_periodo'];
									$NomePeriodoX = $row['NomePeriodo'];
									echo '<option value="'.$id_periodoX.'">'.$NomePeriodoX.'</option>';	
							    }
							} else {
								// não tem
							}
							echo '<option value="">Limpar</option>';
							?>
						</select>
	                </div>
	            </div>

	             <div class="form-group">
	                <label class="control-label col-sm-3">Unidade:</label>
	                <div class="col-sm-9">
	                	<select name="id_unidade" class="form-control">
		                	<?php
		                	echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_unidadeX = $row['id_unidade'];
									$NomeUnidadeX = $row['NomeUnidade'];
									echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';	
							    }
							} else {
								// não tem
							}
							echo '<option value="">Limpar</option>';
							?>
						</select>
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Preferência de horário:</label>
	                <div class="col-sm-9">
	                	<textarea id="editor2" class="form-control" name="PacientePreferencia"><?php echo $PacientePreferencia;?></textarea>
	                </div>
	            </div>

	        	<div class="form-group">
	                <label class="control-label col-sm-3">Endereço:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Endereco" value="<?php echo $Endereco;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Número:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Numero" value="<?php echo $Numero;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Complemento:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Complemento" value="<?php echo $Complemento;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">CEP:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Cep" value="<?php echo $Cep;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Bairro:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Bairro" value="<?php echo $Bairro;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Cidade:</label>
	                <div class="col-sm-9">
	                	<input type="text" class="form-control" name="Cidade" value="<?php echo $Cidade;?>">
	                </div>
	            </div>

	            <div class="form-group">
	                <label class="control-label col-sm-3">Estado:</label>
	                <div class="col-sm-9">
	                	<select name="Estado" class="form-control">
		                	<?php
		                	echo '<option value="'.$Estado.'">'.$NomeEstado.'</option>';
							// buscar xxx
							$sql = "SELECT * FROM estado ORDER BY NomeEstado ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$EstadoX = $row['Estado'];
									$NomeEstadoX = $row['NomeEstado'];
									echo '<option value="'.$EstadoX.'">'.$NomeEstadoX.'</option>';	
							    }
							} else {
								// não tem
							}
							echo '<option value="">Limpar</option>';
							?>
						</select>
	                </div>
	            </div>
	        </div>

	        <div class="col-sm-6">
	        	<div class="form-group">
	        		<label class="control-label col-sm-3">Tel./cel.:</label>
			        <div class="col-sm-9 ajustetel">
	                	<?php
						// buscar xxx
						$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							echo '<table class="table table-condensed">';
							echo '<thead>';
							echo '<tr>';
							echo '<th>Nº</th>';
							echo '<th>Classe</th>';
							echo '<th>Obs.</th>';
							echo '<th style="width: 80px;">Ação</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_telefone_paciente = $row['id_telefone_paciente'];
								$NumeroTel = $row['NumeroTel'];
								$ClasseTel = $row['ClasseTel'];
								if ($ClasseTel == 1) {
									$NomeClasseTel = 'Fixo';
								} else {
									$NomeClasseTel = 'Celular';
								}
								$NotalTel = $row['NotaTel'];
								echo '<tr>';
								echo '<td>'.$NumeroTel.'</td>';
								echo '<td>'.$NomeClasseTel.'</td>';
								echo '<td>'.$NotalTel.'</td>';
								echo '<td><a href="alterar-telefone-novo.php?id_telefone_paciente='.$id_telefone_paciente.'" class="btn btn-default">Alterar</a></td>';
								echo '</tr>';
						    }
						    echo '</tbody>';
							echo '</table>';
						} else {
							// não tem
						}
						?>
		            </div>
		        </div>

		        <div class="form-group">
	        		<label class="control-label col-sm-3">E-mail:</label>
			        <div class="col-sm-9 ajustetel">
	                	<?php
						// buscar xxx
						$sql = "SELECT * FROM email_paciente WHERE id_paciente = '$id_paciente'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							echo '<table class="table table-condensed">';
							echo '<thead>';
							echo '<tr>';
							echo '<th>Nº</th>';
							echo '<th>Obs.</th>';
							echo '<th style="width: 80px;">Ação</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_email_paciente = $row['id_email_paciente'];
								$EmailPaciente = $row['EmailPaciente'];
								$NotaEmail = $row['NotaEmail'];
								echo '<tr>';
								echo '<td>'.$EmailPaciente.'</td>';
								echo '<td>'.$NotaEmail.'</td>';
								echo '<td><a href="alterar-email-novo.php?id_email_paciente='.$id_email_paciente.'" class="btn btn-default">Alterar</a></td>';
								echo '</tr>';
						    }
						    echo '</tbody>';
							echo '</table>';
						} else {
							// não tem
						}
						?>
		            </div>
		        </div>
			    
			    <div class="form-group">
	                <label class="control-label col-sm-3"></label>
	                <div class="col-sm-9">
	                	<a href="paciente.php" class="btn btn-default">Fechar</a>
	                	<button type="submit" class="btn btn-success">Confirmar</button>
			        	<a href="" class="btn btn-default" data-toggle="modal" data-target="#telefone">&#x271B; telefone</a>
			        	<a href="" class="btn btn-default" data-toggle="modal" data-target="#email">&#x271B; e-mail</a>
			        	<?php
			        	if ($CheckApagar > 0) {
			        	} else {
			        		echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#apagar">Apagar</a>';
			        	}
			        	?>
			        	
	                </div>
	            </div>
	        </div>

	        <div class="col-sm-6">
	        </div>
	    </form>
	</div>
</div>

<!-- adicionar telefone -->
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

<!-- adicionar e-mail -->
<div class="modal fade" id="email" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-email-paciente-novo-2.php" method="post" class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar e-mail</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
		                <label class="control-label col-sm-3">E-mail:</label>
		                <div class="col-sm-9">
		                	<input type="email" class="form-control" name="EmailPaciente" required>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="control-label col-sm-3">Observação:</label>
		                <div class="col-sm-9">
		                	<textarea rows="3" class="form-control" name="NotaEmail" placeholder="Pai, mãe, avó" required></textarea>
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

<!-- apagar paciente -->
<div class="modal fade" id="apagar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="apagar-paciente-novo-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Apagar paciente</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <p><b>Cuidado:</b> Os dados do paciente, incluindo a foto e os arquivos importados, serão removidos do sistema.<br> Deseja continuar?</p>

                    <?php
					// buscar xxx
					$sql = "SELECT * FROM midia_avaliacao WHERE id_paciente = '$id_paciente'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while($row = $result->fetch_assoc()) {
							// tem
							$id_midia_avaliacao = $row['id_midida_avaliacao'];
							$ArquivoMidia = $row['ArquivoMidia'];
							echo '<a href="../../vault/avaliacao/'.$ArquivoMidia.'">'.$ArquivoMidia.'</a>';
					    }
					} else {
						// não tem
					}
					?>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor2' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<!-- pesquisa dinâmica -->
<?php include 'pesquisa-dinamica.php';?>

</body>
</html>