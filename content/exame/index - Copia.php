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
	.LinkTitulo i, li i, p i {
        vertical-align: middle;
    }
    .LinkTitulo:hover {
        cursor: pointer;
        color: orange;
    }
    .txt {
        display: none;
        margin-bottom: 50px;
        padding-left: 15px;
        padding-right: 15px; 
    
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
    <li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
    <li class="active"><a href="../exame/">Dados médicos</a></li>
    <li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
    <div style="margin-bottom: 15px;">
        <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
        <?php
        if (!empty($_GET['Origem'])) {
            $Origem = $_GET['Origem'];
            echo '<a href="'.$Origem.'" class="btn btn-default">Voltar para FP+</a>';
        } else {

        }
        ?>
        <a href="" class="btn btn-default" data-toggle="modal" data-target="#Cadastrar"><span data-toggle="tooltip" title="Cadastrar avaliação">Cadastrar dados médicos</span></a>
        <a href="" class="btn btn-default" data-toggle="modal" data-target="#Importar">Importar documento</a>
    </div>
    <div class="row">
        <div class="col-sm-8">                	
        	<?php
        	// buscar xxx
        	$sql = "SELECT * FROM exame_novo WHERE id_paciente = '$id_paciente' ORDER BY DataExame DESC";
        	$result = $conn->query($sql);
        	if ($result->num_rows > 0) {
        	    while($row = $result->fetch_assoc()) {
        			$id_exame = $row['id_exame'];
        			$DataExame = $row['DataExame'];
        			$DataExame1 = date("d/m/Y", strtotime($DataExame));
        			$TituloExame = $row['TituloExame'];
        			$Exame = $row['Exame'];
        			?>
        			<div id="<?php echo $id_exame;?>" style="margin-bottom: 25px;">
        			<label>Titulo:</label> <?php echo $TituloExame;?><br>
        			<label>Data:</label> <?php echo $DataExame1;?><br>
        			<label>Observação:</label> <?php echo $Exame;?><br>
        			<a href="alterar-exame.php?id_paciente=<?php echo $id_paciente;?>&id_exame=<?php echo $id_exame;?>" class="btn btn-default" data-toggle="tooltip" title="Alterar">&#x270E;</a>
        			</div>
        			<?php
        	    }
        	} else {
                echo 'Não foi encontrado nenhum dado médico.';
        	}
        	?>
        </div>

        <div class="col-sm-4 ">
            
            <div class="">
                <?php
                // buscar xxx
                // id_tipo ver tabela midia_tipo
                $sql = "SELECT * FROM midia WHERE id_paciente = '$id_paciente' AND Vault = 2 ORDER BY ArquivoMidia ASC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<table class="table table-striped table-hover table-condensed">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Arquivos</th>';
                    echo '<th>Ação</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while($row = $result->fetch_assoc()) {
                        $id_midia = $row['id_midia'];
                        $ArquivoMidia = $row['ArquivoMidia'];
                        $DataMidia = $row['DataMidia'];
                        $TituloMidia = $row['TituloMidia'];
                        $NotaMidia = $row['NotaMidia'];

                        echo '<tr>';
                        echo '<td><a href="../../vault/exame/'.$ArquivoMidia.'" class="Link" target="blank" data-toggle="tooltip" title="Abrir arquivo">'.$ArquivoMidia.'</a></td>';
                        echo '<td style="width: 50px;"><a href="apagar-arquivo-exame.php?id_midia='.$id_midia.'&ArquivoMidia='.$ArquivoMidia.'&id_paciente='.$id_paciente.'" class="btn btn-default" data-toggle="tooltip" title="Apagar">&#x2715;</a></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<label>Documentos digitalizados:</label><br>';
                    echo 'Não foi encontrado nenhum documento.';
                }
                ?>
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
                        <input type="text" hidden name="id_paciente" value="<?php echo $id_paciente;?>">

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

<!-- cadastrar -->
<div class="modal fade" id="Cadastrar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-exame.php?id_paciente=<?php echo $id_paciente;?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cadastrar dados médicos</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" name="TituloExame" required>
                    </div>
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" class="form-control" name="DataExame" required>
                    </div>
                    <div class="form-group">
                        <label>Observação</label>
                        <textarea rows="10" class="form-control" name="Exame"></textarea>
                    </div>
                    <p>Nota: Digite no final do parágrafo &lsaquo;br&rsaquo; para ir para o próximo parágrafo.</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
