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
$id_tmp_profissional = $_GET['id_tmp_profissional'];
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];

// atualizar
$sql = "UPDATE tmp_profissional SET NomeCurto = '$NomeCurto', NomeCompleto = '$NomeCompleto' WHERE id_tmp_profissional = '$id_tmp_profissional' ";
if ($conn->query($sql) === TRUE) {
} else {
}
echo $NomeCurto;
// voltar
header("Location: importar-profissionais.php?id=#$id_tmp_profissional");
exit;
?>
