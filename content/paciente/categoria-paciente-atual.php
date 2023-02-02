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
$id_paciente = $_GET['id_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
    }
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="row">
<div class="col-lg-6">
	<div>
		<h3>Categorias</h3>
		<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

		<?php
		if (empty($_SESSION['AtivarAlteracaoCategoria'])) {
			// buscar xxx
			$sql = "SELECT DISTINCT categoria.* FROM categoria_paciente INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria WHERE id_paciente = '$id_paciente' ORDER BY categoria.NomeCategoria ASC ";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				if (empty($_SESSION['AtivarAlteracaoCategoria'])) {
				} else {
					echo '<th>Ação</th>';
				}
				echo '<th>Categoria</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_categoria = $row['id_categoria'];
					$NomeCategoria = $row['NomeCategoria'];
					echo '<tr>';
					echo '<td>'.$NomeCategoria.'</td>';
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
				echo 'Não encontramos nenhuma categoria associada ao paciente.';
			}
		} else {
			// buscar xxx
			$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				if (empty($_SESSION['AtivarAlteracaoCategoria'])) {
				} else {
					echo '<th>Ação</th>';
				}
				echo '<th>Categoria</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_categoria = $row['id_categoria'];
					$NomeCategoria = $row['NomeCategoria'];
					
					echo '<tr>';

					// buscar xxx
					$sqlA = "SELECT * FROM categoria_paciente WHERE id_categoria = '$id_categoria' AND id_paciente = '$id_paciente'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							echo '<td><a href="selecionar-categoria.php?id_categoria='.$id_categoria.'&id_paciente='.$id_paciente.'">&#x2611;</a></td>';
					    }
					} else {
						echo '<td><a href="selecionar-categoria.php?id_categoria='.$id_categoria.'&id_paciente='.$id_paciente.'">&#x2610;</a></td>';
					}

					
					echo '<td>'.$NomeCategoria.'</td>';
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
			}
		}

		if (empty($_SESSION['AtivarAlteracaoCategoria'])) {
			// buscar xxx
			$sql = "SELECT * FROM categoria_paciente WHERE id_paciente = '$id_paciente'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$CheckCategoria = 1;
			    }
			} else {
				$CheckCategoria = 2;
			}
			if ($CheckCategoria == 1) {
				echo '<a href="ativar-alteracao-categoria.php?id_paciente='.$id_paciente.'" class="btn btn-default">Alterar</a>';
			} else {
				echo '<a href="ativar-alteracao-categoria.php?id_paciente='.$id_paciente.'" class="btn btn-default">Adicionar categoria</a>';
			}
				
		} else {
			echo '<a href="ativar-alteracao-categoria.php?id_paciente='.$id_paciente.'" class="btn btn-default">Fechar alteração</a>';
		}
		?>
	</div>
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
