<?php
include("conexion.php");

// =============================================================
// 🔹 VALIDACIÓN Y REGISTRO DE NUEVOS USUARIOS
// =============================================================
if (isset($_POST["registrar"])) {

  // =============================================================
  // 🔹 1. LIMPIEZA DE DATOS
  // =============================================================
  $nombre   = trim($_POST['nombre']);
  $correo   = trim($_POST['correo']);
  $usuario  = trim($_POST['user']);
  $fecha    = trim($_POST['date']);
  $pass     = $_POST['pass'];
  $passr    = $_POST['passr'];

  // =============================================================
  // 🔹 2. VALIDACIONES ESTRICTAS
  // =============================================================

  // Nombre: solo letras y espacios, 3-50 caracteres
  if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,50}$/", $nombre)) {
      echo "<script>alert('Nombre no válido'); window.location='index.php';</script>";
      exit();
  }

  // Usuario: letras, números y guión bajo, 4-20 caracteres
  if (!preg_match("/^[a-zA-Z0-9_]{4,20}$/", $usuario)) {
      echo "<script>alert('Usuario no válido'); window.location='index.php';</script>";
      exit();
  }

  // Correo válido
  if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
      echo "<script>alert('Correo no válido'); window.location='index.php';</script>";
      exit();
  }

  // Contraseña: mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número
  if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $pass)) {
      echo "<script>alert('Contraseña insegura. Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.'); window.location='index.php';</script>";
      exit();
  }

  // Contraseñas coinciden
  if ($pass !== $passr) {
      echo "<script>alert('Las contraseñas no coinciden'); window.location='index.php';</script>";
      exit();
  }

  // Fecha de nacimiento: mayor de 13 años y menor de 100
  $fecha_minima = strtotime('-100 years');
  $fecha_maxima = strtotime('-13 years');
  $fecha_nac = strtotime($fecha);
  if ($fecha_nac < $fecha_minima || $fecha_nac > $fecha_maxima) {
      echo "<script>alert('Fecha de nacimiento no válida'); window.location='index.php';</script>";
      exit();
  }

  // =============================================================
  // 🔹 3. SANITIZAR PARA EVITAR SQL INJECTION
  // =============================================================
  $nombre = mysqli_real_escape_string($conexion, $nombre);
  $correo = mysqli_real_escape_string($conexion, $correo);
  $usuario = mysqli_real_escape_string($conexion, $usuario);
  $fecha = mysqli_real_escape_string($conexion, $fecha);

  // =============================================================
  // 🔹 4. ENCRIPTAR CONTRASEÑA
  // =============================================================
  $contraseña_encriptada = password_hash($pass, PASSWORD_DEFAULT);

  // =============================================================
  // 🔹 5. COMPROBAR USUARIO EXISTENTE
  // =============================================================
  $sqluser = "SELECT id FROM usuario WHERE Usuario = '$usuario'";
  $resultadouser = $conexion->query($sqluser);

  if ($resultadouser->num_rows > 0) {
      echo "<script>alert('El usuario ya existe'); window.location='index.php';</script>";
  } else {
      $sqlusuario = "INSERT INTO usuario(Usuario, Nombre, Correo, Fecha_nacimiento, Contraseña)
                     VALUES ('$usuario', '$nombre', '$correo', '$fecha', '$contraseña_encriptada')";
      if ($conexion->query($sqlusuario)) {
          echo "<script>alert('Registro exitoso'); window.location='index.php';</script>";
      } else {
          echo "<script>alert('Error al registrarse'); window.location='index.php';</script>";
      }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="estilo.css">
</head>

<body class="bg-info d-flex justify-content-center align-items-center vh-100">
  <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem">
    <div class="d-flex justify-content-center logo-box">
      <img src="img/107.jpg" alt="Logo" style="height: 7rem" />
    </div>

    <!-- =========================================================
         🔹 MENSAJE DE SESIÓN EXPIRADA
    ========================================================== -->
    <?php if (isset($_GET["expired"])): ?>
      <p class="text-danger text-center mt-2 fw-semibold">
        Su sesión ha expirado, por favor inicie sesión nuevamente.
      </p>
    <?php endif; ?>

    <!-- =========================================================
         🔹 LOGIN
    ========================================================== -->
    <div id="login-box">
      <div class="text-center fs-1 fw-bold mt-2">Iniciar sesión</div>

      <form action="iniciarsesion.php" method="POST">
        <hr>

        <?php if (isset($_GET["error"])): ?>
          <p class="error text-danger text-center">
            <?php echo htmlspecialchars($_GET["error"]); ?>
          </p>
        <?php endif; ?>

        <hr>

        <div class="input-group mt-4">
          <div class="input-group-text bg-info">
            <img src="img/usuario.svg" alt="usuario" style="height: 1.5rem" />
          </div>
          <input class="form-control bg-light" type="text" name="usuario" placeholder="Usuario" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/contraseña.svg" alt="contraseña" style="height: 0.8rem" />
          </div>
          <input class="form-control bg-light" type="password" name="contrasena" placeholder="Contraseña" required />
        </div>

        <div class="d-flex justify-content-between mt-2">
          <div class="d-flex align-items-center gap-1">
            <input class="form-check-input" type="checkbox" />
            <div class="pt-1" style="font-size: 0.9rem">Recordarme</div>
          </div>
          <div class="pt-1">
            <a href="#" id="show-forgot" class="text-decoration-none text-info fw-semibold fst-italic" style="font-size: 0.9rem">
              ¿Olvidó su contraseña?
            </a>
          </div>
        </div>

        <button type="submit" class="btn btn-info text-white w-100 mt-4 fw-semibold shadow-sm">
          Iniciar Sesión
        </button>

        <div class="d-flex gap-1 justify-content-center mt-2">
          <div>¿No tienes cuenta?</div>
          <a href="#" id="show-signup" class="text-decoration-none text-info fw-semibold">Registrarse</a>
        </div>

        <div class="p-3">
          <div class="border-bottom text-center" style="height: 0.9rem">
            <span class="bg-white px-3">o</span>
          </div>
        </div>

        <div class="btn d-flex gap-2 justify-content-center border mt-3 shadow-sm">
          <img src="img/google.png" alt="google" style="height: 1.6rem" />
          <a href="https://www.google.com/intl/es/account/about/" class="fw-semibold text-secondary text-decoration-none">Continuar con Google</a>
        </div>
      </form>
    </div>

    <!-- =========================================================
         🔹 RECUPERAR CONTRASEÑA
    ========================================================== -->
    <div id="forgot-box" class="d-none">
      <h4 class="text-center mt-3"><i class="fa fa-key"></i> Recuperar Contraseña</h4>
      <p class="text-center mt-3">Ingresa tu correo electrónico para recibir las instrucciones</p>

      <form>
        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/correo.png" alt="correo" style="height: 1.2rem" />
          </div>
          <input type="email" class="form-control bg-light" placeholder="Email" required />
        </div>
        <button type="submit" class="btn btn-danger text-white w-100 mt-4 fw-semibold shadow-sm">Enviar</button>
        <div class="text-center mt-3">
          <a href="#" id="back-to-login1" class="text-decoration-none text-info fw-semibold fst-italic">← Regresar al inicio</a>
        </div>
      </form>
    </div>

    <!-- =========================================================
         🔹 REGISTRO DE NUEVOS USUARIOS
    ========================================================== -->
    <div id="signup-box" class="d-none mt-3">
      <h4 class="text-center mt-2">Registro de Nuevos Usuarios</h4>
      <p class="text-center">Ingresa los datos solicitados:</p>

      <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/usuario.svg" alt="usuario" style="height: 1.2rem" />
          </div>
          <input type="text" class="form-control bg-light" name="user" placeholder="Usuario" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/usuario.svg" alt="nombre" style="height: 1.3rem" />
          </div>
          <input type="text" class="form-control bg-light" name="nombre" placeholder="Nombre Completo" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/correo.png" alt="correo" style="height: 1.2rem" />
          </div>
          <input type="email" class="form-control bg-light" name="correo" placeholder="Correo" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/fecha.apng" alt="fecha" style="height: 1.2rem" />
          </div>
          <input type="date" class="form-control bg-light" name="date" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/contraseña.svg" alt="contraseña" style="height: 0.6rem" />
          </div>
          <input type="password" class="form-control bg-light" name="pass" placeholder="Contraseña" required />
        </div>

        <div class="input-group mt-3">
          <div class="input-group-text bg-info">
            <img src="img/contraseña.svg" alt="repetir" style="height: 0.6rem" />
          </div>
          <input type="password" class="form-control bg-light" name="passr" placeholder="Repetir Contraseña" required />
        </div>

        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="terminos" required />
          <label class="form-check-label" for="terminos">
            Acepto los <a href="#">Términos de uso</a>
          </label>
        </div>

        <button type="submit" name="registrar" class="btn btn-success text-white w-100 mt-4 fw-semibold shadow-sm">Registrar</button>

        <div class="text-center mt-3">
          <a href="#" id="back-to-login2" class="text-decoration-none text-info fw-semibold fst-italic">← Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>

  <!-- =========================================================
       🔹 JAVASCRIPT PARA CAMBIAR VISTAS
  ========================================================== -->
  <script>
    document.getElementById("show-signup").addEventListener("click", e => {
      e.preventDefault();
      document.getElementById("login-box").classList.add("d-none");
      document.getElementById("signup-box").classList.remove("d-none");
    });
    document.getElementById("back-to-login2").addEventListener("click", e => {
      e.preventDefault();
      document.getElementById("signup-box").classList.add("d-none");
      document.getElementById("login-box").classList.remove("d-none");
    });
    document.getElementById("show-forgot").addEventListener("click", e => {
      e.preventDefault();
      document.getElementById("login-box").classList.add("d-none");
      document.getElementById("forgot-box").classList.remove("d-none");
    });
    document.getElementById("back-to-login1").addEventListener("click", e => {
      e.preventDefault();
      document.getElementById("forgot-box").classList.add("d-none");
      document.getElementById("login-box").classList.remove("d-none");
    });
  </script>
</body>
</html>
