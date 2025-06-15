<?php
session_start();
include '../database/conexion.php';

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar datos del formulario
    $id_usuario = $_SESSION['id_usuario']; // Asegúrate de que la sesión contenga este dato
    $folios = intval($_POST['folios']);
    $exp_sisgedo = intval($_POST['exp_sisgedo']);
    $tipo_doc = trim($_POST['tipo_doc']);
    $oficio = trim($_POST['oficio']);
    $asunto = trim($_POST['asunto']);
    $fecha = $_POST['fecha'];

    // Manejo del archivo
    $archivo = $_FILES['documento'];
    $nombre_archivo = basename($archivo['name']);
    $ruta_destino = '../documentos_subidos/' . $nombre_archivo;

    // Validar y mover el archivo
    if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO tb_doc_sisgedo (id_usuario, Folios, Exp_sisgedo, tipo_doc, oficio, Asunto, documento, Fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisssss", $id_usuario, $folios, $exp_sisgedo, $tipo_doc, $oficio, $asunto, $nombre_archivo, $fecha);

        if ($stmt->execute()) {
            echo "<script>alert('Documento subido exitosamente.'); window.location.href='../usuario/documentos_subidos.php';</script>";
        } else {
            echo "<script>alert('Error al guardar en la base de datos.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error al subir el archivo.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../usuario/index_usuario.php';</script>";
}
?>
