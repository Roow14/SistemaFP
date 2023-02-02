<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$sql = "SELECT COUNT(id_agenda_paciente_base) AS Soma FROM agenda_paciente_base";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // tem
    while($row = $result->fetch_assoc()) {
        $Soma = $row['Soma'];
        echo $Soma;
    }
// não tem
} else {
}
echo '<br>';
// buscar xxx
$sql = "SELECT * FROM unidade";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $id_unidade = $row['id_unidade'];
        $NomeUnidade = $row['NomeUnidade'];

        $sqlA = "SELECT COUNT(id_paciente) AS Soma FROM paciente WHERE id_unidade = '$id_unidade' AND Status = 1";
        $resultA = $conn->query($sqlA);
        if ($resultA->num_rows > 0) {
            // tem
            while($rowA = $resultA->fetch_assoc()) {
                $Soma = $rowA['Soma'];
                echo $NomeUnidade.' - '.$Soma.'<br>';
            }
        // não tem
        } else {
        }
    }
} else {
    // não tem
}
        

?>