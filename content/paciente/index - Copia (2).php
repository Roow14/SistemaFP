<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

$Origem = '../paciente/index.php';
unset($_SESSION['id_paciente']);
unset($_SESSION['id_profissinal']);

// filtro
if (empty($_SESSION['StatusPaciente'])) {
	$StatusPaciente = NULL;
	$FiltroStatus = 'WHERE Status = 1';
	$NomeStatusPaciente = 'Ativo';
} else {
	$StatusPaciente = $_SESSION['StatusPaciente'];
	if ($StatusPaciente == 1) {
		$NomeStatusPaciente = 'Ativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	} elseif ($StatusPaciente == 3) {
		$NomeStatusPaciente = 'Ativos e inativos';
		$FiltroStatus = 'WHERE Status = 1 OR Status = 2';
		$NomeStatusPaciente = 'Inativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	}
}

// filtro por paciente
if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND (NomeCompleto LIKE "%'.$PesquisaPaciente.'%" OR id_paciente LIKE "%'.$PesquisaPaciente.'%")';
}

$sql = "SELECT COUNT(id_paciente) AS Soma FROM paciente $FiltroStatus $FiltroPaciente ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = 0;
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
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="index.php">Lista</a></li>
	<!-- <li class="inactive"><a href="paciente.php">Paciente</a></li> -->
</ul>

<div class="janela">
	<a href="cadastrar-paciente-novo.php" class="btn btn-default" style="float: right;">Cadastrar paciente</a>
<form action="aplicar-filtro-lista-pacientes-2.php" method="post" class="form-inline">     	
	<label>Paciente:</label>
	<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">
	
	<label>Status</label>
	<select name="StatusPaciente" class="form-control">
		<option value="<?php echo $StatusPaciente;?>"><?php echo $NomeStatusPaciente;?></option>
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
?>

<div style="margin-top: 5px;">
<label>Total:</label> <?php echo $Soma;?><span style="margin-right: 15px;"></span><label>Página:</label> <?php echo $NumeroPagina;?>/<?php echo $TotalPaginas;?><span style="margin-right: 15px;"></span>
<a href="../configuracao/listar-pacientes-paginacao.php?Page=3&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo;&lsaquo;</a>
<a href="../configuracao/listar-pacientes-paginacao.php?Page=1&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo; Anterior</a>
<a href="../configuracao/listar-pacientes-paginacao.php?Page=2&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">Próximo &rsaquo;</a>


</div>


<?php
// buscar xxx
$sql = "SELECT * FROM paciente 
$FiltroStatus $FiltroPaciente 
ORDER BY NomeCurto ASC
LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Status</th>';
	echo '<th>Convênio</th>';
	echo '<th>Plano terapêutico</th>';
	echo '<th>Ação</th>';
	echo '</tr>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}

		echo '<tr>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td><a href="paciente.php?id_paciente='.$id_paciente.'" method="post" class="Link">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeStatus.'</td>';

		// buscar xxx
		$sqlA = "SELECT convenio.NomeConvenio FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio 
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeConvenio = $rowA['NomeConvenio'];
		    }
		} else {
			// não tem
			$NomeConvenio = NULL;
		}

		if (!empty($NomeConvenio)) {
			echo '<td>'.$NomeConvenio.'</td>';
		} else {
			echo '<td style="background-color:#f2dede;"></td>';
		}

		// buscar avaliação ativa para utilizar as horas na agenda base
		$sqlA = "SELECT * FROM avaliacao WHERE id_paciente = '$id_paciente' AND Status = 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
		        // tem
		        $id_avaliacao = $rowA['id_avaliacao'];
		    }
		} else {
		    // não tem
		    $id_avaliacao = NULL;
		}

		if (!empty($id_avaliacao)) {
			echo '<td>';

			// buscar xxx
			$sqlA = "SELECT categoria_paciente.*, categoria.NomeCategoria
	        FROM categoria_paciente
	        INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria
	        WHERE categoria_paciente.id_avaliacao = '$id_avaliacao'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoria_paciente = $rowA['id_categoria_paciente'];
	                $id_categoriaX = $rowA['id_categoria'];
	                $NomeCategoriaX = $rowA['NomeCategoria'];
	                $HorasX = $rowA['Horas'];

	                $sqlB = "SELECT COUNT(id_agenda_paciente_base) AS Soma FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaX' ";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
						// tem
						while($rowB = $resultB->fetch_assoc()) {
							$Soma = $rowB['Soma'];
						}
					// não tem
					} else {
						$Soma = 0;
					}

					if ($Soma == $HorasX) {
						echo $NomeCategoriaX.' ('.$Soma.' / '.$HorasX.')<br>';
					} else {
						echo '<mark class="laranja">'.$NomeCategoriaX.' ('.$Soma.' / '.$HorasX.') - corrigir</mark><br>';
					}
	                
			    }
			} else {
				// não tem
				echo '<mark class="laranja">Não foi encontrado nenhum plano terapêutico.</mark>';
			}

			// buscar xxx
			$sqlA = "SELECT DISTINCT categoria.NomeCategoria, agenda_paciente_base.id_categoria FROM agenda_paciente_base
			INNER JOIN categoria ON agenda_paciente_base.id_categoria = categoria.id_categoria
			WHERE agenda_paciente_base.id_paciente = '$id_paciente' ";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoriaY = $rowA['id_categoria'];
					$NomeCategoriaY = $rowA['NomeCategoria'];

					// buscar xxx
					$sqlB = "SELECT * FROM categoria_paciente WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaY' ";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
					    while($rowB = $resultB->fetch_assoc()) {
							// tem
					    }
					} else {
						// não tem
						echo '<mark class="laranja">'.$NomeCategoriaY.' - não está no plano terapêutico</mark><br>';
					}
			    }
			} else {
				// não tem
			}
			echo '</td>';
		} else {
			echo '<td style="background-color:#f2dede;"></td>';
		}
		
		echo '<td>';
		echo '<a href="../agenda/agenda-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default" style="margin-right: 5px;">Agenda</a>';
		echo '<a href="../agenda/agenda-base-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default">Agenda base</a>';
		echo '</td>';
		
		echo '<td>';
		echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
} else {
	// não tem
	echo '<div style="margin: 25px 0">';
	echo '<b>Nota:</b> Não foi encontrado nenhum paciente.';
	echo '</div>';
}

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
<p>Alterar o nº de pacientes mostradas por página.</p>
<form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=<?php echo $Origem;?>" method="post" class="form-inline">
    <input type="number" name="Valor" class="form-control" value="<?php echo $Valor;?>" style="margin-bottom: 5px;">
    <button type="submit" class="btn btn-success">Confirmar</button>
</form>
</div>
			</div>
    </div>
</div>

<!-- alterar status -->
<div class="modal fade" id="AlterarStatus" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="filtro-validade-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alterar status</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <select class="form-control" name="StatusConvenio">
                    	<option value="">Selecionar</option>
                    	
                    	<option value="1">Botão Validar</option>
                    	<option value="2">Botão Cancelar</option>
                    </select>

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
</html>