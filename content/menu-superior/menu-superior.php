<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }
    $UsuarioNome = $_SESSION['UsuarioNome'];

    // print_r($_SESSION);
?>

<style type="text/css">
	.titulo-menu-superior {
		font-size: 18px;
		vertical-align: middle;
		margin-left: 15px;

	}
	.navbar {
		padding: 0 10px;
        background: rgba(0,0,0,0.3);
        box-shadow: 0px 1px 1px  orange;
	}
	.dropdown-toggle {
		background-color: transparent;
		border: none;
		margin-top: 12px;
	    color: #ffffff;
	}
	.dropdown-menu {
		text-decoration: none;
		border-radius: 0;
		width: 250px;


	}
	.navbar-header button {
		text-decoration: none;
		border: none;
		background-color: transparent;
		margin-top: 6px;
		font-size: 26px;
        color: #000000;
	}
	.navbar-header button img {
		width: 62px;
        color: #0d8bf2;
	}
</style>	

<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header" style="float: left;">
		    <button type="" id="sidebarCollapse" class="">&#x2630;</button>
		    <span class="titulo-menu-superior"></span>
		</div>

		<div class="dropdown" style="float: right; background-color: ">
			<button class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="material-icons">account_circle</i>
			<span class="caret"></span></button>
			<ul class="dropdown-menu dropdown-menu-right" style="">
				<li><a href="#">Usuário: <?php echo $UsuarioNome;?></a></li>
				<li><a href="../conexao/logout.php">Sair</a></li>
			</ul>
		</div>
    </div>
</nav>