<?php
session_start();

// Inicializar inventario si no está ya en la sesión o si se ha cambiado de clase
if (!isset($_SESSION['inventario']) || isset($_POST['cambiar_clase']) || isset($_POST['nuevo_inventario'])) {
    $_SESSION['inventario'] = [];
}

$ultimo_articulo = null;
$codigo_clase = '';
$error = '';

// Procesar el formulario de agregar artículo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['codigo_clase']) && !isset($_POST['cambiar_clase']) && !isset($_POST['nuevo_inventario'])) {
        $_SESSION['codigo_clase'] = $_POST['codigo_clase'];
    }

    if (isset($_POST['agregar'])) {
        $nombre = trim($_POST['nombre']);
        $cantidad = trim($_POST['cantidad']);
        $tipo = trim($_POST['tipo']);
        $codigo_clase = $_SESSION['codigo_clase'];

        // Validar campos
        if (empty($nombre) || empty($cantidad) || empty($tipo)) {
            $error = "Todos los campos son obligatorios.";
        } else {
            // Crear un nuevo artículo
            $nuevo_articulo = [
                'nombre' => $nombre,
                'cantidad' => $cantidad,
                'codigo_clase' => $codigo_clase,
                'tipo' => $tipo
            ];

            // Agregar el artículo al inventario
            $_SESSION['inventario'][] = $nuevo_articulo;

            // Guardar el último artículo añadido para mostrarlo
            $ultimo_articulo = $nuevo_articulo;
        }
    }

    if (isset($_POST['cambiar_clase']) || isset($_POST['nuevo_inventario'])) {
        unset($_SESSION['codigo_clase']);
        $_SESSION['inventario'] = [];
    }
}

// Obtener el código de clase si está en la sesión
if (isset($_SESSION['codigo_clase'])) {
    $codigo_clase = $_SESSION['codigo_clase'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Artículo</title>
</head>
<body>
    <h2>Agregar Artículo al Inventario</h2>
    <?php if (!$codigo_clase): ?>
        <form method="post" action="">
            <label for="codigo_clase">Código de la Clase:</label>
            <input type="text" id="codigo_clase" name="codigo_clase" required><br><br>
            <button type="submit">Siguiente</button>
        </form>
    <?php else: ?>
        <form method="post" action="">
            <input type="hidden" name="codigo_clase" value="<?php echo htmlspecialchars($codigo_clase); ?>">
            
            <label for="nombre">Nombre del Artículo:</label>
            <input type="text" id="nombre" name="nombre"><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad"><br>

            <label for="tipo">Tipo de Artículo:</label>
            <select id="tipo" name="tipo">
                <option value="">Seleccione un tipo</option>
                <option value="moviliario">Moviliario</option>
                <option value="material didactico">Material Didáctico</option>
                <option value="equipo informatico">Equipo Informático</option>
            </select><br><br>

            <button type="submit" name="agregar">Agregar Artículo</button>
            <button type="submit" formaction="ver_inventario.php" formmethod="get">Ver Inventario</button>
            <button type="submit" name="cambiar_clase">Cambiar Clase</button>
        </form>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($ultimo_articulo): ?>
        <h3>Último Artículo Añadido</h3>
        <table border="1">
            <tr>
                <th>Código de la Clase</th>
                <th>Nombre del Artículo</th>
                <th>Cantidad</th>
                <th>Tipo de Artículo</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($ultimo_articulo['codigo_clase']); ?></td>
                <td><?php echo htmlspecialchars($ultimo_articulo['nombre']); ?></td>
                <td><?php echo htmlspecialchars($ultimo_articulo['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($ultimo_articulo['tipo']); ?></td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>
