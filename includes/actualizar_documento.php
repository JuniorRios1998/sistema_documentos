<?php
// includes/actualizar_documento.php
session_start();
require_once 'db_connection.php'; // Tu archivo de conexión a la BD

header('Content-Type: application/json'); // La respuesta será JSON
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_usuario'])) {
        $response['message'] = 'Usuario no autenticado.';
        echo json_encode($response);
        exit;
    }

    $user_id = $_SESSION['id_usuario'];

    // 1. Obtener y sanear los datos
    $id_doc_sisgedo = filter_input(INPUT_POST, 'id_doc_sisgedo', FILTER_VALIDATE_INT);
    $oficio_sisgedo = filter_input(INPUT_POST, 'oficio_sisgedo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $asunto_sisgedo = filter_input(INPUT_POST, 'asunto_sisgedo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // 2. Validar los datos
    if (!$id_doc_sisgedo) {
        $response['message'] = 'ID de documento no válido.';
        echo json_encode($response);
        exit;
    }
    if (empty($oficio_sisgedo) || empty($asunto_sisgedo)) {
        $response['message'] = 'Oficio y Asunto son campos obligatorios.';
        echo json_encode($response);
        exit;
    }

    try {
        // 3. Verificar que el documento pertenece al usuario logueado (SEGURIDAD CRÍTICA)
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM documentos_sisgedo WHERE id_doc_sisgedo = ? AND id_usuario = ?");
        $stmt_check->execute([$id_doc_sisgedo, $user_id]);
        if ($stmt_check->fetchColumn() == 0) {
            $response['message'] = 'No tienes permiso para editar este documento o el documento no existe.';
            echo json_encode($response);
            exit;
        }

        // 4. Preparar y ejecutar la consulta de actualización
        $stmt = $pdo->prepare("UPDATE documentos_sisgedo 
                               SET oficio_sisgedo = ?, asunto_sisgedo = ? 
                               WHERE id_doc_sisgedo = ? AND id_usuario = ?");
        $stmt->execute([$oficio_sisgedo, $asunto_sisgedo, $id_doc_sisgedo, $user_id]);

        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Documento actualizado correctamente.';
        } else {
            // Esto puede ocurrir si los datos enviados son idénticos a los existentes
            $response['message'] = 'No se realizaron cambios en el documento.';
        }

    } catch (PDOException $e) {
        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
    }

} else {
    $response['message'] = 'Método de solicitud no permitido.';
}

echo json_encode($response);
exit;
?>