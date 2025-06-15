<?php 
include("../includes/header_usuario.php");
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../usuario/index_usuario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Documentos Subidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/documentos_subidos.css" />
</head>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Editar Documento</h5>
        <!-- Ejemplo dentro de una fila de tabla -->
<button class="btn btn-sm btn-warning btn-editar" data-id="<?= $row['id_doc_sisgedo'] ?>">
  Editar
</button>

      </div>
      <div class="modal-body" id="contenidoEditar">
        <div class="text-center py-4">Cargando formulario...</div>
      </div>
    </div>
  </div>
</div>

<body>

<div class="container form-box mt-5 mb-5 p-4 shadow rounded" style="max-width: 900px;">
    <h2 class="mb-4 text-center">Documentos Subidos</h2>

    <form id="searchForm" class="mb-4" onsubmit="return false;">
        <input 
            type="text" 
            id="searchInput" 
            name="search" 
            class="form-control" 
            placeholder="Buscar por oficio o asunto" 
            autocomplete="off" 
        />
    </form>

    <div id="resultados"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const searchInput = document.getElementById('searchInput');
    const resultadosDiv = document.getElementById('resultados');
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar')); // Instancia el modal

    async function cargarDocumentos(search = '') {
        try {
            const response = await fetch(`buscar_documentos.php?search=${encodeURIComponent(search)}`);
            if (!response.ok) throw new Error('Error en la respuesta');
            const html = await response.text();
            resultadosDiv.innerHTML = html;
        } catch (error) {
            resultadosDiv.innerHTML = '<p class="text-danger text-center mt-4">Error al cargar resultados.</p>';
            console.error(error);
        }
    }

    cargarDocumentos();

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        cargarDocumentos(query);
    });

    // Delegación de eventos para el botón de editar
    document.addEventListener('click', async function (e) {
        if (e.target.closest('.btn-editar')) { // Usar closest para asegurar que funciona si clickea el icono
            const btn = e.target.closest('.btn-editar');
            const id = btn.dataset.id;
            const modalBody = document.getElementById('contenidoEditar');
            modalBody.innerHTML = '<div class="text-center py-4">Cargando formulario...</div>';

            try {
                const response = await fetch(`includes/editar_documento.php?id=${id}`);
                if (!response.ok) throw new Error('Error al cargar el formulario de edición.');
                const html = await response.text();
                modalBody.innerHTML = html;
                modalEditar.show(); // Mostrar el modal
            } catch (err) {
                modalBody.innerHTML = '<p class="text-danger">No se pudo cargar el formulario: ' + err.message + '</p>';
                console.error("Error al cargar formulario de edición:", err);
            }
        }
    });

    // Manejar el envío del formulario dentro del modal (delegación de eventos)
    document.addEventListener('submit', async function (e) {
        if (e.target && e.target.id === 'formEditarDocumento') {
            e.preventDefault(); // Prevenir el envío normal del formulario

            const form = e.target;
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json(); // Esperar la respuesta JSON

                if (data.success) {
                    alert(data.message);
                    modalEditar.hide(); // Ocultar el modal
                    cargarDocumentos(searchInput.value.trim()); // Recargar la tabla con la búsqueda actual
                } else {
                    alert('Error al guardar: ' + data.message);
                }
            } catch (error) {
                console.error('Error en el envío del formulario:', error);
                alert('Ocurrió un error al intentar guardar los cambios: ' + error.message);
            }
        }
    });
</script>