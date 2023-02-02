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
$DataAtualBr = date("d/m/Y", strtotime($DataAtual));

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}

// verificar se o input dia é segunda
include 'verificar-dia-semana.php';

// terça
$date = date_create($DataAgenda);
$Segunda = date_format($date,"Y-m-d");
$SegundaBr = date("d/m/Y", strtotime($Segunda));

// terça
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("1 day"));
$Terca = date_format($date,"Y-m-d");
$TercaBr = date("d/m/Y", strtotime($Terca));

// quarta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("2 day"));
$Quarta = date_format($date,"Y-m-d");
$QuartaBr = date("d/m/Y", strtotime($Quarta));

// quinta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("3 day"));
$Quinta = date_format($date,"Y-m-d");
$QuintaBr = date("d/m/Y", strtotime($Quinta));

// sexta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("4 day"));
$Sexta = date_format($date,"Y-m-d");
$SextaBr = date("d/m/Y", strtotime($Sexta));

// input
if (empty($_GET['id_profissional'])) {
	// não tem
	$id_profissional = NULL;
	$NomeProfissional = 'Selecionar profissional';
	$FiltroPeriodo = NULL;
} else {
	$id_profissional = $_GET['id_profissional'];
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeCompleto'];
	    }
	} else {
		// não tem
	}
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.largura-col {
		width: 20%;
	}
	.largura-col span {
		font-weight: 300;
		font-size: 16px;
	}
	.link-apagar {
		color: orange;
	}
	.link-apagar:hover {
		color: red;
	}
</style>
<style type="text/css">
    body {
        background: rgba(0, 255, 0, 0.2);
    }
</style>
<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<h3>Agenda do profissional</h3>
			<div>

				<!-- cadastro do profissional -->
				<div style="margin-bottom: 15px;">
					<form action="agenda-profissional-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome</label>
							<select class="form-control" name="id_profissionalX" required>
								<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_profissionalX = $row['id_profissional'];
										$NomeProfissional = $row['NomeCompleto'];
										echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
								    }
								} else {
									// não tem
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmar</button>
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
