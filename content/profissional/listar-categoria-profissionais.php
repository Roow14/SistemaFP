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

if (empty($_SESSION['id_categoria'])) {
	$id_categoriaX = NULL;
	$FiltroCategoria = NULL;
	$NomeCategoriaX = 'Selecionar';
} else {
	$id_categoriaX = $_SESSION['id_categoria'];
	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeCategoriaX = $row['NomeCategoria'];
	    }
	} else {
		$NomeCategoriaX = NULL;
	}
	$FiltroCategoria = 'AND categoria_profissional.id_categoria = '. $id_categoriaX;
}

$sql = "SELECT COUNT(categoria_profissional.id_profissional) AS Soma FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional INNER JOIN categoria ON categoria.id_categoria = categoria_profissional.id_categoria WHERE profissional.Status = 1 $FiltroCategoria $FiltroProfissional ORDER BY profissional.NomeCompleto ASC ";

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
        	<h3>Associar categoria ao profissional</h3>
			<form action="listar-categoria-profissionais-filtro.php" method="post" class="form-inline">
				<label>Profissional:</label>
				<input type="text" name="PesquisaProfissional" class="form-control" value="<?php echo $PesquisaProfissional;?>" placeholder="Nome">

				<label>Categoria:</label>
				<select name="id_categoriaX" class="form-control">
					<option value="<?php echo $id_categoriaX;?>"><?php echo $NomeCategoriaX;?></option>
					<?php
					$sqlA = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$id_categoriaX = $rowA['id_categoria'];
							$NomeCategoriaX = $rowA['NomeCategoria'];
							echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
					    }
					} else {
						// não tem
						$NomeCategoriaX = NULL;
					}
					?>
					<option value="Limpar">Limpar filtro</option>
				</select>
				<button type="submit" class="btn btn-success">Confirmar</button>
				<a href="" class="btn btn-default" data-toggle="modal" data-target="#Adicionar-categoria"><span data-toggle="tooltip" title="Adicionar categoria">Adicionar</span></a>
				<a href="listar-categoria-profissionais-limpar-filtro.php" class="btn btn-default">Limpar filtro</a>
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
			echo '<a href="listar-categoria-profissionais-paginacao.php?Page=3" class="btn btn-default">&lsaquo;&lsaquo;</a>';
			echo '<a href="listar-categoria-profissionais-paginacao.php?Page=1&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">&lsaquo; Anterior</a>';
			echo '<a href="listar-categoria-profissionais-paginacao.php?Page=2&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">Próximo &rsaquo;</a>';
			echo '</div>';
			?>

			<div class="row">
<div class="col-lg-12">


<?php
// buscar xxx
$sql = "SELECT profissional.*, categoria_profissional.*, categoria.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional INNER JOIN categoria ON categoria.id_categoria = categoria_profissional.id_categoria WHERE profissional.Status = 1 $FiltroCategoria $FiltroProfissional ORDER BY profissional.NomeCompleto ASC LIMIT $ItensPorPagina $PageOffset1 ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Categoria</th>';
	echo '<th>Unidade</th>';
	echo '<th>Período</th>';
	echo '<th style="width:130px;">Ação</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		$id_profissional = $row['id_profissional'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$id_periodo = $row['id_periodo'];
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCategoria = $row['NomeCategoria'];

		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeUnidade = $rowA['NomeUnidade'];
		    }
		} else {
			// não tem
			$NomeUnidade = NULL;
		}
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			// não tem
			$NomePeriodo = NULL;
		}
		echo '<tr>';
		echo '<form action="listar-categoria-profissionais-alterar-categoria.php?id_categoria_profissional='.$id_categoria_profissional.'&id_profissional='.$id_profissional.'" method="post">';
		echo '<td>'.$NomeCompleto.'</td>';
		echo '<td>';
		echo '<select class="form-control" name="id_categoriaY">';
			echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
			// buscar xxx
			$sqlA = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoriaY = $rowA['id_categoria'];
					$NomeCategoriaY = $rowA['NomeCategoria'];
					echo '<option value="'.$id_categoriaY.'">'.$NomeCategoriaY.'</option>';
			    }
			} else {
				// não tem
			}
		echo '</select>';
		echo '</td>';

		echo '<td>';
		echo '<select class="form-control" name="id_unidadeY">';
			echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
			// buscar xxx
			$sqlA = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_unidadeY = $rowA['id_unidade'];
					$NomeUnidadeY = $rowA['NomeUnidade'];
					echo '<option value="'.$id_unidadeY.'">'.$NomeUnidadeY.'</option>';
			    }
			} else {
				// não tem
			}
		echo '</select>';
		echo '</td>';

		echo '<td>';
		echo '<select class="form-control" name="id_periodoY">';
			echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
			// buscar xxx
			$sqlA = "SELECT * FROM periodo ORDER BY NomePeriodo ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_periodoY = $rowA['id_periodo'];
					$NomePeriodoY = $rowA['NomePeriodo'];
					echo '<option value="'.$id_periodoY.'">'.$NomePeriodoY.'</option>';
			    }
			} else {
				// não tem
			}
		echo '</select>';
		echo '</td>';

		echo '<td>';
		echo '<button type="submit" class="btn btn-default" data-toggle="tooltip" title="Confirmar alteração">&#x270E;</button>';
		echo '<a href="listar-categoria-profissionais-duplicar.php?id_categoria_profissional='.$id_categoria_profissional.'" class="btn btn-default" data-toggle="tooltip" title="Duplicar categoria associada ao profissional">&#x271B;</a>';
		echo '<a href="listar-categoria-profissionais-apagar.php?id_categoria_profissional='.$id_categoria_profissional.'" class="btn btn-default" data-toggle="tooltip" title="Apagar a categoria associada ao profissional">&#x2715;</a>';
		echo '</td>';
		echo '</form>';
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
	echo '<br>';
	echo 'Não foi encontrado nenhum profissional.';
}
?>
</div>
<div class="col-lg-12">
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
    <form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=../profissional/listar-categoria-profissionais.php" method="post" class="form-inline">
        <input type="number" name="Valor" class="form-control" value="<?php echo $Valor;?>">
        <button type="submit" class="btn btn-success">Confirmar</button>
    </form>
</div>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Adicionar-categoria" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="listar-categoria-profissionais-adicionar-categoria.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar categoria ao profissional</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
              		<div class="form-group">
						<label>Profissional:</label>
						<select class="form-control" name="id_profissional">
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissional = $row['id_profissional'];
									$NomeCompleto = $row['NomeCompleto'];
									echo '<option value="'.$id_profissional.'">'.$NomeCompleto.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoria">
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_categoria = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Unidade:</label>
						<select class="form-control" name="id_unidade">
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_unidade = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Período:</label>
						<select class="form-control" name="id_periodo">
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM periodo ORDER BY NomePeriodo ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_periodo = $row['id_periodo'];
									$NomePeriodo = $row['NomePeriodo'];
									echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
                </div>
                
                <div class="modal-footer">
                	<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
</body>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</html>
