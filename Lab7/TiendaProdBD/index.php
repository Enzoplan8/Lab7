<?php
include 'functions.php';

$productos = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cargar_cliente'])) {
        $mensaje = cargarCliente($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['calle'], $_POST['numero']);
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } elseif (isset($_POST['cargar_producto'])) {
        $mensaje = cargarProducto($_POST['nombreprod'], $_POST['precio']);
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } elseif (isset($_POST['buscar_producto_por_id'])) {
        $productos = buscarProductoPorID($_POST['id_producto']);
    }
}

// Lectura de datos
$clientes = leerClientes();
$productosTodos = leerProductos();
$detalles = leerDetalles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes y Productos</title>
    <link rel="stylesheet" href="style.css">
    <script src="validaciones.js" defer></script>
</head>
<body>
    <h1>Gestión de Clientes y Productos</h1>

    <?php if (isset($_GET['mensaje'])) {
        echo "<p>" . htmlspecialchars($_GET['mensaje']) . "</p>";
    } ?>
    <div class="cont-formularios">
        <!-- Formulario de carga de clientes -->
        <div class="formularios">
            <h2>Agregar Cliente</h2>
            <form action="index.php" method="post" onsubmit="return validarFormularioCliente(event)">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                Email: <input type="text" name="email"><br>
                Calle: <input type="text" name="calle"><br>
                Número: <input type="text" name="numero"><br>
                <input type="submit" name="cargar_cliente" value="Agregar Cliente">
            </form>
        </div>

        <!-- Formulario de carga de productos -->
        <div class="formularios">
            <h2>Agregar Producto</h2>
            <form action="index.php" method="post" onsubmit="return validarFormularioProducto(event)">
                Nombre: <input type="text" name="nombreprod"><br>
                Precio: <input type="text" name="precio"><br>
                <input type="submit" name="cargar_producto" value="Agregar Producto">
            </form>
        </div>

        <!-- Formulario para buscar producto -->
        <div class="formularios">
            <h2>Buscar Producto por ID</h2>
            <form action="index.php" method="post" onsubmit="return validarFormularioBusqueda(event)">
                ID del Producto: <input type="text" name="id_producto"><br>
                <input type="submit" name="buscar_producto_por_id" value="Buscar Producto">
            </form>
        </div>
    </div>

    <!-- Listado de Clientes -->
    <h2>Clientes Registrados</h2>
    <?php
    if ($clientes->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Calle</th><th>Número</th></tr>";
        while ($row = $clientes->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" . htmlspecialchars($row["Nombre"]) . "</td><td>" . htmlspecialchars($row["Apellido"]) . "</td><td>" . htmlspecialchars($row["Email"]) . "</td><td>" . htmlspecialchars($row["Calle"]) . "</td><td>" . htmlspecialchars($row["Numero"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay clientes registrados";
    }
    ?>

    <!-- Listado de Productos -->
    <h2>Productos Registrados</h2>
    <?php
    if ($productosTodos->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($row = $productosTodos->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["Cod_p"]) . "</td><td>" . htmlspecialchars($row["nombreprod"]) . "</td><td>" . htmlspecialchars($row["Precio"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay productos registrados";
    }
    ?>

    <!-- Detalles de Productos -->
    <h2>Detalles de Productos</h2>
    <?php
    if ($detalles->num_rows > 0) {
        echo "<table><tr><th>Producto</th><th>Descripción</th><th>Origen</th></tr>";
        while ($row = $detalles->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["nombreprod"]) . "</td><td>" . htmlspecialchars($row["Descripcion"]) . "</td><td>" . htmlspecialchars($row["Origen"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay detalles de productos registrados";
    }
    ?>

    <!-- Resultados de Búsqueda de productos -->
    <?php
    if (isset($productos) && $productos instanceof mysqli_result && $productos->num_rows > 0) {
        echo "<h2>Resultados de Búsqueda</h2>";
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($row = $productos->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["Cod_p"]) . "</td><td>" . htmlspecialchars($row["nombreprod"]) . "</td><td>" . htmlspecialchars($row["Precio"]) . "</td></tr>";
        }
        echo "</table>";
    } elseif (isset($productos) && $productos instanceof mysqli_result) {
        echo "<p>No se encontraron productos con ese ID</p>";
    }
    ?>
</body>
</html>
