<?php
session_start();
include '../database/conexion.php';  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = "SELECT u.id_usuario, u.dni_usuario, u.pass, r.rol
              FROM tb_usuario u
              JOIN tb_roles r ON u.id_usuario = r.id_usuario
              WHERE u.dni_usuario = ? AND u.pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuarioData = $resultado->fetch_assoc();
        $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
        $_SESSION['rol'] = $usuarioData['rol'];

        if ($usuarioData['rol'] == 0) {
            header("Location: ../admin/index_admin.php");
        } else {
            header("Location: ../usuario/index_usuario.php");
        }
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../login.html';</script>";
    }
} else {
    http_response_code(405);
    echo "Método no permitido.";
}
?>
