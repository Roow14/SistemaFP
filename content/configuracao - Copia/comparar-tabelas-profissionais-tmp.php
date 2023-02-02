<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// buscar xxx
$sql = "SELECT * FROM tmp_profissional ORDER BY NomeCurto ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Pesquisa</th>';
	echo '<th>tmp</th>';
	echo '<th>Função</th>';
	echo '<th>nome semelhante</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeTmp = $row['NomeTmp'];
		$NomeCurto1 = $row['NomeCurto'];
		$FuncaoTmp = $row['FuncaoTmp'];

		// buscar xxx
		$sqlA = "SELECT * FROM profissional WHERE NomeCompleto = '$NomeTmp'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				// echo $NomeCurto.' - '.$NomeCompleto.'<br>';
		    }
		} else {
			// não tem
			// buscBr xxx
			$sqlB = "SELECT * FROM funcao WHERE id_funcao ='$FuncaoTmp'";
			$resultB = $conn->query($sqlB);
			if ($resultB->num_rows > 0) {
			    while($rowB = $resultB->fetch_assoc()) {
			    	$NomeFuncao = $rowB['NomeFuncao'];
			    }
			} else {
				// não tem
			}
			
			// buscBr xxx
			$Filtro = 'WHERE NomeCompleto LIKE "%'.$NomeCurto1.'%"';
			$sqlB = "SELECT * FROM profissional $Filtro";
			$resultB = $conn->query($sqlB);
			if ($resultB->num_rows > 0) {
			    while($rowB = $resultB->fetch_assoc()) {
			    	$NomeCompleto = $rowB['NomeCompleto'];
					// tem
					echo '<tr>';
					echo '<td>'.$NomeCurto1.'</td>';
					echo '<td>'.$NomeTmp.'</td>';
					echo '<td>'.$NomeFuncao.'</td>';
					echo '<td>'.$NomeCompleto.'</td>';
					echo '</tr>';
			    }
			} else {
				// não tem
			}
		}
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}

// voltar
// header("Location: configurar-funcao.php");
exit;
?>
