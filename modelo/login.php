<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
  header('Location: /PTEMTELCO'); // Redireccionar si ya hay una sesión activa
  exit; // Detener la ejecución adicional
}

require '../controlador/database.php';

$message = ''; // Variable para mensajes al usuario

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  // Obtener los datos del usuario por su correo electrónico
  $records = $conn->prepare('SELECT id, CORREO, CONTRASENA FROM admin WHERE CORREO = :email');
  $records->bindParam(':email', $_POST['email']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  // Verificar si se encontró un usuario y la contraseña coincide
  if ($results && password_verify($_POST['password'], $results['CONTRASENA'])) {
    $_SESSION['usuario_id'] = $results['id']; // Iniciar sesión para este usuario
    header("Location: ../vista/personas.php"); // Redireccionar a la página después del inicio de sesión
    exit; // Detener la ejecución adicional
  } else {
    $message = 'Lo siento, sus datos no coinciden'; // Mensaje de error si las credenciales no son válidas
  }
}
?>
<!DOCTYPE html>
<html lang="Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/login.css">
    <link rel="stylesheet" href="../estilos/popuplog.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="../imagenes/logo.png">
</head>

<body>
    <div class="wrapper">
        <h1>Bienvenido!</h1>
        <form action="login.php" method="POST">
            <div class="input-box">
                <input name="email" type="text" placeholder="Ingrese su correo">
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input name="password" type="password" placeholder="Ingrese su contraseña">
                <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Recordar</label>
                <a href="#" id="forgot-password-link">Olvidaste la contraseña?</a>
            </div>
            <div class="register-link">
                <p>No tienes una cuenta? <a href="registro.php">Registrate</a></p>
            </div>
            <br>
            <input class="btn" type="submit" value="Enviar">
        </form>
    </div>

    <div class="popup popup--icon -error js_error-popup" id="error-popup">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                Error
            </h3>
            <p id="popup-message"></p>
            <p>
                <button class="button button--error" data-for="js_error-popup">OK</button>
            </p>
        </div>
    </div>

    <div class="popup popup--icon -question js_question-popup" id="question-popup">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                ¿Olvidaste tu contraseña?
            </h3>
            <form action="password_reset.php" method="POST">
                <div class="input-boxRecup">
                    <input class="inpup" name="reset_email" type="email" placeholder="Ingrese su correo electrónico" required>
                    <i class="bx bxs-envelope"></i>
                </div>
                <p>
                    <button type="submit" class="button button--warning">Enviar</button>
                    <button type="button" class="button button--warning" id="close-question-popup">Cerrar</button>
                </p>
            </form>
        </div>
    </div>

    <?php if (!empty($message)) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var popup = document.getElementById('error-popup');
                var popupMessage = document.getElementById('popup-message');
                popupMessage.textContent = "<?php echo addslashes($message); ?>";
                popup.classList.add('popup--visible');
            });
        </script>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar cierre del popup de error
            var errorButtons = document.querySelectorAll('.button--error');
            errorButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var popup = document.getElementById('error-popup');
                    popup.classList.remove('popup--visible');
                });
            });

            // Manejar apertura del popup de pregunta
            var forgotPasswordLink = document.getElementById('forgot-password-link');
            forgotPasswordLink.addEventListener('click', function(event) {
                event.preventDefault();
                var popup = document.getElementById('question-popup');
                popup.classList.add('popup--visible');
            });

            // Manejar cierre del popup de pregunta
            var questionCloseButton = document.getElementById('close-question-popup');
            questionCloseButton.addEventListener('click', function() {
                var popup = document.getElementById('question-popup');
                popup.classList.remove('popup--visible');
            });
        });
    </script>
</body>

</html>