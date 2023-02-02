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
	<div class="col-lg-6">
		<?php
		$id_profissional = $_GET['id_profissional'];
		include 'comparar-terapeutas-duplicados-dados.php';
		?>
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

		<li><label>Usuário:</label> <?php echo $Usuario;?></li>
		<li><label>Senha:</label> <?php echo $NomeSenha;?></li>
		<li><label>Nível de acesso:</label> <?php echo $NomeNivel;?></li>
		<li><label>Status:</label> <?php echo $NomeStatus;?></li>

		<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
		<li><label>CEP:</label> <?php echo $Cep;?></li>
		<li><label>Bairro:</label> <?php echo $Bairro;?></li>
		<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>

		<li><label>Observação:</label> <?php echo $ProfissionalObservacao;?></li>
		<a href="listar-dados-terapeuta.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Abrir</a>
		<br>

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

	<div class="col-lg-6">
		<?php
		$id_profissional = $_GET['id_profissionalX'];
		include 'comparar-terapeutas-duplicados-dados.php';
		?>
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

		<li><label>Usuário:</label> <?php echo $Usuario;?></li>
		<li><label>Senha:</label> <?php echo $NomeSenha;?></li>
		<li><label>Nível de acesso:</label> <?php echo $NomeNivel;?></li>
		<li><label>Status:</label> <?php echo $NomeStatus;?></li>

		<li><label>Endereço:</label> <?php echo $Endereco1;?></li>
		<li><label>CEP:</label> <?php echo $Cep;?></li>
		<li><label>Bairro:</label> <?php echo $Bairro;?></li>
		<li><label>Cidade/Estado:</label> <?php echo $Cidade.'/'.$Estado;?></li>

		<li><label>Observação:</label> <?php echo $ProfissionalObservacao;?></li>
		<a href="listar-dados-terapeuta.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Abrir</a>
		<br>

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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>