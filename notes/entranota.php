<?php 
  session_start();

  if(isset($_POST["btn_retorn"])) {
    session_unset();
  }

  $nom = $_POST["nom"] ?? "";
  $modul = $_POST["modul"] ?? "";
  $nota = $_POST["nota"] ?? "";
  $notesAlumne = $_SESSION[$nom] ?? [];
  $nomPosat = $nom == "" ? false : true;
  
  $valornota = array("Deficient" => 2, "Insuficient" => 4, "Suficient" => 5, "Bé" => 6, 
                "Notable" => 8, "Excelent" => 9, "Matricula" => 10);
              

  if(isset($_POST["btn_envia"]) && $nom !== "" && $nota >= 0 && $nota <= 10) {
    $_SESSION[$nom][$modul] = $nota;
    $_SESSION["enviat"] = 1;
    $notesAlumne = $_SESSION[$nom];
  }

  if(isset($_POST["btn_butlleti"])) {
    header("Location: butlleti.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>ENTRA NOTA</title>
</head>
<body>
  <div class="container">
    <h1>INTRODUEIX LES DADES DE L'ALUMNE</h1>
    <form action="#" method="post">
      <div>
        <label for="nom">Nom alumne: </label>
        <input type="text" name="nom" id="nom">
      </div>
      <div>
        <label for="modul">Mòdul: </label>
        <input type="text" name="modul" id="modul">
      </div>
      <div>
        <label for="nota">Nota: </label>
        <select name="nota" id="nota">
          <option value="default"></option>
          <?php 
            foreach ($valornota as $clau => $nota) {
              echo "<option>$nota</option>";
            }
          ?>
        </select>
      </div>
      <button type="submit" name="btn_envia" class="btn btn-primary">REGISTRA</button>
      <button type="submit" name="btn_butlleti" class="btn btn-primary">BUTLLETÍ</button>
    </form>
  </div>
  <div class="container">
    
      <?php 
      if(count($notesAlumne) > 0) {
        echo "<h3>Registres introduits per l'alumne $nom</h3>";
      }
        foreach($notesAlumne as $modul => $nota) {
          echo "<strong>Modul:</strong> $modul - <strong>Nota:</strong> $nota<br>";
        }
      ?>
  </div>
</body>
</html>