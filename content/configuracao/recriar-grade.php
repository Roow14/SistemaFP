<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// limpar dados da tabela
$sql = "TRUNCATE hora";
if ($conn->query($sql) === TRUE) {
} else {
}

// inserir
$sql = "INSERT INTO hora (id_hora, Hora, Ordem, Periodo) VALUES
(1, '08:00', 1, 1), 
(2, '08:30', 2, 1), 
(3, '09:00', 3, 1), 
(4, '09:30', 4, 1), 
(5, '10:00', 5, 1), 
(6, '10:30', 6, 1), 
(7, '11:00', 7, 1), 
(8, '11:30', 8, 1), 
(9, '12:00', 9, 2), 
(10, '13:00', 10, 2), 
(11, '13:30', 11, 2), 
(12, '14:00', 12, 2), 
(13, '14:30', 13, 2), 
(14, '15:00', 14, 2), 
(15, '15:30', 15, 2), 
(16, '16:00', 16, 2), 
(17, '16:30', 17, 2), 
(18, '17:00', 18, 2), 
(19, '17:30', 19, 3), 
(20, '18:00', 20, 3), 
(21, '18:30', 21, 3), 
(22, '19:00', 22, 3), 
(23, '19:30', 23, 3), 
(24, '20:00', 24, 3), 
(25, '20:30', 25, 3)
";
if ($conn->query($sql) === TRUE) {
} else {
}

// echo $sql;

// voltar
header("Location: configurar-horas.php");
exit;
?>
