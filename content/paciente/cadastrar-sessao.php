<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

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

            <h3>Cadastrar sessão</h3>
            <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
            <div class="row" style="margin-top: 25px;">
            	<div class="col-lg-6">
	            	<form action="cadastrar-sessao-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2">Categoria:</label>
							<div class="col-sm-10">
								<select class="form-control" name="id_categoria" required>
									<option value="">Selecionar</option>
									<?php
									// buscar xxx
									$sql = "SELECT categoria.* FROM categoria_paciente INNER JOIN categoria ON categoria.id_categoria = categoria_paciente.id_categoria WHERE categoria_paciente.id_paciente = '$id_paciente' ORDER BY categoria.NomeCategoria ASC";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
											$id_categoria = $row['id_categoria'];
											$NomeCategoria = $row['NomeCategoria'];
											echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
									    }
									} else {
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Nº de sessões:</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" name="SessaoInicial" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Qtde de horas:</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" name="HorasInicial">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"></label>
							<div class="col-sm-10">
								<a href="listar-sessoes.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</div>
					</form>
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
