<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) 
{
session_destroy();
header("Location: ../../index.html"); exit;
}
session_destroy();

// // input
// $id_usuario = $_SESSION['UsuarioID'];

// iniciar conexão com o banco
// include "../conexao/conexao.php";

// $prog_procedimento_tmp = 'prog_procedimento_tmp_'.$_SESSION['UsuarioID'];
// $prog_reforcador_tmp = 'prog_reforcador_tmp_'.$_SESSION['UsuarioID'];

// // apagar
// $sql = "DELETE FROM $prog_procedimento_tmp";
// if ($conn->query($sql) === TRUE) {
// } else {
// }

// // apagar
// $sql = "DELETE FROM $prog_reforcador_tmp";
// if ($conn->query($sql) === TRUE) {
// } else {
// }

header("Location: ../../index.html");
exit;
?>