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

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$id_periodo = $row['id_periodo'];
		$id_unidade = $row['id_unidade'];
    }
} else {
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.txt-dir {
		text-align: right;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <h3>Sessões</h3>
            <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

            <div class="row" style="margin-top: 15px;">
            	<div class="col-lg-10">
		            <?php
		            if (empty($_SESSION['AtivarAlteracaoSessao'])) {

		            } else {

		            }
					// buscar xxx
					$sql = "SELECT * FROM sessao_paciente WHERE id_paciente = '$id_paciente'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						echo '<table class="table table-striped table-hover table-condensed">';
						echo '<thead>';
						echo '<tr>';
						echo '<th>id</th>';
						echo '<th>Categoria</th>';
						echo '<th class="txt-dir">Sessões</th>';
						echo '<th class="txt-dir">Agendadas</th>';
						echo '<th class="txt-dir">Realizado</th>';
						echo '<th class="txt-dir">Horas</th>';
						echo '<th class="txt-dir">Hr. real.</th>';
						echo '<th>Status</th>';
						echo '<th>Ação</th>';
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
					    while($row = $result->fetch_assoc()) {
							$id_sessao_paciente = $row['id_sessao_paciente'];
							$SessaoInicial = $row['SessaoInicial'];
							$SessaoAgendada = $row['SessaoAgendada'];
							$SessaoFinal = $row['SessaoFinal'];
							$HorasInicial = $row['HorasInicial'];
							$HorasFinal = $row['HorasFinal'];

							$Status = $row['Status'];
							if ($Status == 1) {
								$NomeStatus = 'Aberto';
							} else {
								$NomeStatus = 'Fechado';
							}

							$id_categoria = $row['id_categoria'];
							// buscar xxx
							$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria' ";
							$resultA = $conn->query($sqlA);
							if ($resultA->num_rows > 0) {
							    while($rowA = $resultA->fetch_assoc()) {
									$NomeCategoria = $rowA['NomeCategoria'];
							    }
							} else {
							}
								
							if (empty($_SESSION['AtivarAlteracaoSessao'])) {
								echo '<tr>';
								echo '<td>'.$id_sessao_paciente.'</td>';
								echo '<td>'.$NomeCategoria.'</td>';
								echo '<td class="txt-dir">'.$SessaoInicial.'</td>';
								echo '<td class="txt-dir">'.$SessaoAgendada.'</td>';
								echo '<td class="txt-dir">'.$SessaoFinal.'</td>';
								echo '<td class="txt-dir">'.$HorasInicial.'</td>';
								echo '<td class="txt-dir">'.$HorasFinal.'</td>';
								echo '<td>'.$NomeStatus.'</td>';
								echo '<td style="width: 250px;">';
								echo '<a href="agendar-sessao.php?id_paciente='.$id_paciente.'&id_categoria='.$id_categoria.'&id_periodo='.$id_periodo.'&id_unidade='.$id_unidade.'&id_sessao_paciente='.$id_sessao_paciente.'" class="btn btn-default" style="margin-right: 5px;">Agendar sessão</a>';
								echo '<a href="agenda-sessao-paciente.php?id_paciente='.$id_paciente.'&id_sessao_paciente='.$id_sessao_paciente.'" class="btn btn-default">Ver agenda</a>';
								echo '</td>';
								echo '</tr>';
				            } else {
				            	echo '<form action="alterar-sessao-paciente.php?id_paciente='.$id_paciente.'&id_sessao_paciente='.$id_sessao_paciente.'" method="post">';
				            	echo '<tr>';
								echo '<td>'.$id_sessao_paciente.'</td>';
								echo '<td>'.$NomeCategoria.'</td>';
								echo '<td><input type="number" class="form-control txt-dir" name="SessaoInicial" value="'.$SessaoInicial.'" required></td>';
								echo '<td class="txt-dir">'.$SessaoAgendada.'</td>';
								echo '<td class="txt-dir">'.$SessaoFinal.'</td>';
								echo '<td><input type="number" class="form-control txt-dir" name="HorasInicial" value="'.$HorasInicial.'" required></td>';
								echo '<td class="txt-dir" style="width: 100px;">'.$HorasFinal.'</td>';
								echo '<td style="width: 120px;">';
								?>
								<select class="form-control" name="Status">
									<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
									<option value="1">Aberto</option>
									<option value="2">Fechado</option>
								</select>
								<?php
								echo '</td>';
								echo '<td  style="width: 180px;">';
								echo '<button type="submit" class="btn btn-warning" style="margin-right: 5px;">Alterar</button>';
								echo '<a href="apagar-sessao-paciente-2.php?id_sessao_paciente='.$id_sessao_paciente.'&id_paciente='.$id_paciente.'" class="btn btn-default">Apagar</a>';
								echo '</td>';
								echo '</tr>';
								echo '</form>';
				            }
					    }
					    echo '</tbody>';
						echo '</table>';

						if (empty($_SESSION['AtivarAlteracaoSessao'])) {
							echo '<a href="ativar-alteracao-sessao.php?id_paciente='.$id_paciente.'" class="btn btn-default" style="margin-right: 5px;">Alterar</a>';
							echo '<a href="cadastrar-sessao.php?id_paciente='.$id_paciente.'" class="btn btn-default">Adicionar sessão</a>';
						} else {
							echo '<a href="ativar-alteracao-sessao.php?id_paciente='.$id_paciente.'" class="btn btn-default">Fechar alteração</a>';
						}
					} else {
						echo 'Não encontramos nenhuma sessão cadastrada no sistema.';
						echo '<br>';
						echo '<a href="cadastrar-sessao.php?id_paciente='.$id_paciente.'" class="btn btn-default">Cadastrar sessão</a>';
					}

					echo '<div style="clear: both;"></div>';

					if (empty($_SESSION['ErraoApagarSessaoPaciente'])) {
					} else {
						?>
						<div class="alert alert-info" style="margin-top: 25px;">
							<a href="cancelar-mensagem-remocao-sessao.php?id_paciente=<?php echo $id_paciente;?>" style="float: right;">&#x2716;</a>
							<b>Erro:</b> a sessão não pode ser removida porque tem agenda definida.<br>
							Se precisar, cancele todas as sessões agendadas e em seguida remova a sessão.
						</div>
						<?php
					}

					?>

					
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
