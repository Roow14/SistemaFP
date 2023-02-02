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
$id_paciente = $_SESSION['id_paciente'];
$id_exame = $_GET['id_exame'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
    }
} else {
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
    <li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
    <li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
    <li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
    <li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
    <li class="inactive"><a href="../exame/">Dados médicos</a></li>
    <li class="active"><a href="../exame/">Médicos</a></li>
    <li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">

    <?php
    // buscar xxx
    $sql = "SELECT * FROM medico ORDER BY NomeMedico ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-hover table-condensed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nome</th>';
        echo '<th>CRM</th>';
        echo '<th>Obs., especialidade</th>';
        echo '<th>Status</th>';
        echo '<th>Ação</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = $result->fetch_assoc()) {
            // tem
            $id_medico = $row['id_medico'];
            $NomeMedico = $row['NomeMedico'];
            $Crm = $row['Crm'];
            $Anotacao = $row['Anotacao'];
            $Status = $row['Status'];
            if ($Status == 1) {
                $NomeStatus = 'Ativo';
            } else {
                $NomeStatus = 'Inativo';
            }
            echo '<tr>';
            echo '<td>'.$NomeMedico.'</td>';
            echo '<td>'.$Crm.'</td>';
            echo '<td>'.$Anotacao.'</td>';
            echo '<td>'.$NomeStatus.'</td>';
            echo '<td>';
            echo '<a href="medico.php?id_medico='.$id_medico.'&id_exame='.$id_exame.'" class="btn btn-default">Alterar</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        // não tem
    }
    ?>
</div>


<!-- não apagar -->
<div id="NaoApagar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Apagar dado médico</h4>
            </div>
            <div class="modal-body">
                <p><b>Erro:</b> O dado médico não pode ser apagado porque tem arquivos associados.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>

    </div>
</div>

<!-- apagar -->
<div id="Apagar" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Apagar dado médico</h4>
			</div>
			<div class="modal-body">
				<p>Cuidado! O dado médico será removido do sistema.<br>Deseja continuar?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<a href="apagar-exame-2.php?id_exame=<?php echo $id_exame;?>" class="btn btn-danger">Apagar</a>
			</div>
		</div>

	</div>
</div>

<!-- importar -->
<div class="modal fade" id="Importar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="importar-exame-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline" enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Importar documento</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <label>Selecione:</label>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" hidden name="submit">
                        <input type="text" hidden name="id_exame" value="<?php echo $id_exame;?>">

                    </div>
                    <div style="clear: both;"></div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
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

<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
	ClassicEditor
	    .create( document.querySelector( '#editor' ) )
	    .catch( error => {
	        console.error( error );
	    } )
</script>
</body>
</html>
