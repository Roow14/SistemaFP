<?php
// buscar xxx
$sql = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$CheckApagar1 = 1;
    }
} else {
	// não tem
	$CheckApagar1 = 0;
}

// buscar xxx
$sql = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$CheckApagar2 = 1;
    }
} else {
	// não tem
	$CheckApagar2 = 0;
}

// buscar xxx
$sql = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$CheckApagar3 = 1;
    }
} else {
	// não tem
	$CheckApagar3 = 0;
}

$CheckApagar = $CheckApagar3 + $CheckApagar2 + $CheckApagar1;
?>