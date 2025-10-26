<?php
session_start();
include("conexion.php");

// =============================================================
// 🔹 VALIDACIÓN DE LOGIN Y SEGURIDAD
// =============================================================
if (isset($_POST["usuario"]) && isset($_POST["contrasena"])) {
    // =============================================================
    // 🔹 1. LIMPIEZA DE DATOS
    // =============================================================
    $Usuario = htmlspecialchars(stripslashes(trim($_POST["usuario"])));
    $Contraseña = htmlspecialchars(stripslashes(trim($_POST["contrasena"])));

    if (empty($Usuario) || empty($Contraseña)) {
        header("Location: index.php?error=Debe llenar todos los campos");
        exit();
    }

    // =============================================================
    // 🔹 2. VERIFICAR USUARIO EN LA BASE DE DATOS
    // =============================================================
    $stmt = $conexion->prepare("SELECT id, Usuario, Nombre, Contraseña FROM usuario WHERE Usuario = ?");
    $stmt->bind_param("s", $Usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        // =============================================================
        // 🔹 3. VERIFICAR CONTRASEÑA
        // =============================================================
        if (password_verify($Contraseña, $row['Contraseña'])) {
            // =============================================================
            // 🔹 4. REGENERAR ID DE SESIÓN
            // =============================================================
            session_regenerate_id(true);

            $_SESSION["id"] = $row["id"];
            $_SESSION["Usuario"] = $row["Usuario"];
            $_SESSION["Nombre"] = $row["Nombre"];

            // =============================================================
            // 🔹 5. CONTROL DE EXPIRACIÓN DE SESIÓN (15s como ejemplo)
            // =============================================================
            $_SESSION['LAST_ACTIVITY'] = time();
            $_SESSION['EXPIRE_TIME'] = 15; // segundos

            header("Location: inicio.php");
            exit();
        } else {
            header("Location: index.php?error=Usuario o contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: index.php?error=Usuario o contraseña incorrecta");
        exit();
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>
