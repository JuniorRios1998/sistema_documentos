<?php
// includes/editar_documento.php
session_start();
require_once '../database/conexion.php'; // Tu archivo de conexión a la BD

if (!isset($_SESSION['id_usuario'])) {
    echo '<p class="text-danger">Debes iniciar sesión para editar documentos.</p>';
    exit;
}

$user_id = $_SESSION['id_usuario'];
$document_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$document_id) {
    echo '<p class="text-danger">ID de documento no válido.</p>';
    exit;
}

try {
    // Obtener los datos del documento y verificar que pertenece al usuario
    $stmt = $pdo->prepare("SELECT id_doc_sisgedo, oficio_sisgedo, asunto_sisgedo 
                           FROM documentos_sisgedo 
                           WHERE id_doc_sisgedo = ? AND id_usuario = ?");
    $stmt->execute([$document_id, $user_id]);
    $documento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$documento) {
        echo '<p class="text-danger">Documento no encontrado o no tienes permiso para editarlo.</p>';
        exit;
    }

    // Si el documento se encontró y pertenece al usuario, mostrar el formulario
?>
<form id="formEditarDocumento" method="POST" action="includes/actualizar_documento.php">
    <input type="hidden" name="id_doc_sisgedo" value="<?= htmlspecialchars($documento['id_doc_sisgedo']) ?>">
    
    <div class="mb-3">
        <label for="editOficio" class="form-label">Número de Oficio:</label>
        <input type="text" class="form-control" id="editOficio" name="oficio_sisgedo" 
               value="<?= htmlspecialchars($documento['oficio_sisgedo']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="editAsunto" class="form-label">Asunto:</label>
        <textarea class="form-control" id="editAsunto" name="asunto_sisgedo" rows="4" 
                  required><?= htmlspecialchars($documento['asunto_sisgedo']) ?></textarea>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>

<?php
} catch (PDOException $e) {
    echo '<p class="text-danger">Error de base de datos: ' . $e->getMessage() . '</p>';
}
?>