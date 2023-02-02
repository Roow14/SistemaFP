<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_profissional = $_GET['id_profissional'];

// buscar dados
$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Usuario = $row['Usuario'];
		if (isset($row['Senha'])) {$NomeSenha = '******';} else {$NomeSenha = '';}
		$Nivel = $row['Nivel'];
		if ($Nivel == 2) {$NomeNivel = 'Administrador';} else {$NomeNivel = 'Usuário';}
		
		$Registro = $row['Registro'];
		$Crpj = $row['Crpj'];
		$Rg = $row['Rg'];
		$OrgaoEmissor = $row['OrgaoEmissor'];
		$Cpf = $row['Cpf'];
		$Status = $row['Status'];
		if ($Status == 2) {$NomeStatus = 'Inativo';} else {$NomeStatus = 'Ativo';}

		$DataNascimento = $row['DataNascimento'];
		if (empty($row['DataNascimento'])) {
			$DataNascimento1 = NULL;
		} else {
			$DataNascimento1 = date("d/m/Y", strtotime($DataNascimento));
		}

		$DataInicio = $row['DataInicio'];
		if (empty($row['DataInicio'])) {
			$DataInicio1 = NULL;
		} else {
			$DataInicio1 = date("d/m/Y", strtotime($DataInicio));
		}

		$id_funcao = $row['id_funcao'];
		
		// buscar xxx
		$sqlA = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeFuncao = $rowA['NomeFuncao'];
		    }
		} else {
			$NomeFuncao = NULL;
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM endereco_profissional WHERE id_profissional = '$id_profissional'";
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
		$sqlA = "SELECT * FROM estado WHERE Estado = '$Estado'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeEstado = $rowA['NomeEstado'];
		    }
		} else {
			$NomeEstado = 'Selecionar';
		}
    }
} else {
	$Endereco = NULL;
	$Endereco1 = NULL;
	$Numero = NULL;
	$Complemento = NULL;
	$Cep = NULL;
	$Bairro = NULL;
	$Cidade = NULL;
	$Estado = NULL;
	$NomeEstado = 'Selecionar';
}

// buscar xxx
$sql = "SELECT * FROM profissional_graduacao WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_profissional_graduacao = $row['id_profissional_graduacao'];
		$Graduacao = $row['Graduacao'];
    }
} else {
	$Graduacao = NULL;
}

// buscar xxx
$sql = "SELECT * FROM profissional_observacao WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_profissional_observacao = $row['id_profissional_observacao'];
		$ProfissionalObservacao = $row['ProfissionalObservacao'];
    }
} else {
	$ProfissionalObservacao = NULL;
}

// verificar se o profissional está associado em uma sessão
$sql = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
		$CheckProfissional = 1;
    }
} else {
	$CheckProfissional = 2;
}

// verificar se foi usado no programa fp+
$sqlA = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE fisiofor_prog.prog_incidental_1.id_profissional = '$id_profissional' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkfp = 1;
    }
} else {
	// não tem
	$Checkfp = 0;
}

// verificar se foi usado na agenda base
$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkagendabase = 1;
    }
} else {
	// não tem
	$Checkagendabase = 0;
}

// verificar se foi usado na agenda
$sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkagenda = 1;
    }
} else {
	// não tem
	$Checkagenda = 0;
}

$Check = $Checkagenda + $Checkagendabase + $Checkfp;
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
    <?php include '../menu-lateral/menu-lateral-profissional.php';?>

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
	<div class="row">
		<form action="alterar-dados-profissional-2.php?id_profissional=<?php echo $id_profissional;?>" class="form-horizontal" method="post">
			<div class="col-lg-6">
				
				<div class="form-group">
					<label class="control-label col-sm-4">Nome completo:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="NomeCompleto" value="<?php echo $NomeCompleto;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Nome social:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="NomeCurto" value="<?php echo $NomeCurto;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Funcão:</label>
					<div class="col-sm-8">
						<select class="form-control" name="id_funcao">
							<option value="<?php echo $id_funcao;?>"><?php echo $NomeFuncao;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM funcao ORDER BY NomeFuncao ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_funcao = $row['id_funcao'];
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
					<label class="control-label col-sm-4">Registro :</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Registro" value="<?php echo $Registro;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Registro CRPJ:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Crpj" value="<?php echo $Crpj;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Instituição de ensino:</label>
					<div class="col-sm-8">
						<textarea rows="3" name="Graduacao" class="form-control"><?php echo $Graduacao;?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Telefone:</label>
					<div class="col-sm-8">
						<?php
						// buscar xxx
						$sql = "SELECT * FROM telefone_profissional WHERE id_profissional = '$id_profissional' AND ClasseTel = 1 ORDER BY id_telefone_profissional ASC LIMIT 1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								$Telefone = $row['NumeroTel'];
								$id_telefone = $row['id_telefone_profissional'];
						    }
						} else {
							$Telefone = NULL;
							$id_telefone = NULL;
						}
						?>
						<input type="text" class="form-control" name="Telefone" value="<?php echo $Telefone;?>">
						<input type="text" name="id_telefone" value="<?php echo $id_telefone;?>" hidden>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Celular:</label>
					<div  class="col-sm-8">
						<?php
						// buscar xxx
						$sql = "SELECT * FROM telefone_profissional WHERE id_profissional = '$id_profissional' AND ClasseTel = 2 ORDER BY id_telefone_profissional ASC LIMIT 1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								$id_celular = $row['id_telefone_profissional'];
								$Celular = $row['NumeroTel'];
						    }
						} else {
							$Celular = NULL;
							$id_celular = NULL;
						}
						?>
						<input type="text" class="form-control" name="Celular" value="<?php echo $Celular;?>">
						<input type="text" name="id_celular" value="<?php echo $id_celular;?>" hidden>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">E-mail:</label>
					<div class="col-sm-8">
						<?php
						// buscar xxx
						$sql = "SELECT * FROM email_profissional WHERE id_profissional = '$id_profissional' AND TipoEmail = 2 ORDER BY id_email_profissional ASC LIMIT 1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								$id_email_profissional = $row['id_email_profissional'];
								$EmailProfissional = $row['EmailProfissional'];
						    }
						} else {
							$EmailProfissional = NULL;
							$id_email_profissional = NULL;
						}
						?>
						<input type="text" class="form-control" name="EmailProfissional" value="<?php echo $EmailProfissional;?>">
						<input type="text" name="id_email_profissional" value="<?php echo $id_email_profissional;?>" hidden>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">RG:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Rg" value="<?php echo $Rg;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Órgão emissor:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="OrgaoEmissor" value="<?php echo $OrgaoEmissor;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">CPF:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Cpf" value="<?php echo $Cpf;?>">
					</div>
				</div>
			</div>

			<div class="col-lg-6">

				<div class="form-group">
					<label class="control-label col-sm-4">Data de início:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" name="DataInicio" value="<?php echo $DataInicio;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Data de nascimento:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" name="DataNascimento" value="<?php echo $DataNascimento;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Usuário:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Usuario" value="<?php echo $Usuario;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Senha:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="Senha" placeholder="<?php echo $NomeSenha;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Nível de acesso:</label>
					<div class="col-sm-8">
						<select class="form-control" name="Nivel">
							<option value="<?php echo $Nivel;?>"><?php echo $NomeNivel;?></option>
							<option value="2">Adminstrador</option>
							<option value="1">Usuário</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-4">Status:</label>
					<div class="col-sm-8">
						<select class="form-control" name="Status">
							<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
							<option value="1">Ativo</option>
							<option value="2">Inativo</option>
						</select>
					</div>
				</div>

				<div class="form-group">
	                    <label class="control-label col-sm-4">Rua, Av.:</label>
	                    <div class="col-sm-8">
	                    	<input id="SearchEndereco" type="text" class="form-control" name="Endereco" contentEditable="true" value="<?php echo $Endereco;?>">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Nº:</label>
	                    <div class="col-sm-8">
	                    	<input type="text" class="form-control" name="Numero" contentEditable="true" value="<?php echo $Numero;?>">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Compl.:</label>
	                    <div class="col-sm-8">
	                    	<input type="text" class="form-control" name="Complemento" contentEditable="true" value="<?php echo $Complemento;?>">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Bairro:</label>
	                    <div class="col-sm-8">
	                    	<input id="SearchBairro" type="text" class="form-control" name="Bairro" contentEditable="true" value="<?php echo $Bairro;?>">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Cidade:</label>
	                    <div class="col-sm-8">
	                    	<input id="SearchCidade" type="text" class="form-control" name="Cidade" contentEditable="true" value="<?php echo $Cidade;?>">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Estado (UF):</label>
	                    <div class="col-sm-8">
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
								<option value="">Limpar seleção</option>
		                    </select>
		                </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">CEP:</label>
	                    <div class="col-sm-8">
	                    	<input type="text" class="form-control" id="Cep" name="Cep" contentEditable="true" placeholder="99999-999" value="<?php echo $Cep;?>">
	                    </div>
	                </div>

	            <div class="form-group">
	                    <label class="control-label col-sm-4">Observação:</label>
	                    <div class="col-sm-8">
	                    	<textarea rows="3" class="form-control" style="width: 100%" name="ProfissionalObservacao" contentEditable="true"><?php echo $ProfissionalObservacao;?></textarea>
	                    </div>
	                </div>

			  	<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<a href="profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Fechar</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="Apagar" role="dialog">
    <div class="modal-dialog">

    	<?php 
    	if ($Check > 0) {
    		?>
	        <!-- Modal content-->
	        <div class="modal-content">
	            <form action="" method="post">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h4 class="modal-title">Apagar terapeuta</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
	                    <p><b>Erro:</b> O terapeuta foi utilizado na <b>agenda base, agenda</b> ou no <b>Programa FP+</b> e portanto não pode ser removido.</p>
	                    <p>Se o terapeuta não for mais utilizado, altere o <b>Status</b> para <b>inativo</b>.
	                    </p>

	                </div>
	                
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	                </div>
	            </form>    
	        </div>
    		<?php
    	} else {
    		?>
	        <!-- Modal content-->
	        <div class="modal-content">
	            <form action="apagar-profissional-2.php?id_profissional=<?php echo $id_profissional;?>" method="post">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h4 class="modal-title">Apagar terapeuta</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
	                    <p><b>Cuidado!</b> O terapeuta será removido completamente do sistema.<br>
	                    Deseja continuar?</p>

	                </div>
	                
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	                    <button type="submit" class="btn btn-danger">Apagar</button>
	                </div>
	            </form>    
	        </div>
    		<?php
    	}
    	?>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<!-- mantem a posição após o reload -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
</body>
</html>
