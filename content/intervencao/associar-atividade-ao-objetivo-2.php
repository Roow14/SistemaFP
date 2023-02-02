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
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_objetivo_paciente = $_GET['id_objetivo_paciente'];
$id_paciente = $_GET['id_paciente'];
$id_atividade_titulo = $_POST['id_atividade_titulo'];

// buscar xxx
$sql = "SELECT * FROM prog_atividade WHERE id_atividade_titulo = '$id_atividade_titulo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_atividade = $row['id_atividade'];

		// inserir
		$sqlA = "INSERT INTO prog_atividade_paciente (id_atividade_titulo, id_atividade, id_treino_paciente) VALUES ('$id_atividade_titulo', '$id_atividade', '$id_treino_paciente')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}	

// voltar
header("Location: treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente");
exit;
?>
