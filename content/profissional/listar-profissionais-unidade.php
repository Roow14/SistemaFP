<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// filtro por profissional
if (empty($_SESSION['PesquisaProfissional'])) {
	$PesquisaProfissional = NULL;
	$FiltroProfissional = NULL;
} else {
	$PesquisaProfissional = $_SESSION['PesquisaProfissional'];
	$FiltroProfissional = 'AND (NomeCompleto LIKE "%'.$PesquisaProfissional.'%" OR NomeCurto LIKE "%'.$PesquisaProfissional.'%")';
}

if (empty($_SESSION['StatusProfissional'])) {
	$StatusProfissional = NULL;
	$FiltroStatus = 'AND Status = 1';
	$NomeStatusProfissional = 'Ativo';
} else {
	$StatusProfissional = $_SESSION['StatusProfissional'];
	if ($StatusProfissional == 1) {
		$NomeStatusProfissional = 'Ativo';
		$FiltroStatus = 'AND Status = '. $StatusProfissional;
	} elseif ($StatusProfissional == 3) {
		$NomeStatusProfissional = 'Ativos e inativos';
		$FiltroStatus = NULL;
	} else {
		$NomeStatusProfissional = 'Inativo';
		$FiltroStatus = 'AND Status = '. $StatusProfissional;
	}
}

if (empty($_SESSION['id_unidade'])) {
	$id_unidade = NULL;
	$FiltroUnidade = NULL;
	$NomeUnidade = 'Selecionar';
} else {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		$NomeUnidade = NULL;
	}
	$FiltroUnidade = 'AND categoria_profissional.id_unidade = '. $id_unidade;
}

$sql = "SELECT COUNT(id_profissional) AS Soma FROM profissional WHERE Nivel != 3 $FiltroProfissional $FiltroStatus";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
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
	.conteudo {

	}
	li {
		list-style: none;
	}
	.Link {
		background-color: transparent;
		border: none;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Terapeutas</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="inactive"><a href="../profissional/listar-profissionais-unidade.php">Por Unidade</a></li>
</ul>

<div class="janela">
	<form action="aplicar-filtro-lista-profissionais.php" method="post" class="form-inline">
      	<div class="form-group">
	    	<label>Profissional:</label>
	    	<input type="text" name="PesquisaProfissional" class="form-control" value="<?php echo $PesquisaProfissional;?>" placeholder="Nome">
	    </div>

	    <div class="form-group">
	    	<label>Unidade:</label>
	    	<select name="id_unidade" class="form-control">
		    	<?php
		    	echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
				// buscar xxx
				$sql = "SELECT * FROM unidade WHERE Status = 1 ORDER BY NomeUnidade";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_unidadeX = $row['id_unidade'];
						$NomeUnidadeX = $row['NomeUnidade'];
						echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
				    }
				} else {
					// não tem
				}
				echo '<option value="">Limpar</option>';
				?>
			</select>
	    </div>

	    <div class="form-group">
	    	<label>Status</label>
	    	<select name="StatusProfissional" class="form-control">
	    		<option value="<?php echo $StatusProfissional;?>"><?php echo $NomeStatusProfissional;?></option>
	    		<option value="1">Ativo</option>
	    		<option value="2">Inativo</option>
	    		<option value="3">Todos</option>
	    	</select>
	    </div>

    	<button type="submit" class="btn btn-success">Confirmar</button>
    </form>

	<?php
	if ((empty($_SESSION['PageOffset']))) {
	    $PageOffset = NULL;
	    $PageOffset1 = NULL;
	} else {
	    $PageOffset = $_SESSION['PageOffset'];
	    $PageOffset1 = 'OFFSET '.$PageOffset;
	}

	// buscar xxx
	$id_usuario = $_SESSION['UsuarioID'];
	$sql = "SELECT * FROM configuracao WHERE Variavel = 'ItensPorPagina' AND id_usuario = '$id_usuario'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        // tem
	        $ItensPorPagina = $row['Valor'];
	    }
	} else {
	    // não tem
	    $ItensPorPagina = 10;
	}

	$TotalPaginas = round($Soma / $ItensPorPagina) + 1;
	$NumeroPagina = ($PageOffset / $ItensPorPagina) + 1;

	echo '<p style="margin-top: 15px;"><span style="margin-right: 15px;"><label>Total:</label> '.$Soma.'</span><label>Página:</label> '.$NumeroPagina.'/'.$TotalPaginas.'</p>';

	echo '<div id="Paginacao">';
	echo '<a href="listar-profissionais-paginacao.php?Page=3" class="btn btn-default">&lsaquo;&lsaquo;</a>';
	echo '<a href="listar-profissionais-paginacao.php?Page=1&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">&lsaquo; Anterior</a>';
	echo '<a href="listar-profissionais-paginacao.php?Page=2&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">Próximo &rsaquo;</a>';
	echo '</div>';

	// buscar dados
	// buscar xxx
	$sql = "SELECT profissional.* FROM profissional
	INNER JOIN categoria_profissional ON categoria_profissional.id_profissional = profissional.id_profissional
	ORDER BY profissional.NomeCompleto ASC ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCompleto = $row['NomeCompleto'];
			echo $NomeCompleto.'<br>';
	    }
	} else {
		// não tem
	}

	echo '<hr>';

    // configurar nº de itens por página
    // buscar xxx
    $sql = "SELECT * FROM configuracao WHERE Variavel = 'ItensPorPagina' AND id_usuario = '$id_usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // tem
            $Valor = $row['Valor'];
        }
    } else {
        // não tem
    }
    ?>
    <p>Alterar o nº de profissionais mostrados por página.</p>
    <form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=../profissional/listar-profissionais.php" method="post" class="form-inline">
        <input type="number" name="Valor" class="form-control" value="<?php echo $Valor;?>" style="margin-bottom: 5px;">
        <button type="submit" class="btn btn-success">Confirmar</button>
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

<!-- mantem a posição após o reload -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>

</body>
</html>
