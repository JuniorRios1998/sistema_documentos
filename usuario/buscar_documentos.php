<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(403);
    exit('No autorizado');
}

require_once "../database/conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "SELECT * FROM tb_doc_sisgedo WHERE id_usuario = ?";

if ($search !== "") {
    $sql .= " AND (oficio LIKE ? OR Asunto LIKE ?)";
}

$stmt = $conn->prepare($sql);

if ($search !== "") {
    $search_param = "%$search%";
    $stmt->bind_param("iss", $id_usuario, $search_param, $search_param);
} else {
    $stmt->bind_param("i", $id_usuario);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<?php if ($result && $result->num_rows > 0): ?>
<div class="table-responsive">
  <table class="table table-striped table-hover" style="background:#fff;">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Folios</th>
        <th>Exp. Sisgedo</th>
        <th>Tipo Documento</th>
        <th>Oficio</th>
        <th>Asunto</th>
        <th>Fecha</th>
        <th>Ver</th>
        <th>Editar</th>

      </tr>
    </thead>
    <tbody>
 <?php while ($row = $result->fetch_assoc()): ?>
<tr>
  <td><?php echo $row['id_doc_sisgedo']; ?></td>
  <td><?php echo $row['Folios']; ?></td>
  <td><?php echo $row['Exp_sisgedo']; ?></td>
  <td><?php echo htmlspecialchars($row['tipo_doc']); ?></td>
  <td><?php echo htmlspecialchars($row['oficio']); ?></td>
  <td><?php echo htmlspecialchars($row['Asunto']); ?></td>
  <td><?php echo $row['Fecha']; ?></td>
  <td>
    <a href="../documentos_subidos/<?php echo htmlspecialchars($row['documento']); ?>" target="_blank" title="Ver documento">
      <i class="bi bi-eye"></i>
    </a>
  </td>
  <td>
  <a href="../includes/editar_documento.php?id=<?php echo $row['id_doc_sisgedo']; ?>" onclick="abrirVentanaEditar(<?php echo $row['id_doc_sisgedo']; ?>); return false;" title="Editar documento">
    <i class="bi bi-pencil-square text-warning"></i>
  </a>
</td>


</tr>
<?php endwhile; ?>

    </tbody>
  </table>
</div>
<?php else: ?>
<p class="text-center text-muted mt-4">No se encontraron documentos.</p>
<?php endif; ?>
<script>
function abrirVentanaEditar(id) {
    const url = `../includes/editar_documento.php?id=${id}`;
    window.open(url, 'EditarDocumento', 'width=900,height=700,resizable=yes,scrollbars=yes');
}
</script>
