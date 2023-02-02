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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Terapeuta</h2>

<ul class="nav nav-tabs hidden-print">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="active"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela col-sm-12">

<li><li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>

<div class="row">
	<div class="col-lg-4">
		<li><label>ID:</label> <?php echo $id_profissional;?></li>
		<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
		<li><label>Nome social:</label> <?php echo $NomeCurto;?></li>
		<li><label>Função:</label> <?php echo $NomeFuncao;?></li>
		<li><label>Registro:</label> <?php echo $Registro;?></li>
		<li><label>Registro CRPJ:</label> <?php echo $Crpj;?></li>
		<li><label>Instituição de ensino:</label> <?php echo $Graduacao;?></li>
	
		<li><label>Telefone:</label>
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
		</li>
		<li><label>Celular:</label>
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
		</li>
		<li><label>E-mail:</label>
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
		?>
		</li>
		<li><label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?></li>
		<li><label>CPF:</label> <?php echo $Cpf;?></li>
		<li><label>Data de nascimento:</label> <?php echo $DataNascimento1;?></li>
	</div>

	<div class="col-lg-4">
		<li><label>Usuário:</label> <?php echo $Usuario;?></li>
		<li><label>Senha:</label> <?php echo $NomeSenha;?></li>
		<li><label>Nível de acesso:</label> <?php echo $NomeNivel;?></li>
		<li><label>Status:</label> <?php echo $NomeStatus;?></li>

		<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
		<li><label>CEP:</label> <?php echo $Cep;?></li>
		<li><label>Bairro:</label> <?php echo $Bairro;?></li>
		<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>

		<li><label>Observação:</label> <?php echo $ProfissionalObservacao;?></li>
		<a href="listar-terapeutas-duplicados.php" class="btn btn-default">Fechar</a>
		<a href="" class="btn btn-default" data-toggle="modal" data-target="#Apagar">Apagar</a>
		<br>
		<br>
		<li><label>Terapeutas duplicados:</label><br>
		<?php
		// buscar xxx
		$sqlA = "SELECT * FROM profissional WHERE NomeCompleto = '$NomeCompleto' AND id_profissional != '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_profissionalX = $rowA['id_profissional'];
				$NomeCompletoX = $rowA['NomeCompleto'];

				echo '<li>'.$id_profissionalX.' - '.$NomeCompletoX.' 
				<a href="comparar-terapeutas-duplicados.php?id_profissional='.$id_profissional.'&id_profissionalX='.$id_profissionalX.'" class="btn btn-default">Comparar</a></li>';
		    }
		} else {
			// não tem
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
				echo '<img src="../../vault/profissional/'.$ArquivoMidia.'" style="max-width: 250px;" alt="'.$ArquivoMidia.'">';
		    }
		} else {
			echo '<img src="../../img/imagem-default.jpg" style="max-width: 250px;">';
		}
		?>
	</div>
</div>

</div>
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