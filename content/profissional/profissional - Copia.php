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
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-profissional.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
<?php
if (empty($_SESSION['AtivarAlteracaoProfissional'])) {
	echo '<h3>Profissional</h3>';
} else {
	echo '<h3>Alterar dados do profissional</h3>';
}
?>

<div class="row">
	<?php
	if (empty($_SESSION['AtivarAlteracaoProfissional'])) {
		?>
		<div class="col-lg-4">
			
			<label>Nome completo:</label> <?php echo $NomeCompleto;?><br>
			<label>Nome social:</label> <?php echo $NomeCurto;?><br>
			<label>Função:</label> <?php echo $NomeFuncao;?><br>
			<label>Registro:</label> <?php echo $Registro;?><br>
			<label>Registro CRPJ:</label> <?php echo $Crpj;?><br>
			<label>Instituição de ensino:</label> <?php echo $Graduacao;?><br>
			<br>
			<label>Telefone:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM telefone_profissional WHERE id_profissional = '$id_profissional' AND ClasseTel = 1";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_telefone_profissional = $row['id_telefone_profissional'];
						$NumeroTel = $row['NumeroTel'];
						$Tipo = $row['Tipo'];
						$NotaTel = $row['NotaTel'];
						echo ' '.$NumeroTel;
				    }
				} else {
				}
			?>
			<br>
			<label>Celular:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM telefone_profissional WHERE id_profissional = '$id_profissional' AND ClasseTel = 2";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_telefone_profissional = $row['id_telefone_profissional'];
						$NumeroCel = $row['NumeroTel'];
						$NotaCel = $row['NotaTel'];
						echo ' '.$NumeroCel;
				    }
				} else {
				}
			?>
			<br>
			<label>E-mail:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM email_profissional WHERE id_profissional = '$id_profissional'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_email_profissional = $row['id_email_profissional'];
						$EmailProfissional = $row['EmailProfissional'];
						$NotaEmail = $row['NotaEmail'];
						echo ' '.$EmailProfissional;
				    }
				} else {
				}
				echo '<br>';
			?>
			<br>
			<label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?><br>
			<label>CPF:</label> <?php echo $Cpf;?><br>
			<label>Data de nascimento:</label> <?php echo $DataNascimento1;?><br>
		</div>

		<div class="col-lg-4">
			<label>Usuário:</label> <?php echo $Usuario;?><br>
			<label>Senha:</label> <?php echo $NomeSenha;?><br>
			<label>Nível de acesso:</label> <?php echo $NomeNivel;?><br>
			<label>Status:</label> <?php echo $NomeStatus;?><br>
			<br>
			<label>Endereço:</label> <?php echo $Endereco1;?><br>
			<label>CEP:</label> <?php echo $Cep;?><br>
			<label>Bairro:</label> <?php echo $Bairro;?><br>
			<label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?><br>
			<br>
			<label>Observação:</label> <?php echo $ProfissionalObservacao;?><br>
			<br>
			<?php
			if ($_SESSION['UsuarioNivel'] > 1) {
				echo '<a href="ativar-alteracao-dados-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default">Alterar dados</a>';
			} else {

			}
			?>
			
			<a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Agenda do profissional</a>
			<!-- <a href="ativar-adicao-categoria-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Adicionar categoria</a> -->
			<?php
			if ($CheckProfissional == 1) {
				// o profissional está associado em uma sessão
			} else {
				if ($_SESSION['UsuarioNivel'] > 1) {
					// não está
					if (empty($_SESSION['AtivarRemocaoProfissional'])) {
						echo '<a href="ativar-remocao-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default">Apagar</a>';
					} else {
					}
				} else {

				}
			}

			if (empty($_SESSION['AtivarRemocaoProfissional'])) {
			} else {
				?>
				<div class=" alert alert-danger" style="margin-top:  25px;">
					<b>Cuidado:</b> o profissional será removido completamente do sistema.<br>
					Deseja continuar?<br>
					<div style="margin-top: 15px;">
						<a href="ativar-remocao-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default" style="margin-right: 5px;">Fechar</a>
						<a href="apagar-profissional-2.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-danger">Apagar</a>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<div class="col-lg-4">
			<?php
			// buscar xxx
			$sql = "SELECT * FROM midia_profissional WHERE id_profissional = '$id_profissional'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_midia_profissional = $row['id_midia_profissional'];
					$ArquivoMidia = $row['ArquivoMidia'];
					echo '<img src="../../vault/profissional/'.$ArquivoMidia.'" style="max-width: 250px;">';
					echo '<br>';
					echo '<br>';
					echo '<a href="midia-profissional.php?id_profissional='.$id_profissional.'&id_midia_profissional='.$id_midia_profissional.'" class="btn btn-default">Alterar foto</a>';
			    }
			} else {
				echo '<img src="../../img/imagem-default.jpg" style="max-width: 250px;">';
				echo '<br>';
				echo '<br>';

				if ($_SESSION['UsuarioNivel'] > 1) {
					echo '<a href="alterar-imagem-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default" style="margin-right: 5px;">Associar foto</a>';
					echo '<a href="importar-foto-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default">Adicionar foto</a>';
				} else {

				}
			}
			?>
		</div>
		<?php
	} else {
		?>
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

				<div class="form-group">
					<label class="control-label col-sm-4">Data de nascimento:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" name="DataNascimento" value="<?php echo $DataNascimento;?>">
					</div>
				</div>

			</div>
			<div class="col-lg-6">

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
						<a href="ativar-alteracao-dados-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Fechar alteração</a>
						<button type="submit" class="btn btn-success">Confirmar</button>
					</div>
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
