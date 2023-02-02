<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$Origem = 'paciente.php';
$_SESSION['Origem'] = $Origem;

if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} elseif (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
} elseif (!empty($_POST['id_paciente']))	{
	$id_paciente = $_POST['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} else {
	unset($_SESSION['id_paciente']);
}

if (isset($_POST['limpar'])) {
	unset($_SESSION['id_paciente']);
}

if (isset($id_paciente)) {
	// buscar xxx
	include 'dados-paciente.php';
}

// verificar se tem anotações médicas
// buscar xxx
$sql = "SELECT * FROM exame_novo WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Checkexame = 1;
    }
} else {
	// não tem
	$Checkexame = NULL;
}
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
	.ajuste-botao {
		float: right;
		/*margin-top: -30px;*/
	}

	/* The Modal (background) */
	.modal1 {
	  display: block; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  padding-top: 80px; /* Location of the box */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content1 {
	  background-color: transparent !important;
	  margin: auto;
	  padding: 15px !important;
	  border: none !important;
	  max-width: 600px;
	  border-radius: 0 !important;
	  -webkit-box-shadow: none !important;
	  box-shadow: none !important;
	}
	.imagem img {
		width: 100%;
	}
	@media only screen and (min-width: 900px) {
		.imagem img {
			max-width: 250px;
		}
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Paciente</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="active"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<div class="row">
	<?php 
	if (isset($id_paciente)) {
		?>

		<div class="newspaper col-sm-9">
			<li><label>ID:</label> <?php echo $id_paciente;?></li>
			<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
			<li><label>Nome social:</label> <?php echo $NomeCurto;?></li>
			<li><label>Processo:</label> <?php echo $Processo;?></li>
			<li><label>Data de nascimento:</label> <?php echo $DataNascimento1;?></li>
			<li><label>Idade:</label> <?php echo $Idade;?></li>
			<li><label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?></li>
			<li><label>CPF:</label> <?php echo $Cpf;?></li>
			</li>

			<hr>
			<li><label>Pai:</label> <?php echo $Pai;?></li>
			<li><label>Mãe:</label> <?php echo $Mae;?></li>
			<li>
        		<label>Tel./cel.:</label>
            	<?php
				// buscar xxx
				$sql = "SELECT * FROM telefone_paciente WHERE id_paciente = '$id_paciente'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
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

						echo $NumeroTel.' - '.$NotalTel.'<br>';
						$CheckTel = 1;
				    }
				} else {
					// não tem
					$CheckTel = 0;
				}
				?>
	        </li>
	        <li>
        		<label>E-mail:</label>
            	<?php
				// buscar xxx
				$sql = "SELECT * FROM email_paciente WHERE id_paciente = '$id_paciente'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_email_paciente = $row['id_email_paciente'];
						$EmailPaciente = $row['EmailPaciente'];
						$NotaEmail = $row['NotaEmail'];
						echo $EmailPaciente.' - '.$NotaEmail.'<br>';
				    }
				} else {
					// não tem
				}
				?>
		    </li>
			
			
			<hr>
			<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
			<li><label>CEP:</label> <?php echo $Cep;?></li>
			<li><label>Bairro:</label> <?php echo $Bairro;?></li>
			<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>

			<hr>
			<li><label>Data de início:</label> <?php echo $DataInicio1;?></li>
			<li><label>Uso da imagem:</label> <?php echo $NomeUsoImagem;?></li>
			<li><label>Período:</label> <?php echo $NomePeriodo;?></li>
			<li><label>Unidade:</label> <?php echo $NomeUnidade;?></li>
			<li><label>Status:</label> <?php echo $NomeStatus;?></li>
			<li><label>Preferência de data e horário:</label> <?php echo $PacientePreferencia;?></li>
			<li><label>Observação:</label> <?php echo $PacienteObservacao;?></li>
		</div>

		<div class="col-sm-3 imagem">
			<?php
			// buscar xxx
			$sql = "SELECT * FROM midia_paciente WHERE id_paciente = '$id_paciente'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_midia_paciente = $row['id_midia_paciente'];
					$ArquivoMidia = $row['ArquivoMidia'];
					echo '<img src="../../vault/paciente/'.$ArquivoMidia.'"';
					echo '<br>';
					echo '<br>';
					echo '<a href="midia-paciente.php?id_paciente='.$id_paciente.'&id_midia_paciente='.$id_midia_paciente.'" class="btn btn-default">Alterar foto</a>';
			    }
			} else {
				echo '<img src="../../img/imagem-default.jpg"';
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

		<div class="col-sm-12">
			<a href="alterar-paciente-novo.php" class="btn btn-default">Alterar</a>
			<!-- <form action="limpar-selecao-paciente-2.php" method="post">
				<input type="text" hidden name="limpar">
				<input type="text" hidden name="Origem" value="<?php echo $Origem;?>">
				<button type="submit" class="btn btn-default">Ver outro paciente</button>
			</form> -->
		</div>
		<?php
	} else {
		?>
		<form action="" method="post" class="form-inline"><a href=""></a>
			<div class="form-group">
				<label>Nome do paciente</label>
				<select class="form-control" name="id_paciente">
					<option value="">Selecionar</option>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while($row = $result->fetch_assoc()) {
							// tem
							$id_pacienteX = $row['id_paciente'];
							$NomeCompletoX = $row['NomeCompleto'];
							echo '<option value="'.$id_pacienteX.'">'.$NomeCompletoX.'</option>';
					    }
					} else {
						// não tem
					}
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</form>
		<?php
	}
	?>
	</div>
<div>

<?php
if ((empty($Checkcpf)) OR (empty($Checkprocesso)) OR (empty($Checkconvenio)) OR (empty($Checkexame)) OR (empty($CheckUnidade)) OR (empty($CheckPeriodo)) OR (empty($Checkaddress)) OR (empty($Checkpreferenciahorario)) OR (empty($CheckTel)) ) {
	?>
	<div id="myModal123" class="modal1">
	  	<div class="modal-content1">
			<!-- <span class="close1">&times;</span> -->
			<div class="modal-dialog">

	        <!-- Modal content-->
	        <div class="modal-content">
	            <form action="adicionar-avaliacao-2.php" method="post">

	                <div class="modal-header">
	                    <!-- <span class="close1">&times;</span> -->
	                    <h4 class="modal-title">Aviso</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
		           			<p>Faltam preencher os campos obrigatórios:</p>
		           			<p>
		           				<b>
		                    <?php
												if (empty($Checkcpf)) {
													echo '<li>CPF</li>';
												}
												if (empty($Checkprocesso)) {
													echo '<li>Processo</li>';
												}
												if (empty($Checkconvenio)) {
													echo '<li>Convênio</li>';
												}
												if (empty($CheckNumeroConvenio)) {
													echo '<li>Nº da carteirinho do convênio</li>';
												}
												if (empty($Checkexame)) {
													echo '<li>Observações médicas</li>';
												}
												if (empty($CheckUnidade)) {
													echo '<li>Unidade</li>';
												}
												if (empty($CheckPeriodo)) {
													echo '<li>Período</li>';
												}
												if (empty($Checkaddress)) {
													echo '<li>Endereço</li>';
												}
												if (empty($Checkpreferenciahorario)) {
													echo '<li>Preferência de horário</li>';
												}
												if (empty($CheckTel)) {
													echo '<li>Telefone</li>';
												}
												?>
											</b>
										</p>
	                </div>
	                
	                <div class="modal-footer">
	                    <button type="button" class="btn" data-dismiss="modal"><span class="close1">Fechar</span></button>
	                </div>
	            </form>    
	        </div>
	    </div>
		</div>
	</div>
	<?php
} else {
}
?>
	
<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script>
	// Get the modal
	var modal = document.getElementById("myModal123");

	// Get the button that opens the modal

	// Get the <span> element that close1s the modal
	var span = document.getElementsByClassName("close1")[0];

	// When the user clicks the button, open the modal 


	// When the user clicks on <span> (x), close1 the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close1 it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
</script>

</body>
</html>