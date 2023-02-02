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
$id_paciente = $_GET['id_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Rg = $row['Rg'];
		$OrgaoEmissor = $row['OrgaoEmissor'];
		$Cpf = $row['Cpf'];

		$DataNascimento = $row['DataNascimento'];
		
		if (empty($row['DataNascimento'])) {
			$DataNascimento1 = NULL;
		} else {
			$DataNascimento1 = date("d/m/Y", strtotime($DataNascimento));
			$DataNascimento2 = date("Y-m-d", strtotime($DataNascimento));
		}

		$Pai = $row['Pai'];
		$Mae = $row['Mae'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
		$UsoImagem = $row['UsoImagem'];
		if ($UsoImagem == 1) {
			$NomeUsoImagem = 'Sim';
		} else {
			$NomeUsoImagem = 'Não';
		}

		$id_periodo = $row['id_periodo'];
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
		}

		$id_unidade = $row['id_unidade'];
		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeUnidade = $rowA['NomeUnidade'];
		    }
		} else {
			$NomeUnidade = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			$NomePeriodo = NULL;
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM endereco_paciente WHERE id_paciente = '$id_paciente'";
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
	$Endereco1 = NULL;
	$Endereco = NULL;
	$Numero = NULL;
	$Complemento = NULL;
	$Cep = NULL;
	$Bairro = NULL;
	$Cidade = NULL;
	$Estado = NULL;
	$NomeEstado = 'Selecionar';
}

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

if (empty($DataNascimento)) {
	$age = NULL;
	$Idade = NULL;
} else {
	# procedural
	$age = date_diff(date_create($DataNascimento2), date_create('today'))->y;
	if ($age == 1) {
		$Idade = '1 ano';
	} else {
		$Idade = $age.' anos';
	}
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
<?php
if (empty($_SESSION['AtivarAlteracaoPaciente'])) {
	echo '<h3>Paciente</h3>';
} else {
	echo '<h3>Altrar dados do paciente</h3>';
}
?>

<div class="row">
	
	<?php
	if (empty($_SESSION['AtivarAlteracaoPaciente'])) {
		?>
		<div class="col-lg-4">
			
			<label>Nome completo:</label> <?php echo $NomeCompleto;?><br>
			<label>Nome social:</label> <?php echo $NomeCurto;?><br>
			<label>Pai:</label> <?php echo $Pai;?><br>
			<label>Mãe:</label> <?php echo $Mae;?><br>
			<label>Data de nascimento:</label> <?php echo $DataNascimento1;?><br>
			<label>Idade:</label> <?php echo $Idade;?><br>
			<label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?><br>
			<label>CPF:</label> <?php echo $Cpf;?><br>
			<br>
			<label>Endereço:</label> <?php echo $Endereco1;?><br>
			<label>CEP:</label> <?php echo $Cep;?><br>
			<label>Bairro:</label> <?php echo $Bairro;?><br>
			<label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?><br>
		</div>

		<div class="col-lg-4">
			<label>Telefone:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente' AND ClasseTel = 1";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_telefone_paciente = $row['id_telefone_paciente'];
						$NumeroTel = $row['NumeroTel'];
						$Tipo = $row['Tipo'];
						$NotaTel = $row['NotaTel'];
						echo ' '.$NumeroTel.' - '.$NotaTel.', ';
				    }
				} else {
				}
			?>
			<br>
			<label>Celular:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente' AND ClasseTel = 2";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_telefone_paciente = $row['id_telefone_paciente'];
						$NumeroCel = $row['NumeroTel'];
						$NotaCel = $row['NotaTel'];
						echo ' '.$NumeroCel.' - '.$NotaCel.', ';
				    }
				} else {
				}
			?>
			<br>
			<label>E-mail:</label>
			<?php
				// buscar xxx
				$sql = "SELECT * FROM email_paciente WHERE id_paciente = '$id_paciente'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_email_paciente = $row['id_email_paciente'];
						$EmailPaciente = $row['EmailPaciente'];
						$NotaEmail = $row['NotaEmail'];
						echo ' '.$EmailPaciente.' - '.$NotaEmail.', ';
				    }
				} else {
				}
			?>
			<br>
			<?php
			// buscar xxx
			$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio 
			FROM convenio_paciente 
			INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
			WHERE convenio_paciente.id_paciente = '$id_paciente'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<label>Convênio médico:</label><br>';
			    while($row = $result->fetch_assoc()) {
					// tem 
					$id_convenio_paciente = $row['id_convenio_paciente'];
					$id_paciente = $row['id_paciente'];
					$id_convenio = $row['id_convenio'];
					$NomeConvenio = $row['NomeConvenio'];
					$DataValidade = $row['DataValidade'];
					$StatusConvenioPaciente = $row['StatusConvenioPaciente'];
					echo $NomeConvenio.'<br>';
			    }
			} else {
				// não tem
				echo '<label>Convênio médico:</label><br>';
			}
			?>
			
			<br>
			<label>Uso da imagem:</label> <?php echo $NomeUsoImagem;?><br>
			<label>Período:</label> <?php echo $NomePeriodo;?><br>
			<label>Unidade:</label> <?php echo $NomeUnidade;?><br>
			<label>Status:</label> <?php echo $NomeStatus;?><br>
			<label>Preferência de data e horário:</label> <?php echo $PacientePreferencia;?><br>
			<label>Observação:</label> <?php echo $PacienteObservacao;?><br>

			<?php
			if (empty($_SESSION['AtivarTelefonePaciente'])) {
			} else {
				?>
				<h3>Adicionar telefone, celular e e-mail</h3>
				<form action="adicionar-telefone-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">
					<table class="table table-striped table-hover table-condensed">
					<thead>
					<tr>
					<th>Nº telefone:</th>
					<th>Tipo:</th>
					<th>Observação:</th>
					<th style="width: 100px;">Ação:</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td><input type="text" class="form-control" name="NumeroTel"></td>
					<td>
						<select class="form-control" name="Tipo">
							<option value="">Selecionar</option>
							<option value="1">Comercial</option>
							<option value="2">Residencial</option>
						</select>
					</td>
					<td><input type="text" class="form-control" name="NotaTel" placeholder="ex.: pai, mãe"></td>
					<td><button type="submit" class="btn btn-success">Confirmar</button></td>
					</tr>
					</tbody>
					</table>
				</form>
				<form action="adicionar-celular-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" class="form-inline" method="post" style="margin-bottom: 5px;">
					<table class="table table-striped table-hover table-condensed">
					<thead>
					<tr>
					<th>Nº celular:</th>
					<th>Observação:</th>
					<th style="width: 100px;">Ação:</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td><input type="text" class="form-control" name="NumeroTel"></td>
					<td><input type="text" class="form-control" name="NotaTel" placeholder="ex.: pai, mãe"></td>
					<td><button type="submit" class="btn btn-success">Confirmar</button></td>
					</tr>
					</tbody>
					</table>
				</form>
				<form action="adicionar-email-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" class="form-inline" method="post" style="margin-bottom: 5px;">
					<table class="table table-striped table-hover table-condensed">
					<thead>
					<tr>
					<th>E-mail:</th>
					<th>Observação:</th>
					<th style="width: 100px;">Ação:</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td><input type="text" class="form-control" name="EmailPaciente"></td>
					<td><input type="text" class="form-control" name="NotaEmail" placeholder="ex.: pai, mãe"></td>
					<td><button type="submit" class="btn btn-success">Confirmar</button></td>
					</tr>
					</tbody>
					</table>
				</form>
				<?php
			}

			if ($_SESSION['UsuarioNivel'] > 1) {
			    ?>
			    <div>
					<a href="ativar-alteracao-dados-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Alterar dados</a>

					<?php
					// verificar se o paciente foi utilizada em alguma sesão
					$sql = "SELECT * FROM sessao_paciente WHERE id_paciente = '$id_paciente'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while($row = $result->fetch_assoc()) {
							// foi utilizado
					    }
					} else {
						// não foi
						echo '<a href="ativar-remocao-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default">Apagar</a>';
					}
					?>
					<a href="cadastrar-alterar-telefone-email-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Cadastrar/alterar telefone e e-mail</a>
					<a href="escola-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Ver escola</a>
					<a href="../agenda/agenda-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Agenda do paciente</a>
					<a href="convenio.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Convênio médico</a>
				</div>
			    <?php
			} else {
				?>
			    <?php
			}

			if (empty($_SESSION['AtivarRemocaoPaciente'])) {
			} else {
				?>
				<div class="alert alert-danger" style="margin-top: 25px;">
					<b>Cuidado:</b> o paciente será removido completamente do sistema.<br>
					Deseja continuar?
					<div style="margin-top: 15px;">
						<a href="ativar-remocao-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default" style="margin-right: 5px;">Fechar</a>
						<a href="apagar-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-danger">Apagar</a>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<!-- foto -->
		<div class="col-lg-4">
			<?php
			// buscar xxx
			$sql = "SELECT * FROM midia_paciente WHERE id_paciente = '$id_paciente'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_midia_paciente = $row['id_midia_paciente'];
					$ArquivoMidia = $row['ArquivoMidia'];
					echo '<img src="../../vault/paciente/'.$ArquivoMidia.'" style="max-width: 250px;">';
					echo '<br>';
					echo '<br>';
					echo '<a href="midia-paciente.php?id_paciente='.$id_paciente.'&id_midia_paciente='.$id_midia_paciente.'" class="btn btn-default">Alterar foto</a>';
			    }
			} else {
				echo '<img src="../../img/imagem-default.jpg" style="max-width: 250px;">';
				echo '<br>';
				echo '<br>';
				if ($_SESSION['UsuarioNivel'] > 1) {
				    ?>
				    <a href="alterar-imagem-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default" style="margin-right:5px;">Associar foto</a>
					<a href="importar-foto-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Adicionar foto</a>
				    <?php
				} else {
					?>
				    <?php
				}	
			}
			?>
		</div>
		<?php
	} else {
		?>
		<div class="">
			<form action="alterar-dados-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" class="form-horizontal" method="post">
				<div class="col-lg-6">
					<div class="form-group">
						<label class="control-label col-sm-4">Nome completo:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="NomeCompleto" value="<?php echo $NomeCompleto;?>" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Nome social:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="NomeCurto" value="<?php echo $NomeCurto;?>" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Pai:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="Pai" value="<?php echo $Pai;?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Mãe:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="Mae" value="<?php echo $Mae;?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Data de nascimento:</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" name="DataNascimento" value="<?php echo $DataNascimento;?>">
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
		                    </select>
		                </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">CEP:</label>
	                    <div class="col-sm-8">
	                    	<input type="text" class="form-control" id="Cep" name="Cep" contentEditable="true" placeholder="99999-999" value="<?php echo $Cep;?>">
	                    </div>
	                </div>
	            </div>

				<div class="col-lg-6">
					<div class="form-group">
						<label class="control-label col-sm-4">Uso da imagem:</label>
						<div class="col-sm-8">
							<select class="form-control" name="UsoImagem">
								<option value="<?php echo $UsoImagem;?>"><?php echo $NomeUsoImagem;?></option>
								<option value="1">Sim</option>
								<option value="2">Não</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Período:</label>
						<div class="col-sm-8">
							<select class="form-control" name="id_periodo">
								<option value="<?php echo $id_periodo;?>"><?php echo $NomePeriodo;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM periodo";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										$id_periodo = $row['id_periodo'];
										$NomePeriodo = $row['NomePeriodo'];
										echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
								    }
								} else {
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Unidade:</label>
						<div class="col-sm-8">
							<select class="form-control" name="id_unidade">
								<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										$id_unidade = $row['id_unidade'];
										$NomeUnidade = $row['NomeUnidade'];
										echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
								    }
								} else {
								}
								?>
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
	                    <label class="control-label col-sm-4">Preferência de data e horário:</label>
	                    <div class="col-sm-8">
	                    	<textarea rows="5" class="form-control" style="width: 100%" name="PacientePreferencia" contentEditable="true" placeholder="Ex.: segunda e quarta das 8 às 9h."><?php echo $PacientePreferencia;?></textarea>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-sm-4">Observação:</label>
	                    <div class="col-sm-8">
	                    	<textarea rows="5" class="form-control" style="width: 100%" name="PacienteObservacao" contentEditable="true"><?php echo $PacienteObservacao;?></textarea>
	                    </div>
	                </div>

					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<a href="ativar-alteracao-dados-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar alteração</a>
							<button type="submit" class="btn btn-success">Confirmar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
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
