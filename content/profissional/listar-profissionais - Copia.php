<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="">
<div class="">
	<h3>Profissionais</h3>

	<form action="aplicar-filtro-lista-profissionais.php" method="post" class="form-inline">
      	
    	<label>Profissional:</label>
    	<input type="text" name="PesquisaProfissional" class="form-control" value="<?php echo $PesquisaProfissional;?>" placeholder="Nome">

    	<label>Status</label>
    	<select name="StatusProfissional" class="form-control">
    		<option value="<?php echo $StatusProfissional;?>"><?php echo $NomeStatusProfissional;?></option>
    		<option value="1">Ativo</option>
    		<option value="2">Inativo</option>
    		<option value="3">Todos</option>
    	</select>

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
	// $sql = "SELECT * FROM profissional";
	$sql = "SELECT * FROM profissional WHERE Nivel != 3 $FiltroProfissional $FiltroStatus ORDER BY NomeCompleto ASC LIMIT $ItensPorPagina $PageOffset1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th style="width: 200px;">Nome completo</th>';
		echo '<th>Nome social</th>';
		echo '<th>Função</th>';
		echo '<th>Categoria, unidade, período</th>';
		echo '<th>Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
	    	$id_profissional = $row['id_profissional'];
	    	$id_funcao = $row['id_funcao'];
			$NomeCompleto = $row['NomeCompleto'];
			$NomeCurto = $row['NomeCurto'];
			$Status = $row['Status'];

			echo '<tr>';
			echo '<td><a href="profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCompleto.'</a></td>';
			echo '<td>'.$NomeCurto.'</td>';

			// buscar xxx
			$sqlB = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
			$resultB = $conn->query($sqlB);
			if ($resultB->num_rows > 0) {
			    while($rowB = $resultB->fetch_assoc()) {
					$NomeFuncao = $rowB['NomeFuncao'];
			    }
			} else {
				$NomeFuncao = NULL;
			}
			echo '<td>'.$NomeFuncao.'</td>';

			// buscar xxx
			echo '<td>';
			$sqlB = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' $FiltroUnidade ";
			$resultB = $conn->query($sqlB);
			if ($resultB->num_rows > 0) {
			    while($rowB = $resultB->fetch_assoc()) {
					$id_categoria = $rowB['id_categoria'];
					$id_periodo = $rowB['id_periodo'];
					$id_unidade = $rowB['id_unidade'];

					// buscar xxx
					$sqlC = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
					    while($rowC = $resultC->fetch_assoc()) {
							$NomeCategoria = $rowC['NomeCategoria'];
					    }
					} else {
						$NomeCategoria = NULL;
					}

					// buscar xxx
					$sqlC = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
					    while($rowC = $resultC->fetch_assoc()) {
							$NomeUnidade = $rowC['NomeUnidade'];
					    }
					} else {
						$NomeUnidade = NULL;
					}

					// buscar xxx
					$sqlC = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
					    while($rowC = $resultC->fetch_assoc()) {
							$NomePeriodo = $rowC['NomePeriodo'];
					    }
					} else {
						$NomePeriodo = NULL;
					}

					echo $NomeCategoria.' - '.$NomeUnidade.' - '.$NomePeriodo.'<br>';
			    }
			} else {
			}
			echo '</td>';

			echo '<td>';
			echo '<a href="../agenda/agenda-profissional.php?id_profissional='.$id_profissional.'" class="btn btn-default">Ver agenda</a>';
			echo '</td>';

			echo '</tr>';
	    }
	    echo '</tbody>';
	    echo '</table>';
	} else {
		echo 'Não encontramos nenhum profissional.';
	}
	?>
</div>

<div>
    <?php
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
</body>
</html>
