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
	.Link {
		background-color: transparent;
		border: none;
	}
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="active"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
<a href="convenio-paciente.php" class="btn btn-default">Fechar</a>
<a href="" class="btn btn-default" data-toggle="modal" data-target="#cadastrarconvenio">Cadastrar convênio</a>

<?php
// buscar xxx
$sql = "SELECT * FROM convenio ORDER BY NomeConvenio ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Observação</th>';
	echo '<th>Status</th>';
	echo '<th>Ação</th>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio = $row['id_convenio'];
		$NomeConvenio = $row['NomeConvenio'];
		$Nota = $row['Nota'];
		$StatusConvenio = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = '(nativo';
		}

		echo '<tr>';
		echo '<td>'.$id_convenio.'</td>';
		echo '<td>'.$NomeConvenio.'</td>'; 
		echo '<td>'.$Nota.'</td>';
		echo '<td>'.$NomeStatus.'</td>';

		echo '<td>';
		echo '<a href="convenio.php?id_convenio='.$id_convenio.'" class="btn btn-default">Ver</a>';
		echo '</td>';

		echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
	// não tem
	echo '<div style="margin: 25px 0">';
	echo '<b>Nota:</b> Não foi encontrado nenhum convênio.';
	echo '</div>';
}
?>
</div>
			</div>
    </div>
</div>

<!-- alterar status -->
<div class="modal fade" id="cadastrarconvenio" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="cadastrar-convenio-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cadastrar convênio</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                	<div class="form-group">
	                	<label>Nome</label>
	                    <input type="text" name="NomeConvenio" class="form-control" required>
	                </div>
	                <div class="form-group">
	                	<label>Observação</label>
	                    <textarea rows="3" class="form-control" name="Nota"></textarea>
	                </div>
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