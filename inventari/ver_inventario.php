<?php
session_start();

// Obtener el inventario de la sesión
$inventario = isset($_SESSION['inventario']) ? $_SESSION['inventario'] : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventario</title>
</head>
<body>
    <h2>Inventario</h2>
    <?php if (!empty($inventario)): ?>
        <table border="1">
            <tr>
                <th>Código de la Clase</th>
                <th>Nombre del Artículo</th>
                <th>Cantidad</th>
                <th>Tipo de Artículo</th>
            </tr>
            <?php foreach ($inventario as $articulo): ?>
                <tr>
                    <td><?php echo htmlspecialchars($articulo['codigo_clase']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['tipo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay artículos en el inventario.</p>
    <?php endif; ?>
    <br>
    <form method="post" action="agregar_articulo.php">
        <button type="submit">Agregar Artículo</button>
        <button type="submit" name="nuevo_inventario">Nuevo Inventario</button>
    </form>
</body>
</html>
