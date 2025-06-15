<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario - Sistema de Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilo_usuario.css">
</head>
<body>
    <div class="layout">
        <nav class="sidebar">
            <h3 class="sidebar-title">UGEL 16 - BARRANCA</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'index_usuario.php' ? 'active' : '' ?>" href="../usuario/index_usuario.php">
                        <i class="bi bi-house-door-fill"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'subir_documento.php' ? 'active' : '' ?>" href="../usuario/subir_documento.php">
                        <i class="bi bi-cloud-upload-fill"></i> Subir documento
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'documentos_subidos.php' ? 'active' : '' ?>" href="../usuario/documentos_subidos.php">
                        <i class="bi bi-folder-fill"></i> Documentos subidos
                    </a>
                </li>
                <li class="nav-item mt-auto"> <a class="nav-link" href="../includes/logout.php">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </nav>
        <div class="main-content">
            ```
