<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Butlletí</title>
</head>
<?php 
  if(!isset($_SESSION["enviat"])) {
    echo '<div class="container">';
    echo "<h1>No has introduït cap nota per cap alumne!</h1>";
    echo '<a href="entranota.php" class="btn btn-primary">ENTRAR UN NOU ALUMNE</a>';
    echo '</div>';
  } else {
    $nom = array_keys($_SESSION)[0];
    $notes = $_SESSION[$nom];
?>
<body>
  <div class="container">
    <h1>Butlletí de l'alumne <?=$nom?></h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>MÒDUL</th>
          <th>NOTA</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $mitjana = 0;

        $valornota = array("Deficient" => 2, "Insuficient" => 4, "Suficient" => 5, "Bé" => 6, 
        "Notable" => 8, "Excelent" => 9, "Matricula" => 10);

        ksort($notes);
        foreach ($notes as $modul => $nota) {
          echo "<tr>";
          echo "<td>$modul</td>";
          foreach($valornota as $clau => $valor) {
            if($valor == $nota) {
              echo "<td>$clau - $nota</td>";
              break;
            }
          }
          echo "</tr>";
          $mitjana += $nota;
        }
        $mitjana = number_format($mitjana / count($notes), 2, '.', '');
        echo "<tr>";
          echo "<td><strong>MITJANA NOTES</strong></td>";
          echo "<td>$mitjana</td>";
          echo "</tr>"; 
        ?>
      </tbody>
    </table>
    <form action="entranota.php" method="post">
      <button type="submit" name="btn_retorn" class="btn btn-primary">ENTRAR UN NOU ALUMNE</button>
    </form>
  </div>
<?php 
  }
?>
</body>
</html>