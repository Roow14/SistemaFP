<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
// import Image from '@ckeditor/ckeditor5-image/src/image';
// import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
// import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption';
// import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle';
// import ImageResize from '@ckeditor/ckeditor5-image/src/imageresize';
// import LinkImage from '@ckeditor/ckeditor5-link/src/linkimage';

// conexão com banco
include '../conexao/conexao.php';

// input
$id_paciente = $_GET['id_paciente'];
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
.box {
	background-color: #fafafa;
	padding: 25px;
	border-radius: 5px;
	margin-bottom: 25px;
}
.box:hover {
	transition: all ease 0.3s;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    cursor: pointer;
}
</style>
    <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

    
            
<div class="">
<div class="">
	<h3>Convênio médico</h3>
	
	<form action="convenio-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline" style="margin-bottom: 15px;">
		<a href="paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default" style="margin-right: 5px;">&lsaquo; Voltar</a>
		<label>Adicionar convênio:</label>
		<select class="form-control" name="id_convenio">
			<option value="">Selecionar</option>
			<?php
			// buscar xxx
			$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1 ORDER BY NomeConvenio ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_convenio = $row['id_convenio'];
					$NomeConvenio = $row['NomeConvenio'];
					echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
			    }
			} else {
			}
			?>
		</select>
		<button type="submit" class="btn btn-success">Confirmar</button>
		<?php 
		if (empty($_SESSION['Alterar'])) {
			echo '<a href="convenio-ativar-alteracao-2.php?id_paciente='.$id_paciente.'" class="btn btn-default">Ativar remoção</a>';
		} else {
			echo '<a href="convenio-ativar-alteracao-2.php?id_paciente='.$id_paciente.'" class="btn btn-default">Cancelar remoção</a>';
		}
		?>
		<a href="" class="btn-icon" data-toggle="modal" data-target="#Adicionar">&#x271B; Convênio</a>
	</form>
	<br>

    <?php
	// buscar xxx
	$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio 
	FROM convenio_paciente
	INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
	WHERE convenio_paciente.id_paciente = '$id_paciente' ORDER BY convenio.NomeConvenio ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<div class="row">';
	    while($row = $result->fetch_assoc()) {
			$id_convenio_paciente = $row['id_convenio_paciente'];
			$id_convenio = $row['id_convenio'];
			$NumeroConvenio = $row['NumeroConvenio'];
			$NotaConvenioPaciente = $row['NotaConvenioPaciente'];
			$StatusConvenio = $row['StatusConvenio'];
			if ($StatusConvenio == 1) {
				$NomeStatusConvenio = 'Ativo';
			} else {
				$NomeStatusConvenio = 'Inativo';
			}

			// buscar xxx
			$sqlA = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeConvenio = $rowA['NomeConvenio'];
			    }
			} else {
			}
			?>
			<div class="col-sm-6">
				<div class="box">
					<form action="convenio-alteracao-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">
						<input type="text" name="id_convenio_paciente" hidden value="<?php echo $id_convenio_paciente;?>">

						<div class="form-group">
							<label>Convênio:</label>
							<input type="text" class="form-control" disabled placeholder="<?php echo $NomeConvenio;?>">
						</div>

						<div class="form-group">
							<label>Número:</label>
							<input type="text" class="form-control" name="NumeroConvenio" value="<?php echo $NumeroConvenio;?>">
						</div>

						<div class="form-group">
							<label>Status:</label>
							<select class="form-control" name="StatusConvenio">
								<option value="<?php echo $StatusConvenio;?>"><?php echo $NomeStatusConvenio;?></option>
								<option value="1">Ativo</option>
								<option value="2">Inativo</option>
							</select>
						</div>

						<div class="form-group">
							<label>Observação:</label>
							<textarea id="editor" rows="5" name="NotaConvenioPaciente" class="form-control"><?php echo $NotaConvenioPaciente;?></textarea>
						</div>


						<div class="form-group">
							<button type="submit" class="btn btn-warning" style="margin-right: 5px;">Alterar</button>
							<?php 
							if (empty($_SESSION['Alterar'])) {

							} else {
								echo '<a href="convenio-remocao-2.php?id_paciente='.$id_paciente.'&id_convenio_paciente='.$id_convenio_paciente.'" class="btn btn-danger">Remover</a>';
							}
							?>
						</div>
					</form>
				</div>
			</div>
			<?php
	    }
	    echo '</div>';
	} else {
		echo 'Não encontramos nenhum convênio associado ao cliente.';
	}
	?>
</div>
</div>
		    </div>
         </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal-Ajuda" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Dicas</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <p>aaa</p>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

</body>
</html>
