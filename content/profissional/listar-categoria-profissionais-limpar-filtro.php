<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
    
include "../conexao/conexao.php";

unset($_SESSION['PesquisaProfissional']);
unset($_SESSION['id_categoria']);

// fechar e voltar
header("Location: listar-categoria-profissionais.php");
exit;
?>