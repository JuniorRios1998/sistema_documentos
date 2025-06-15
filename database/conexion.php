<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_documentos";
$conexion = new PDO("mysql:host=localhost;dbname=sistema_documentos;charset=utf8", "root", "");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
