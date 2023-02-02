<?php
if (empty($_SESSION)) {
      session_start();
} else {

}

// verificar input
if (!empty($_POST) AND (empty($_POST['Usuario']) OR empty($_POST['Senha']))) {
    header("Location: index.html"); 
    exit;
}

// conectar ao banco
$servername = "localhost"; $username = "root"; $password = ""; $dbname = "fisiofor_agenda";

$conn = new mysqli($servername, $username, $password, $dbname);
// verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// input
$Usuario = $_POST['Usuario'];
$Senha = sha1($_POST['Senha']);
$id_unidade = $_POST['id_unidade'];
$_SESSION['id_unidade'] = $id_unidade;

// validar usuário
$sql = "SELECT * FROM profissional WHERE Usuario = '$Usuario' AND Senha = '$Senha' AND Status = 1 ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id_profissional = $row['id_profissional'];
    $Nivel = $row['Nivel'];
    $_SESSION['UsuarioID'] = $id_profissional;
    $_SESSION['UsuarioNome'] = $Usuario;
    $_SESSION['UsuarioNivel'] = $Nivel;
    }
} else {
    // mensagem de alerta
    echo "<script type=\"text/javascript\">
        alert(\"Erro: usuário ou senha inválido.\");
        window.location = \"../../index.html\"
        </script>";
    exit;
}

$UsuarioID = $_SESSION['UsuarioID'];

// entrar
if ($_SESSION['UsuarioNivel'] > 1) {
    header("Location: ../agenda/"); 
} else {
    // header("Location: ../profissional/agenda-profissional.php?id_profissional=$UsuarioID");
    header("Location: ../agenda/index.php?id_profissional=$UsuarioID");
}
exit;
?>