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
$id_paciente = $_GET['id_paciente'];

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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

        	<h3>Categorias</h3>
        	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
        	<div style="margin-top: 25px;">
        		<div class="row">
	        		<div class="col-sm-6">
						<?php
						if (empty($_SESSION['AtivarAlteracaoCategoria'])) {

							// buscar xxx
							$sql = "SELECT DISTINCT categoria.* FROM categoria_paciente LEFT JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria WHERE id_paciente = '$id_paciente' ORDER BY categoria.NomeCategoria ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								echo '<table class="table table-striped table-hover table-condensed">';
								echo '<thead>';
								echo '<tr>';
								echo '<th>Categoria</th>';
								echo '<th style="width: 100px;">Ação</th>';
								echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
							    while($row = $result->fetch_assoc()) {
									$id_categoria = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<tr>';
									echo '<td>'.$NomeCategoria.'</td>';
									echo '<td>';

									// verificar se a categoria está sendo utilizada
									$sqlA = "SELECT * FROM sessao_paciente WHERE id_categoria = '$id_categoria' AND id_paciente = '$id_paciente'";
									$resultA = $conn->query($sqlA);
									if ($resultA->num_rows > 0) {
									    while($rowA = $resultA->fetch_assoc()) {
									    	// em uso
									    	echo '<a href="" class="btn btn-default">Em uso</a>';
									    }
									} else {
										// apagar
										echo '<a href="remover-categoria.php?id_categoria='.$id_categoria.'&id_paciente='.$id_paciente.'" class="btn btn-default">Apagar</a>';
									}
									
									echo '</td>';
									echo '</tr>';
							    }
							    echo '</tbody>';
								echo '</table>';
							} else {
								echo 'Não encontramos nenhuma categoria associada ao paciente.';
							}
							?>
							<a href="ativar-alteracao-categoria.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Adicionar categoria</a>
							<?php
						} else {
							?>
							<form action="selecionar-categoria.php?id_paciente=<?php echo $id_paciente;?>" method="post">
								<div class="form-group">
									<label>Adicionar categorias:</label>
									<div>
										<div class="checkbox">
											<?php
											// buscar xxx
											$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
											$result = $conn->query($sql);
											if ($result->num_rows > 0) {
											    while($row = $result->fetch_assoc()) {
													$id_categoria = $row['id_categoria'];
													$NomeCategoria = $row['NomeCategoria'];
													echo '<label><input type="checkbox" name="Categoria[]" value="'.$id_categoria.'">'.$NomeCategoria.'</label><br>';
											    }
											} else {
											}
											?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<a href="ativar-alteracao-categoria.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
									<button type="submit" class="btn btn-success">Confirmar</button>
								</div>
						    </form>
							<?php
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
