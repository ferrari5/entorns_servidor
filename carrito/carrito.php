<?php
session_start();

$usuarios = array(
    "user1" => "password1",
    "user2" => "password2",
    "toni"  => "1234"
);

$productes = array(
    "pa" => array("codi" => 001, "descripcio" => "pa blanc", "preu" => 2.5),
    "olives" => array("codi" => 002, "descripcio" => "olives rosello", "preu" => 3),
    "patatilla" => array("codi" => 003, "descripcio" => "patatilla amb sal", "preu" => 0.99),
    "gelat" => array("codi" => 004, "descripcio" => "gelat avellana", "preu" => 4.95),
    "peix" => array("codi" => 005, "descripcio" => "salmon fresc", "preu" => 6.75),
    "carn" => array("codi" => 006, "descripcio" => "entrecot de ternera", "preu" => 11.2)
);

if ( isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($usuarios[$username]) && $usuarios[$username] == $password) {
        $_SESSION['username'] = $username;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

if (isset($_POST['cantidad'])) {
    $cantidades = $_POST['cantidad'];
    $carrito = [];

    foreach ($productes as $clave => $producto) {
        $cantidad = isset($cantidades[$clave]) ? (int)$cantidades[$clave] : 0;
        $carrito[$clave] = [
            'codi' => $producto['codi'],
            'descripcio' => $producto['descripcio'],
            'preu' => $producto['preu'],
            'cantidad' => $cantidad
        ];
    }

    $_SESSION['carrito'] = $carrito;

    // Redirigir a la página de visualización del carrito
    header('Location: ver_carrito.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header('Location: carritogpt.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (!isset($_SESSION['username'])): ?>
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
        <br>
        <p>usuaris : </p>
        <?php foreach($usuarios as $usuari => $contrasenya){
            echo "<br>";
            echo $usuari ." => ". $contrasenya;
        }
        
        ?>
    <?php else: ?>
        <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
        <form method="post" action="">
            <?php foreach ($productes as $clave => $producto): ?>
                <div>
                    <span><?php echo $clave; ?> (<?php echo $producto['preu']; ?>€)</span>
                    <input type="number" name="cantidad[<?php echo $clave; ?>]" min="0" value="0">
                </div>
            <?php endforeach; ?>
            <button type="submit">Aceptar</button>
        </form>
        <form method="post" action="" style="margin-top: 20px;">
            <button type="submit" name="logout">Cambiar Usuario</button>
        </form>
    <?php endif; ?>
</body>

</html>