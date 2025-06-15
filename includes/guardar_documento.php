<?php
session_start();
require_once "../database/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_doc_sisgedo']) || !is_numeric($_POST['id_doc_sisgedo'])) {
        exit('ID inválido');
    }

    $id = (int) $_POST['id_doc_sisgedo'];
    $folios = $_POST['Folios'];
    $exp = $_POST['Exp_sisgedo'];
    $tipo = $_POST['tipo_doc'];
    $oficio = $_POST['oficio'];
    $asunto = $_POST['Asunto'];
    $fecha = $_POST['Fecha'];

    $stmt = $conn->prepare("UPDATE tb_doc_sisgedo SET Folios=?, Exp_sisgedo=?, tipo_doc=?, oficio=?, Asunto=?, Fecha=? WHERE id_doc_sisgedo=?");
    $stmt->bind_param("ssssssi", $folios, $exp, $tipo, $oficio, $asunto, $fecha, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Documento actualizado correctamente.');
            if (window.opener && !window.opener.closed) {
                window.opener.location.href = '../usuario.documentos_subidos.php';
            }
            window.close();
        </script>";
        exit;
    } else {
        echo "Error al actualizar.";
    }
}
?>
