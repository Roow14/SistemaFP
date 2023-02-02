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
$id_paciente = $_SESSION['id_paciente'];
$id_categoria = $_POST['id_categoria'];
$id_avaliacao = $_POST['id_avaliacao'];
$Horas = $_POST['Horas'];


// verificar se tem terapia cadastrada
$sql = "SELECT * FROM categoria_paciente WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoria'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $id_categoria_paciente = $row['id_categoria_paciente'];
        // atualizar
        $sqlA = "UPDATE categoria_paciente SET Horas = '$Horas' WHERE id_categoria_paciente = '$id_categoria_paciente' ";
        if ($conn->query($sqlA) === TRUE) {
        } else {
        }
    }
} else {
    // não tem
    // inserir terapia
    $sql = "INSERT INTO categoria_paciente (id_paciente, id_categoria, id_avaliacao, Horas) VALUES ('$id_paciente', '$id_categoria', '$id_avaliacao', '$Horas')";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
}

// voltar
header("Location: alterar-avaliacao.php?id_avaliacao=$id_avaliacao");
exit;
?>
