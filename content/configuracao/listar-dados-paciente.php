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

// verificar se o paciente está associado em uma sessão
$sql = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
		$CheckPaciente = 1;
    }
} else {
	$CheckPaciente = 2;
}

// verificar se foi usado no programa fp+
$sqlA = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE fisiofor_prog.prog_incidental_1.id_paciente = '$id_paciente' LIMIT 1";
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
$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' LIMIT 1";
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
$sqlA = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente' LIMIT 1";
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

<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>

<div class="row">
	<div class="col-lg-4">
		<li><label>ID:</label> <?php echo $id_paciente;?></li>
		<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
		<li><label>Nome social:</label> <?php echo $NomeCurto;?></li>
		<li><label>Pai:</label> <?php echo $Pai;?></li>
		<li><label>Mãe:</label> <?php echo $Mae;?></li>
		<li><label>Data de nascimento:</label> <?php echo $DataNascimento1;?></li>
		<li><label>Idade:</label> <?php echo $Idade;?></li>
		<li><label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?></li>
		<li><label>CPF:</label> <?php echo $Cpf;?></li>
		</li>
		<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
		<li><label>CEP:</label> <?php echo $Cep;?></li>
		<li><label>Bairro:</label> <?php echo $Bairro;?></li>
		<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>
	</div>

	<div class="col-lg-4">
		<li><label>Telefone:</label>
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
		</li>
		<li><label>Celular:</label>
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
		</li>
		<li><label>E-mail:</label>
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
		</li>
		<?php
		// buscar xxx
		$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio 
		FROM convenio_paciente 
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<li><label>Convênio médico:</label></li>';
		    while($row = $result->fetch_assoc()) {
				// tem 
				$id_convenio_paciente = $row['id_convenio_paciente'];
				$id_paciente = $row['id_paciente'];
				$id_convenio = $row['id_convenio'];
				$NomeConvenio = $row['NomeConvenio'];
				$DataValidade = $row['DataValidade'];
				$StatusConvenioPaciente = $row['StatusConvenioPaciente'];
				echo $NomeConvenio.'</li>';
		    }
		} else {
			// não tem
			echo '<li><label>Convênio médico:</label></li>';
		}
		?>
		</li>
		<li><label>Uso da imagem:</label> <?php echo $NomeUsoImagem;?></li>
		<li><label>Período:</label> <?php echo $NomePeriodo;?></li>
		<li><label>Unidade:</label> <?php echo $NomeUnidade;?></li>
		<li><label>Status:</label> <?php echo $NomeStatus;?></li>
		<li><label>Preferência de data e horário:</label> <?php echo $PacientePreferencia;?></li>
		<li><label>Observação:</label> <?php echo $PacienteObservacao;?></li>
		<a href="listar-pacientes	-duplicados.php" class="btn btn-default">Fechar</a>
		<a href="" class="btn btn-default" data-toggle="modal" data-target="#Apagar">Apagar</a>
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
	                    <h4 class="modal-title">Apagar paciente</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
	                    <p><b>Erro:</b> O paciente foi utilizado na <b>agenda base, agenda</b> ou no <b>Programa FP+</b> e portanto não pode ser removido.</p>
	                    <p>Se o paciente não for mais utilizado, altere o <b>Status</b> para <b>inativo</b>.
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
	            <form action="apagar-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h4 class="modal-title">Apagar paciente</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
	                    <p><b>Cuidado!</b> O paciente será removido completamente do sistema.<br>
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