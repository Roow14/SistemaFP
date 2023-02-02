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
	$FiltroProfissional = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaProfissional.'%"';
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

			<div class="row">
<div class="col-lg-8">
	<h3>Profissionais por categoria</h3>
	<form action="aplicar-filtro-por-categoria.php" method="post" class="form-inline" style="margin-bottom: 25px;">
      	
    	<label>Profissional:</label>
    	<input type="text" name="PesquisaProfissional" class="form-control" value="<?php echo $PesquisaProfissional;?>" placeholder="Nome">
    	<button type="submit" class="btn btn-success">Confirmar</button>
    </form>
	<?php
	// buscar dados
	$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		
	    while($row = $result->fetch_assoc()) {
	    	$id_categoria = $row['id_categoria'];
	    	$NomeCategoria = $row['NomeCategoria'];

	    	// buscar dados
			echo '<h4>'.$NomeCategoria.'</h4>';

			// echo '<td>';
			$sqlA = "SELECT profissional.* FROM profissional LEFT JOIN categoria_profissional ON profissional.id_profissional = categoria_profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' $FiltroProfissional ORDER BY profissional.NomeCompleto ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Profissional</th>';
				echo '<th>Função</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($rowA = $resultA->fetch_assoc()) {
					$id_profissional = $rowA['id_profissional'];
					$NomeCompleto = $rowA['NomeCompleto'];
					$id_funcao = $rowA['id_funcao'];
					

					$sqlC = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
					    while($rowC = $resultC->fetch_assoc()) {
							$NomeFuncao = $rowC['NomeFuncao'];
					    }
					} else {
						$NomeFuncao = NULL;
					}

					echo '<tr>';
					echo '<td><a href="profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeCompleto.'</a></td>';
					echo '<td>'.$NomeFuncao.'</td>';

					echo '</tr>';
					// echo '<br>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
			}
			echo '<br>';
			
	    }
	    
	} else {
		echo 'Não encontramos nenhuma categoria.';
	}
	?>
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
