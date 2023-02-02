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
$Data = date("d-m-Y", strtotime($DataAtual));

// setlocale(LC_TIME,"pt");
// echo(strftime("%A", strtotime($Data)));
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

            <h3>Criar agenda da semana</h3>
            	<p>Para criar a agenda da semana, selecione uma 2ª feira.</p>
				<div style="margin-bottom: 25px;">
					<form action="criar-agenda-da-semana-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Selecionar data</label>
							<input type="date" class="form-control" name="DayWeek" required>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmar</button>
						</div>
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
