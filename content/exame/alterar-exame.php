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
$id_nav = 'exame';

// buscar dados
$sql = "SELECT * FROM fisiofor_agenda.paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
    }
} else {
}

$sql = "SELECT * FROM exame_novo WHERE id_exame = '$id_exame'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$DataExame = $row['DataExame'];
		$TituloExame = $row['TituloExame'];
		$Exame = $row['Exame'];
        $id_medico = $row['id_medico'];

        if (!empty($id_medico)) {
            // buscar xxx
            $sqlA = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
            $resultA = $conn->query($sqlA);
            if ($resultA->num_rows > 0) {
                while($rowA = $resultA->fetch_assoc()) {
                    // tem
                    $NomeMedico = $rowA['NomeMedico'];
                    $Crm = $rowA['Crm'];     
                }
            } else {
                // não tem
            }
        } else {
            $Crm = NULL;
            $id_medico = NULL;
            $NomeMedico = NULL;
        }
    }
} else {
}

$sql = "SELECT * FROM midia_exame WHERE id_exame = '$id_exame' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CheckMidia = 1;
    }
} else {
    $CheckMidia = 2;
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
    <li class="active"><a href="../exame/">Dados médicos</a></li>
    <li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

	<form action="alterar-exame-2.php" method="post" style="margin-bottom: 25px;">
        <input type="text" name="id_exame" value="<?php echo $id_exame;?>" hidden>
		<div class="row">
			<div class="form-group col-sm-3">
				<label>Data</label>
				<input type="date" class="form-control" name="DataExame" value="<?php echo $DataExame;?>" required>
			</div>
            <div class="form-group col-sm-5">
                <label>Título</label>
                <input type="text" class="form-control" name="TituloExame" value="<?php echo $TituloExame;?>" Placeholder="Opcional">
            </div>
            <div class="form-group col-sm-4">
                <label>Médico</label>
                <select class="form-control" name="id_medico" required>
                    <?php
                    if (!empty($id_medico)) {
                        $NomeX = $NomeMedico.' - CRM '.$Crm;
                    } else {
                        $NomeX = 'Selecionar';
                    }
                    echo '<option value="'.$id_medico.'">'.$NomeX.'</option>';
                    
                    // buscar xxx
                    $sql = "SELECT * FROM medico WHERE Status = 1 ORDER BY NomeMedico ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // tem
                            $id_medicoX = $row['id_medico'];
                            $NomeMedicoX = $row['NomeMedico'];
                            $CrmX = $row['Crm'];
                            $AnotacaoX = $row['Anotacao'];
                            echo '<option value="'.$id_medicoX.'">'.$NomeMedicoX.'</option>';
                        }
                    } else {
                        // não tem
                    }
                    ?>
                </select>
            </div>
    		<div class="form-group col-sm-12">
    			<label>Descrição</label>
    			<textarea class="form-control" id="editor" name="Exame"><?php echo $Exame;?></textarea>
    		</div>
            <div class="form-group col-sm-12">
        		<a href="index.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
        		<button type="submit" class="btn btn-success">Confirmar</button>
        		<?php
                if ($CheckMidia == 1) {
                    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#NaoApagar">Apagar</button>';
                } else {
                    echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Apagar">Apagar</button>';
                }
                ?>
        		<a href="" class="btn btn-default" data-toggle="modal" data-target="#Importar">Importar arquivo</a>
                <a href="listar-medicos.php?id_exame=<?php echo $id_exame;?>" class="btn btn-default">Médicos</a>
            </div>
        </div>
	</form>

	<div>
		<label>Arquivos:</label>
		<?php
        // arquivo exame
        $sqlA = "SELECT * FROM midia_exame WHERE id_exame = '$id_exame' ORDER BY ArquivoMidia ASC";
        $resultA = $conn->query($sqlA);
        if ($resultA->num_rows > 0) {
        	echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Nome</th>';
			echo '<th>Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
            while($rowA = $resultA->fetch_assoc()) {
                $id_midia_exame = $rowA['id_midia_exame'];
                $ArquivoMidia = $rowA['ArquivoMidia'];

                echo '<tr>';
				echo '<td><a href="../../vault/exame/'.$id_paciente.'/'.$ArquivoMidia.'" class="Link" target="blank" data-toggle="tooltip" title="Abrir arquivo">'.$ArquivoMidia.' </a></td>';
				echo '<td><a href="apagar-arquivo-exame.php?id_midia_exame='.$id_midia_exame.'&ArquivoMidia='.$ArquivoMidia.'&id_paciente='.$id_paciente.'&id_exame='.$id_exame.'" class="btn btn-default">Apagar</a></td>';
				echo '</tr>';
            }
            echo '</tbody>';
			echo '</table>';
        } else {
        }
        ?>
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
