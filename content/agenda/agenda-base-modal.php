<?php  
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
session_start();

$id_unidade = $_SESSION['id_unidade'];

if(isset($_POST["item_id"]))  {  
     include '../conexao/conexao.php';
     $id_x = $_POST['item_id'];
     $temp = explode(".",$id_x);
     $hora=$temp[0];
     $DiaSemana=$temp[1];
     $id_hora=$temp[2];

     if ($DiaSemana == 2) {
          $NomeDiaSemana = 'Segunda';
     } elseif ($DiaSemana == 3) {
          $NomeDiaSemana = 'Terça';
     } elseif ($DiaSemana == 4) {
          $NomeDiaSemana = 'Quarta';
     } elseif ($DiaSemana == 5) {
          $NomeDiaSemana = 'Quinta';
     } elseif ($DiaSemana == 6) {
          $NomeDiaSemana = 'Sexta';
     } else {
          $NomeDiaSemana = NULL;
     }

     // echo date('l', strtotime($temp[1]));
     // echo ucwords(strftime('%A', strtotime($temp[1])));
     if(isset($_SESSION['id_paciente'])) {
          $id_paciente=$_SESSION['id_paciente'];
          $sql = "SELECT* from paciente where id_paciente=$id_paciente";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          $NomeCompleto=$row['NomeCompleto'];
}

$output = '';  

// nome e id do profissional que está logado
$NomeLogado = $_SESSION['UsuarioID'];
$UsuarioID = $_SESSION['UsuarioID'];

$id_categoria = $_SESSION['id_categoria'];
// buscar xxx
$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
          // tem
          $NomeCategoria = $row['NomeCategoria'];
    }
} else {
     // não tem
     $NomeCategoria = NULL;
}

// buscar xxx
$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
          // tem
          $PeriodoY = $row['Periodo'];
    }
} else {
     // não tem
}
?>
<style>
     .table-no-border td {
          border: 0 !important;
     }
</style>

<div class="form-group">
     <label>Terapeuta</label>
     <select class="form-control" name="id_profissional" required>
          <option value="">Selecionar</option>
          <?php
          // buscar xxx
          $sql = "SELECT profissional.* 
          FROM categoria_profissional 
          INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional 
          WHERE categoria_profissional.id_categoria = '$id_categoria' 
          AND categoria_profissional.id_periodo = '$PeriodoY' 
          AND categoria_profissional.id_unidade = '$id_unidade' 
          AND profissional.Status = 1 
          ORDER BY profissional.NomeCompleto ASC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                    // tem
                    $id_profissionalX = $row['id_profissional'];
                    $NomeProfissional = $row['NomeCompleto'];

                    // verificar se o profissional está agendado neste horário
                    $sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissionalX' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        while($rowA = $resultA->fetch_assoc()) {
                              // tem
                              echo '<option value="">--- '.$NomeProfissional.' ---</option>';
                        }
                    } else {
                         // não tem
                         echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
                    }
              }
          } else {
               // não tem
          }

          ?>
     </select>
</div>

<input type="text" name="DiaSemana" value="<?php echo $DiaSemana;?>" hidden>
<input type="text" name="Hora" value="<?php echo $Hora;?>" hidden>
<input type="text" name="id_hora" value="<?php echo $id_hora;?>" hidden>
<input type="text" name="id_paciente" value="<?php echo $id_paciente;?>" hidden>
<input type="text" name="id_categoria" value="<?php echo $id_categoria;?>" hidden>
<input type="text" name="Auxiliar" value="<?php echo $Auxiliar;?>" hidden>

<?php
     }
?>