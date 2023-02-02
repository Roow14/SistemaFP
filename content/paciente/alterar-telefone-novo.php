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

// input 
$id_paciente = $_SESSION['id_paciente'];
$id_telefone_paciente = $_GET['id_telefone_paciente'];

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
	// não tem
}

// buscar xxx
$sql = "SELECT * FROM telefone_paciente WHERE id_telefone_paciente = '$id_telefone_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NumeroTel = $row['NumeroTel'];
		$ClasseTel = $row['ClasseTel'];
		$NotaTel = $row['NotaTel'];
		if ($ClasseTel == 1) {
			$NomeClasseTel = 'Fixo';
		} else {
			$NomeClasseTel = 'Celular';
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="active"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
	<p><label>Nome:</label> <?php echo $NomeCompleto;?></p>
	<div class="">
		<form action="alterar-telefone-paciente-novo-2.php?id_telefone_paciente=<?php echo $id_telefone_paciente;?>" method="post" class="form-inline">
	        <div class="form-group">
                <label>Nº:</label>
            	<input type="text" class="form-control" name="NumeroTel" value="<?php echo $NumeroTel;?>" placeholder="Obrigatório" required>
            </div>
            <div class="form-group">
                <label>Classe:</label>
                <select class="form-control" name="ClasseTel" required>
                	<option class="<?php echo $ClasseTel;?>"><?php echo $NomeClasseTel;?></option>
                	<option class="1">Fixo</option>
                	<option class="2">Celular</option>
                </select>
            </div>
            <div class="form-group">
                <label>Observação:</label>
            	<input type="text" class="form-control" name="NotaTel" value="<?php echo $NotaTel;?>" placeholder="" >
            </div>
            <button class="btn btn-success">Alterar</button>
            <a href="alterar-paciente-novo.php" class="btn btn-default">Fechar</a>
	    </form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="telefone" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-telefone-paciente-novo-2.php" method="post" class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar telefone</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
		                <label class="control-label col-sm-3">Número:</label>
		                <div class="col-sm-9">
		                	<input type="text" class="form-control" name="NumeroTel" required>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="control-label col-sm-3">Classe:</label>
		                <div class="col-sm-9">
		                	<select class="form-control" name="ClasseTel" required>
								<option value="">Selecionar</option>
								<option value="1">Telefone</option>
								<option value="2">Celular</option>
							</select>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="control-label col-sm-3">Observação:</label>
		                <div class="col-sm-9">
		                	<textarea rows="3" class="form-control" name="NotaTel" placeholder="Pai, mãe, avó" required></textarea>
		                </div>
		            </div>
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
        } );
</script>
</body>
</html>