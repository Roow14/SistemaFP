<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

// input
$id_paciente = $_GET['id_paciente'];
$id_sessao_paciente = $_GET['id_sessao_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCurto = $row['NomeCurto'];
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
}
// buscar xxx
$sql = "SELECT * FROM sessao_paciente WHERE id_sessao_paciente = '$id_sessao_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$SessaoInicial = $row['SessaoInicial'];
		$SessaoAgendada = $row['SessaoAgendada'];
		$SessaoFinal = $row['SessaoFinal'];
		$id_categoria = $row['id_categoria'];
		// buscar xxx
		$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeCategoria = $rowA['NomeCategoria'];
		    }
		} else {
		}
    }
} else {
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
<div class="">
    <h3>Agenda do paciente por sessão</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
	<span style="margin-right: 25px; display: inline-block;"><label>Id:</label> <?php echo $id_sessao_paciente;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Categoria:</label> <?php echo $NomeCategoria;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Nº sessões:</label> <?php echo $SessaoInicial;?></span>
	<span style="margin-right: 25px; display: inline-block;"><label>Nº sessões agendadas:</label> <?php echo $SessaoAgendada;?></span>
	<br>
	<a href="listar-sessoes.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">&lsaquo;Voltar</a>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM sessao WHERE id_sessao_paciente = '$id_sessao_paciente' ORDER BY DataSessao ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Data</th>';
		echo '<th>Hora</th>';
		echo '<th>Profissional</th>';
		echo '<th>Unidade</th>';
		echo '<th>Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$DataSessao = $row['DataSessao'];
			$DataSessao1 = date("d/m/Y", strtotime($DataSessao));
			$id_hora = $row['id_hora'];
			$id_unidade = $row['id_unidade'];
			$id_periodo = $row['Periodo'];
			$id_sessao_paciente = $row['id_sessao_paciente'];
			$id_profissionalX = $row['id_profissional'];

			// buscar xxx
			$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$Hora = $rowA['Hora'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeUnidade = $rowA['NomeUnidade'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissionalX'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$id_profissionalX = $rowA['id_profissional'];
					$NomeCompletoX = $rowA['NomeCompleto'];
					$NomeCurtoX = $rowA['NomeCurto'];
			    }
			} else {
			}
			echo '<tr>';
			echo '<td style="width: 100px;">'.$DataSessao1.'</td>';
			echo '<td style="width: 60px;">'.$Hora.'</td>';
			echo '<td><a href="../profissional/profissional.php?id_profissional='.$id_profissionalX.'" class="Link">'.$NomeCurtoX.'</a></td>';
			echo '<td>'.$NomeUnidade.'</td>';
			echo '<td style="width:200px;">';
			echo '<a href="agendar-sessao-1.php?
			id_paciente='.$id_paciente.'
			&id_sessao_paciente='.$id_sessao_paciente.'
			&id_unidade='.$id_unidade.'
			&id_categoria='.$id_categoria.'
			&id_periodo='.$id_periodo.'
			&DataSessao='.$DataSessao.'
			&Origem=agenda-sessao-paciente.php" class="btn btn-default" style="margin-right: 5px;">Ver agenda</a>';
			echo '<a href="" class="btn btn-default">Alterar</a>';
			echo '</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
		echo 'Não encontramos nenhuma sessão cadastrada neste período.';
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
