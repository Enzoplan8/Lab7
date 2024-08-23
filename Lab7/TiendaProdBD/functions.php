<?php
include 'conexion.php';

// Función para cargar un nuevo cliente
function cargarCliente($nombre, $apellido, $email, $calle, $numero) {
    global $conn;
    $sql = "INSERT INTO Cliente (Nombre, Apellido, Email, Calle, Numero)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $calle, $numero);
    if ($stmt->execute()) {
        return "Nuevo cliente agregado con éxito";
    } else {
        return "Error: " . $conn->error;
    }
}

// Función para cargar un nuevo producto
function cargarProducto($nombreprod, $precio) {
    global $conn;
    $sql = "INSERT INTO Producto (nombreprod, Precio)
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $nombreprod, $precio);
    if ($stmt->execute()) {
        return "Nuevo producto agregado con éxito";
    } else {
        return "Error: " . $conn->error;
    }
}

// Función para leer todos los clientes
function leerClientes() {
    global $conn;
    $sql = "SELECT * FROM Cliente";
    $result = $conn->query($sql);
    return $result;
}

// Función para leer todos los productos
function leerProductos() {
    global $conn;
    $sql = "SELECT * FROM Producto";
    $result = $conn->query($sql);
    return $result;
}

// Función para leer los detalles de los productos
function leerDetalles() {
    global $conn;
    $sql = "SELECT Producto.nombreprod, Detalle.Descripcion, Detalle.Origen 
            FROM Detalle 
            INNER JOIN Producto ON Detalle.Cod_p = Producto.Cod_p";
    $result = $conn->query($sql);
    return $result;
}

// Función para buscar productos por ID
function buscarProductoPorID($id) {
    global $conn;
    $sql = "SELECT * FROM Producto WHERE Cod_p = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

