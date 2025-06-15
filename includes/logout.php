<?php
session_start(); // Inicia la sesión si no se ha iniciado
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige al login
header("Location: ../login.html");
exit();
?>
