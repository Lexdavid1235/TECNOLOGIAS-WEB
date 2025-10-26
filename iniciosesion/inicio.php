<?php
session_start();

// Duración de la sesión: 15 segundos
$duracion = 15;

// Si no hay sesión activa, regresar al index
if (!isset($_SESSION["Usuario"])) {
    header("Location: index.php?error=Sesión expirada");
    exit();
}

// Inicializar tiempo de inicio si no existe
if (!isset($_SESSION['tiempo_inicio'])) {
    $_SESSION['tiempo_inicio'] = time();
} else {
    // Verificar si la sesión ha expirado
    if (time() - $_SESSION['tiempo_inicio'] > $duracion) {
        session_unset();
        session_destroy();
        header("Location: index.php?error=Sesión expirada");
        exit();
    }
}

// Regenerar ID de sesión para seguridad
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <h1>¡Bienvenido, <?php echo htmlspecialchars($_SESSION["Nombre"]); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>
        <p class="text-muted">Serás redirigido al inicio cuando expire la sesión (15 segundos).</p>
        <a href="cerrarsesion.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
    </div>

    <!-- Redirección automática con JavaScript como refuerzo -->
    <script>
        setTimeout(function() {
            window.location.href = "cerrarsesion.php";
        }, 15000); // 15000 ms = 15 segundos
    </script>
</body>
</html>