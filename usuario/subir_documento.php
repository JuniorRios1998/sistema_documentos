<?php include("../includes/header_usuario.php"); ?>
<link rel="stylesheet" href="../css/subir_documento.css" />


<main class="contenido-centrado">
  <section class="formulario-subida">
    <h2>Subir Documento SISGEDO</h2>
    <form action="../includes/procesar_subida.php" method="POST" enctype="multipart/form-data" class="formulario">
      
      <div class="mb-3">
  <label for="folios" class="form-label">N° de folios</label>
  <input type="number" class="form-control" id="folios" name="folios" min="1" required
         oninput="this.value = this.value.replace(/[^0-9]/g, '')">
</div>


      <div class="mb-3">
        <label for="expediente" class="form-label">N° de Expediente SISGEDO</label>
        <input type="text" class="form-control" id="expediente" name="expediente" required>
      </div>

      <div class="mb-3">
        <label for="tipo_doc" class="form-label">Tipo de Documento</label>
        <select class="form-select" id="tipo_doc" name="tipo_doc" required>
          <option value="">Selecciona una opción</option>
          <option value="Oficio">Oficio</option>
          <option value="Informe">Informe</option>
          <option value="Memorándum">Memorándum</option>
          <option value="Carta">Carta</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="oficio" class="form-label">N° de Oficio</label>
        <input type="text" class="form-control" id="oficio" name="oficio" required>
      </div>

      <div class="mb-3">
        <label for="asunto" class="form-label">Asunto</label>
        <input type="text" class="form-control" id="asunto" name="asunto" required>
      </div>

      <div class="mb-3">
        <label for="fecha" class="form-label">Fecha del documento</label>
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>

      <div class="mb-3">
        <label for="documento" class="form-label">Seleccionar archivo (PDF)</label>
        <input class="form-control" type="file" id="documento" name="documento" accept="application/pdf" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Subir Documento</button>
    </form>
  </section>
</main>
<?php include("../includes/footer_usuario.php"); ?>
