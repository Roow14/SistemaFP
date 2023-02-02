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
h3 {
    margin-top: 0px;
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
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li> -->
    <li class="active"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <!-- <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
    <li class="inactive"><a href="ajuda.php">Ajuda</a></li> -->
</ul>

<div class="janela col-sm-12">

<div class="row">

<div class="col-sm-6">
    <h3>Criação da agenda</h3>
    <p>A agenda do dia será criada a partir da agenda base.</p>
    <p>Antes de selecionar uma data para criação, verifique se a data está disponível, sem agenda.</p>
    <form action="criar-agenda-do-dia-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
        <div class="form-group">
            <label>Selecionar data</label>
            <input type="date" class="form-control" name="Dia" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Confirmar</button>
        </div>
    </form>
    <!-- <p>Para criar a agenda da semana, selecione uma 2ª feira.</p>
	<form action="criar-agenda-da-semana-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
		<div class="form-group">
			<label>Selecionar data</label>
			<input type="date" class="form-control" name="DayWeek" required>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-success">Confirmar</button>
		</div>
	</form> -->
</div>
<div class="col-sm-6">
    <?php
    // buscar xxx
    $sql = "SELECT DISTINCT agenda_paciente.Data FROM agenda_paciente ORDER BY Data DESC LIMIT 10";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo 'Veja as datas mais recentes com agenda cadastrada:<br>';
        echo '<table class="table table-striped table-hover table-condensed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Data</th>';
        echo '<th>Ação</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = $result->fetch_assoc()) {
            // tem
            $Data = $row['Data'];
            $DataX = date("d/m/Y", strtotime($Data));
            // dia da semana
            setlocale(LC_TIME,"pt");
            $DiaSemana = (strftime("%a", strtotime($Data)));

            echo '<tr>';
            echo '<td>'.$DataX.' - '.$DiaSemana.'</td>';
            echo '<td>
            <form action="relatorio-agenda-do-dia.php" method="post">
                <input type="text" hidden name="DataAgenda" value="'.$Data.'">
                <button type="submit" class="btn btn-default">Abrir</button>
            </form>
            </td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        // não tem
        echo 'Não foi encontrado nenhuma agenda';
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