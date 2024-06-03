<?php
session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$total = 0;

foreach ($carrito as $item) {
    $total += $item['cantidad'] * $item['preu'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar'])) {
    // Destruir la sesión después de confirmar la compra
    session_destroy();
    // Redirigir a la página de inicio de sesión después de la alerta
    echo "<script>alert('Compra realizada'); window.location.href='carrito.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    header('Location: carrito.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Carrito</title>
</head>
<body>
    <h2>Carrito de Compras de <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?></h2>
    <?php if (!empty($carrito)): ?>
        <ul>
            <?php foreach ($carrito as $clave => $item): ?>
                <li><?php echo $clave; ?> - <?php echo $item['descripcio']; ?> - Cantidad: <?php echo $item['cantidad']; ?> - Total: <?php echo $item['cantidad'] * $item['preu']; ?>€</li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total de la compra: <?php echo $total; ?>€</strong></p>
        <form method="post" action="">
            <button type="submit" name="confirmar">Confirmar Compra</button>
            <button type="submit" name="modificar">Modificar Pedido</button>
        </form>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>
    <form method="post" action="carrito.php" style="margin-top: 20px;">
        <button type="submit" name="logout">Cambiar Usuario</button>
    </form>
</body>
</html>
