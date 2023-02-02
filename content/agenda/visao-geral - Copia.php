<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}

// filtro por categoria
if (empty($_SESSION['id_categoria'])) {
	$id_categoriaX = NULL;
	$NomeCategoriaX = 'Selecionar';
	$FiltroCategoria = NULL;
} else {
	$id_categoriaX = $_SESSION['id_categoria'];
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoriaX = $row['NomeCategoria'];
	    }
	} else {
	}
	$FiltroCategoria = 'WHERE id_categoria = '.$id_categoriaX;
}

if (empty($_SESSION['id_periodo'])) {
	$id_periodoX = NULL;
    $NomePeriodoX = 'Selecionar';
    $FiltroPeriodo = NULL;

} else {
    $id_periodoX = $_SESSION['id_periodo'];
	// buscar xxx
	$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodoX'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_periodo = $row['id_periodo'];
			$NomePeriodoX = $row['NomePeriodo'];
			$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
	    }
	} else {
		$id_periodoX = NULL;
		$NomePeriodoX = 'Selecionar';
		$FiltroPeriodo = NULL;
	}
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
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <h3>Agenda</h3>
            <div style="position: relative; float: left; margin-right: 25px;">
	            <form action="aplicar-filtro-data.php" method="post" class="form-inline">
	            	<label>Data</label>
					<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
					<a href="agendar-data-anterior-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">&lsaquo; Anterior</a>
					<a href="agendar-data-proxima-1.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">Próxima &rsaquo;</a>
					<button class="btn btn-success">Confirmar</button>
	            </form>
			</div>
			<div style=" float: left;">
	            <form action="aplicar-filtro-categoria-profissional.php" method="post" class="form-inline">
	            	<label>Aplicar filtro por categoria:</label>
	            	<select class="form-control" name="id_categoriaX">
	            		<?php
						// buscar xxx
						$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
						    while($row = $result->fetch_assoc()) {
								$id_categoriaX = $row['id_categoria'];
								$NomeCategoriaX = $row['NomeCategoria'];
								echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
						    }
							echo '<option value="">Limpar filtro</option>';
						} else {
						}
						?>
	            	</select>

	            	<div class="form-group" style="margin-bottom: 5px;">
						<label>Período</label>
						<select class="form-control" name="id_periodo">
							<option value="<?php echo $id_periodoX;?>"><?php echo $NomePeriodoX;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM periodo ORDER BY Periodo ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_periodo = $row['id_periodo'];
									$NomePeriodo = $row['NomePeriodo'];
									echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
							    }
							} else {
							}
							?>
							<option value="">Todos</option>
						</select>
					</div>

	            	<button type="submit" class="btn btn-success">Confirmar</button>
	            </form>
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
