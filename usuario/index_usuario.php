<?php include("../includes/header_usuario.php"); ?>
<main class="contenido-centrado">
  <section class="bienvenida">
    <h2>¡Bienvenido al SISTEMA DE DOCUMENTOS!</h2>
    <p>Desde este panel puedes gestionar fácilmente la subida y consulta de tus documentos.</p>
  </section>

  <section class="acciones-usuario">
    <a href="../usuario/subir_documento.php" class="cuadro-opcion">
      <div class="icono">📤</div>
      <h3>Subir Documentos</h3>
    </a>
    
    <a href="../usuario/documentos_subidos.php" class="cuadro-opcion">
      <div class="icono">📁</div>
      <h3>Documentos Subidos</h3>
    </a>
  </section>
</main>
<?php include("../includes/footer_usuario.php"); ?>
