<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
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
$Origem  = 'relatorio-agenda-do-dia.php';
unset($_SESSION['id_paciente']);
unset($_SESSION['id_profissional']);
 	
if (empty($_SESSION['DataAgenda'])) {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));

// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = strftime("%A", strtotime($DataAgenda));

if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

if (empty($_SESSION['PesquisaTerapeuta'])) {
	$PesquisaTerapeuta = NULL;
	$FiltroTerapeuta = NULL;
} else {
	$PesquisaTerapeuta = $_SESSION['PesquisaTerapeuta'];
	$FiltroTerapeuta = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaTerapeuta.'%"';
}

if (empty($_SESSION['id_hora'])) {
	$id_hora = NULL;
	$FiltroHora = NULL;
	$Hora = 'Selecionar';
} else {
	$id_hora = $_SESSION['id_hora'];
	$FiltroHora = 'AND agenda_paciente.id_hora ='.$id_hora;
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
	    }
	} else {
		// não tem
	}
}

// filtrar por unidade
if (empty($_SESSION['id_unidade'])) {
	$id_unidade = NULL;
	$NomeUnidade = 'Todos';
	$FiltroUnidade = NULL;
} else {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
			$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
	    }
	} else {
		// não tem
	}
}

$sql = "SELECT COUNT(agenda_paciente.id_paciente) AS Soma
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroTerapeuta $FiltroHora $FiltroUnidade";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
}

// print_r($_SESSION); 
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
	/*li {
		list-style: none;
	}*/
	.Link {
		background-color: transparent;
		border: none;
	}
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
	.form-group {
		padding-right: 15px;
		padding-bottom: 5px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda</h2>

<ul class="nav nav-tabs">
	<!-- <li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li> -->
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda do dia</a></li>
    <!-- <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li> -->
    <li class="active"><a href="relatorio-agenda-do-dia-ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
	<h3>Agenda do dia</h3>
	<p>Ela mostra a lista dos pacientes agendados no dia e é onde podemos <b>confirmar a sua presença</b>.</p>
	
	<h3>Presença do paciente</h3>
	<p>A seleção dos pacientes poderá ser feito individualemnte ou selecionando todas elas de uma só vez.</p>
	<li>Na seleção individual selecione os campos &#x2610; e clique no botão <b>Realizado</b>.</li>
	<li>Para alteração selecionando todas elas, clique no botão <b>Selecionar todos</b>.</li>
	<li>Para alterar a ação de seleção (por ex. faltou), clique no botão <b>Alterar presença</b> e selecione uma opção.</li>
	<li>Para selecionar todas elas clique no botão <b>Selecionar todos</b> e escolha uma opção. Serão selecionados somente os itens mostrados na página e com o filtro aplicado.</li>
	<b>Importante</b>
	<li>A presença poderá ser alterado somente se a coluna <b>Convênio validado</b> estiver <b>preenchido</b>.</li>
	
	<h3>Como substituir o terapeuta</h3>
	<li>Clique no <b>nome do paciente</b>, abra a <b>agenda do paciente</b> e siga as orientações.</li>
	<h3>Dicas</h3>
	<li>Clique no nome de paciente e veja a agenda do paciente.</li>
	<li>Clique no nome do terapeuta e veja a agenda do terapeuta.</li>
	<li>Para alterar o nº de linhas da lista altere o campo <b>Alterar o nº de pacientes mostrados por página</b>. O nº padrão é 25.</li>
</div>
</div>
</div>
</div>

<!-- alterar status -->
<div class="modal fade" id="AlterarStatus" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="relatorio-agenda-do-dia-filtro-status-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alterar status</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <select class="form-control" name="Status" style="margin-bottom: 15px;">
                    	<option value="">Selecionar</option>
                    	<option value="1">Agendado</option>
                    	<option value="2">Realizado</option>
                    	<option value="3">Faltou</option>
                    	<option value="4">Outros</option>
                    </select>
                    <p>Nota: Alterar o botão de seleção da presença.</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>