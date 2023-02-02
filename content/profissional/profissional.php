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

<h2>Terapeuta</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="active"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
	<li class="inactive"><a href="../profissional/categoria-profissional.php?id_profissional=<?php echo $id_profissional;?>">Categoria</a></li>
	<li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
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
				
			</div>

			<div class="col-lg-4">
				<label>Data de início:</label> <?php echo $DataInicio1;?><br>
				<label>Data de nascimento:</label> <?php echo $DataNascimento1;?><br>
				<br>
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
				<a href="alterar-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Alterar dados</a>
				<a href="categoria-profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Categoria</a>

				<?php
				if ($CheckProfissional == 1) {
					// o profissional está associado em uma sessão
				} else {
					if ($_SESSION['UsuarioNivel'] > 1) {
						// não está
						if (empty($_SESSION['AtivarRemocaoProfissional'])) {
							echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#Apagar">Apagar</a>';
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
						echo '<button class="btn btn-default" data-toggle="modal" data-target="#importarfoto">Adicionar foto</button>';
					} else {

					}
				}
				?>
			</div>
			<?php
		} else {
		}
		?>	
	</div>
</div>

<!-- importar foto -->
<div class="modal fade" id="importarfoto" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="importar-foto-profissional-2.php" method="post" class="form-inline" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Importar imagem</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <label>Selecione uma foto:</label>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" hidden name="submit">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Importar foto</button>
                </div>
            </form>    
        </div>
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
</body>
</html>
