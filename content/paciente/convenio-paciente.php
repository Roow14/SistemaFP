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
if (isset($_SESSION['Origem'])) {
	$Origem = $_SESSION['Origem'];
} else {
	$Origem = 'convenio-paciente.php';
}

if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} elseif (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
} elseif (!empty($_POST['id_paciente']))	{
	$id_paciente = $_POST['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} else {
	unset($_SESSION['id_paciente']);
}

if (isset($_POST['limpar'])) {
	unset($_SESSION['id_paciente']);
}

if (isset($id_paciente)) {
	// buscar xxx
	$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCompleto = $row['NomeCompleto'];
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
	.ajuste-botao {
		float: right;
		margin-top: -30px;
	}

	/* The Modal (background) */
	.modal1 {
	  display: block; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  padding-top: 80px; /* Location of the box */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content1 {
	  background-color: transparent !important;
	  margin: auto;
	  padding: 15px !important;
	  border: none !important;
	  max-width: 600px;
	  border-radius: 0 !important;
	  -webkit-box-shadow: none !important;
	  box-shadow: none !important;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Paciente</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="active"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>

	<?php
	if (isset($id_paciente)) {
		// buscar xxx
		$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio
		FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			// echo '<th>ID</th>';
			echo '<th>Nome do convênio</th>';
			echo '<th>Nº carteirinha</th>';
			echo '<th>Horas liberadas por semana</th>';
			echo '<th>Liberação AT</th>';
			echo '<th>Status</th>';
			echo '<th>Observação</th>';
			echo '<th style="width: 100px;">Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_convenio_paciente = $row['id_convenio_paciente'];
				$id_convenio = $row['id_convenio'];
				$NomeConvenio = $row['NomeConvenio'];
				$NumeroConvenio = $row['NumeroConvenio'];
				$NotaConvenio = $row['NotaConvenio'];
				$Total = $row['Total'];
				$StatusConvenio = $row['StatusConvenio'];
				if ($StatusConvenio == 1) {
					$NomeStatus = 'Ativo';
				} else {
					$NomeStatus = 'Inativo';
				}
				$LiberacaoAT = $row['LiberacaoAT'];
				if ($LiberacaoAT == 2) {
					$NomeLiberacaoAT = 'Social';
				} elseif ($LiberacaoAT == 3) {
					$NomeLiberacaoAT = 'Escolar';
				}
				else {
					$NomeLiberacaoAT = 'Nenhum';
				}
				echo '<tr>';
				// echo '<td>'.$id_convenio.'</td>';
				echo '<td>'.$NomeConvenio.'</td>';
				echo '<td>'.$NumeroConvenio.'</td>';
				echo '<td>'.$Total.'</td>';
				echo '<td>'.$NomeLiberacaoAT.'</td>';
				echo '<td>'.$NomeStatus.'</td>';
				echo '<td>'.$NotaConvenio.'</td>';
				echo '<td>';
				echo '<a href="alterar-convenio-paciente.php?id_convenio_paciente='.$id_convenio_paciente.'" class="btn btn-default">Alterar</a>';
				echo '</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
			echo 'Nota: somente um convênio deve estar como ativo.';
		} else {
			echo '<br>';
			echo '<b>Nota:</b> Não foi encontrado nenhum convênio';
		}

		echo '<br>';
		echo '<br>';
		echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#cadastrar">Associar convênio</a>';
		echo '<a href="listar-convenio.php" class="btn btn-default">Listar convênios</a>';
	}
	?>
</div>
			</div>
    </div>
</div>

<!-- cadastrar -->
<div class="modal fade" id="cadastrar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="associar-convenio-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Associar convênio ao paciente</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
	                <div class="form-group">
	                	<label>Convênio</label>
	                    <select class="form-control" name="id_convenio">
	                    	<option value="">Selecionar</option>
	                    	<?php
							// buscar xxx
							$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1 ORDER BY NomeConvenio ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_convenio = $row['id_convenio'];
									$NomeConvenio = $row['NomeConvenio'];
									echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
							    }
							} else {
								// não tem
							}
							?>
	                    </select>
	                </div>
	                <div class="form-group">
	                	<label>Nº da carteirinha</label>
	                	<input type="text" name="NumeroConvenio" class="form-control" required>
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

<?php
// ver se tem convenio ativo
$sql = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1 LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    }
} else {
	// não tem
	?>
	<div id="myModal123" class="modal1">
	  	<div class="modal-content1">
			<!-- <span class="close1">&times;</span> -->
			<div class="modal-dialog">

	        <!-- Modal content-->
	        <div class="modal-content">
	            <form action="adicionar-avaliacao-2.php" method="post">

	                <div class="modal-header">
	                    <!-- <span class="close1">&times;</span> -->
	                    <h4 class="modal-title">Aviso</h4>
	                </div>
	                <div class="modal-body" style="background-color: #fafafa;">
		           		<p>Importante: Não foi encontrado nenhum convênio ativo.</p>
	                </div>
	                
	                <div class="modal-footer">
	                    <button type="button" class="btn" data-dismiss="modal"><span class="close1">Fechar</span></button>
	                </div>
	            </form>    
	        </div>
	    </div>
		</div>
	</div>
	<?php
}	
?>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script>
	// Get the modal
	var modal = document.getElementById("myModal123");

	// Get the button that opens the modal

	// Get the <span> element that close1s the modal
	var span = document.getElementsByClassName("close1")[0];

	// When the user clicks the button, open the modal 


	// When the user clicks on <span> (x), close1 the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close1 it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
</script>
</body>
</html>