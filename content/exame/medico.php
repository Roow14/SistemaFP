<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_paciente = $_SESSION['id_paciente'];
$id_medico = $_GET['id_medico'];
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

// buscar xxx
$sql = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $NomeMedico = $row['NomeMedico'];
        $Crm = $row['Crm'];
        $Anotacao = $row['Anotacao'];
        $Status = $row['Status'];
        if ($Status == 1) {
            $NomeStatus = 'Ativo';
        } else {
            $NomeStatus = 'Inativo';
        }
    }
} else {
    // não tem
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
    <div class="row">
        <form action="alterar-medico-2.php" method="post">
            <input type="text" name="id_medico" value="<?php echo $id_medico;?>" hidden>
            <input type="text" name="id_exame" value="<?php echo $id_exame;?>" hidden>
            <div class="form-group col-sm-8">
                <label>Nome</label>
                <input type="text" name="NomeMedico" class="form-control" value="<?php echo $NomeMedico;?>">
            </div>
            <div class="form-group col-sm-4">
                <label>CRM</label>
                <input type="text" name="Crm" class="form-control" value="<?php echo $Crm;?>">
            </div>
            <div class="form-group col-sm-12">
                <label>Obs., especialidade</label>
                <textarea class="form-control" id="editor" name="Anotacao"><?php echo $Anotacao;?></textarea>
            </div>
            <div class="form-group col-sm-12">
                <a href="listar-medicos.php?id_exame=<?php echo $id_exame;?>" class="btn btn-default">Voltar</a>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </div>
        </form>
    </div>
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
