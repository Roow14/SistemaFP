<?php
// Auxiliar 1 aplicador, 2 terapeuta
if (!empty($_SESSION['Auxiliar'])) {
	$Auxiliar = $_SESSION['Auxiliar'];
	if ($Auxiliar == 1) {
		$NomeAplicador = 'Aplicador';
	} else {
		$NomeAplicador = 'Terapeuta';
	}
} else {
	// terapeuta
	$Auxiliar = 2;
	$NomeAplicador = 'Terapeuta';
}

if (!empty($_SESSION['id_categoria'])) {
	$id_categoria = $_SESSION['id_categoria'];

	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_categoria = $row['id_categoria'];
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
}

if (!empty($_SESSION['id_unidade'])) {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_unidade = $row['id_unidade'];
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
}
?>
<div>

	<form action="agenda-paciente-filtro-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
		
		<div class="form-group">
			<label>Agendar por categoria:</label>
			<select class="form-control" name="id_categoria" required>
				<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_categoriaX = $row['id_categoria'];
						$NomeCategoria = $row['NomeCategoria'];
						echo '<option value="'.$id_categoriaX.'">'.$NomeCategoria.'</option>';
				    }
				} else {
					// não tem
				}
				?>
			</select>
		</div>

		<div class="form-group">
			<label>Unidade:</label>
			<select class="form-control" name="id_unidade" required>
				<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_unidadeX = $row['id_unidade'];
						$NomeUnidade = $row['NomeUnidade'];
						echo '<option value="'.$id_unidadeX.'">'.$NomeUnidade.'</option>';
				    }
				    echo '<option value="">Limpar filtro</option>';
				} else {
					// não tem
				}
				?>
			</select>
		</div>

		<div class="form-group">
		     <label>Período:</label>
		     <select name="Periodo" class="form-control" required>
				<option value="<?php echo $PeriodoAgenda;?>"><?php echo $NomePeriodoAgenda;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM periodo ORDER BY NomePeriodo ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$PeriodoAgendaX = $row['Periodo'];
						$NomePeriodoAgendaX = $row['NomePeriodo'];
						echo '<option value="'.$PeriodoAgendaX.'">'.$NomePeriodoAgendaX.'</option>';
				    }
				} else {
					// não tem
				}
				?>
		     </select>
		</div>

		<div class="form-group">
		     <label>Função:</label>
		     <select name="Auxiliar" class="form-control">
		          <option value="<?php echo $Auxiliar;?>"><?php echo $NomeAplicador;?></option>
		          <option value="2">Terapeuta</option>
		          <option value="1">Aplicador</option>
		     </select>
		</div>

		<button type="submit" class="btn btn-success">Confirmar</button>
		<a href="agenda-paciente-limpar-filtro-2.php" class="btn btn-default">Limpar filtro</a>
		<a href="agenda-paciente-ativar-filtro-2.php" class="btn btn-default">Fechar</a>
	</form>
	
</div>