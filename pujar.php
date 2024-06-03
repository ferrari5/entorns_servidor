<?php
session_start();
const dir_uploads = "./uploaded/";//Mete en la constante dir_uploads la url de la carpeta donde irán las img.
$missatge = '';

if (isset($_POST["pujar"]) && isset($_POST["codi_producte"]) && isset($_FILES["arxiu"])) {
    $codi_producte = $_POST["codi_producte"]; //Si le han dado al botón, hay un cód. de producto y han subido un archivo.

    if ($codi_producte !== '') {
        $codi_producte = htmlspecialchars($codi_producte); //sanitizam el nom, lleva els tags
        if ($_FILES["arxiu"]["error"] == UPLOAD_ERR_OK) { /* no hi ha error*/
            $tmp_name = $_FILES["arxiu"]["tmp_name"];
            $path_parts = pathinfo($_FILES["arxiu"]["name"]);//me genera un array amb l’extensió, basename, dirname i filename agaf lo que vull guardar i el fic a una variable i després el moc a la carpeta temporal.*/
            $extension = $path_parts["extension"];
            if ($_FILES["arxiu"]["type"] == 'image/jpeg' || $_FILES["arxiu"]["type"] == 'image/png') {
                move_uploaded_file($tmp_name, dir_uploads .'img_'.$codi_producte . "." . $extension); //(string filename, string destination) moure un arxiu pujat correctament de la seva ubicació temporal a la que noltros determinem
                $missatge = "Arxiu pujat correctament";
            }
        } else {
            $missatge = "error pujant arxiu";
        }
    } else {
        $missatge = "No s'ha especificat cap nom";
    }
}
?>

    <!doctype html>
    <html lang="ca">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pujar Imatges</title>
    </head>
    <body>

    <form action="#" name="upload" enctype="multipart/form-data" method="post">

        <label for="codi_producte">Codi del Producte:</label>
        <input type="text" name="codi_producte" id="codi_producte" required><br>
        <br>
        <label for="imatge">Pujar Imatge:</label>
        <input type="file" name="arxiu" id="" value=""><br>
        <br>
        <input type="submit" name="pujar" value="Pujar Imatge">

        <?php

        echo $missatge;

        $imatges = scandir(dir_uploads);
        foreach ($imatges as $key => $value) {
            if ($key > 1) {
                $nomImg = pathinfo($value)["filename"];
                echo "<p><img src='" . dir_uploads . "/$value' alt='$nomImg'></p>";
            }
        }
        ?>
        <br>
    </form>
    </body>
    </html>

<?php
/**Funcions PHP
 * boolean is_uploaded_file(string filename): Ens diu si un arxiu ha estat pujat.
 * boolean move_uploaded_file(string filename, string destination): Moure l'arxiu pujat de l'ubicació temp a la que volem.
 *
 * scandir: Enumera los ficheros y directorios ubicados en la ruta especificada.
 * scandir(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING, resource $context = ?): array
 * Devuelve un array con los ficheros y los directorios que se encuentran bajo directory.
 *
 * $_FILES['userfile']['name'] Nom original del fitxer pujant incloent la extensió.
 * $_FILES['userfile']['size'] Tamany en bytes de l'arxiu pujat.
 * $_FILES['userfile']['tmp_name'] Nom temporal que té l'arxiu pujat dins el servidor.
 * $_FILES['userfile']['type'] Determina el tiupus MIME de l'arxiu pujat (image/png,application/pdf,...)
 * $_FILES['userfile']['error'] Ens dona informació sobre com ha anat la pujada de l'arxiu.
 */
//$nom = isset($_POST["nom"])?trim($_POST["nom"]):''; Para quitar espacios delante y atrás
?>