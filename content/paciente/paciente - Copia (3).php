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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="active"><a href="paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../convenio/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
	<?php 
	if (isset($id_paciente)) {
		?>
		<div class="ajuste-botao">
			
		</div>
		<div class="newspaper">
			<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
			<li><label>Nome social:</label> <?php echo $NomeCurto;?></li>
			<li><label>Pai:</label> <?php echo $Pai;?></li>
			<li><label>Mãe:</label> <?php echo $Mae;?></li>
			<li><label>Data de nascimento:</label> <?php echo $DataNascimento1;?></li>
			<li><label>Idade:</label> <?php echo $Idade;?></li>
			<li><label>RG:</label> <?php echo $Rg.' - '.$OrgaoEmissor;?></li>
			<li><label>CPF:</label> <?php echo $Cpf;?></li>
			</li>
			<li><label>Data de início:</label> <?php echo $DataInicio1;?></li>
			<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
			<li><label>CEP:</label> <?php echo $Cep;?></li>
			<li><label>Bairro:</label> <?php echo $Bairro;?></li>
			<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>
			<li><label>Uso da imagem:</label> <?php echo $NomeUsoImagem;?></li>
			<li><label>Período:</label> <?php echo $NomePeriodo;?></li>
			<li><label>Unidade:</label> <?php echo $NomeUnidade;?></li>
			<li><label>Status:</label> <?php echo $NomeStatus;?></li>
			<li><label>Preferência de data e horário:</label> <?php echo $PacientePreferencia;?></li>
			<li><label>Observação:</label> <?php echo $PacienteObservacao;?></li>

			<form action="limpar-selecao-paciente-2.php" method="post">
				<input type="text" hidden name="limpar">
				<input type="text" hidden name="Origem" value="<?php echo $Origem;?>">
				<a href="alterar-paciente-novo.php" class="btn btn-default">Alterar</a>
				<button type="submit" class="btn btn-default">Ver outro paciente</button>
			</form>

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
	
<div>


			</div>
    </div>
</div>



<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>