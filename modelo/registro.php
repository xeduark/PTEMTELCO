<?php
require '../controlador/database.php';

$message = '';

if (!empty($_POST["nombre"]) && !empty($_POST["dni"]) && !empty($_POST["fecha"]) && !empty($_POST["direccion"]) && !empty($_POST["telefono"]) && !empty($_POST["correo"]) && !empty($_POST["password"])) {
        
    // ALMACENAR Y SANITIZAR LOS CAMPOS
    $nombre = htmlspecialchars($_POST["nombre"]);
    $dni = htmlspecialchars($_POST["dni"]);
    $fecha = htmlspecialchars($_POST["fecha"]);
    $direccion = htmlspecialchars($_POST["direccion"]);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hashear la contraseña

    try {
        // Insertar en la tabla admin
        $stmt_admin = $conn->prepare("INSERT INTO admin (DNI, NOMBRE, FECNAC, DIR, TFNO, CORREO, CONTRASENA) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_admin->execute([$dni, $nombre, $fecha, $direccion, $telefono, $correo, $password]);
        
        if ($stmt_admin->rowCount() > 0) {
            $message = '<span style="color: white;text-align: center; font-size: 25px; font-weight: bold;">Admin creado correctamente</span>';
        } else {
            $message = 'Lo siento, no se pudo crear el administrador, verifique nuevamente';
        }
    } catch (PDOException $e) {
        $message = 'Error al ejecutar la consulta: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/registro.css">
    <link rel="icon" type="image/png" href="../imagenes/logo.png">
</head>

<body>
    <div class="login-box">
        <h2>Registra un Administrador</h2>
        <div class="login-link">
            <p>O <a href="login.php">Inicia sesión</a></p>
        </div>
        <br><br>
        <!-- Mostrar mensajes aquí -->
        <form id="registrationForm" action="registro.php" method="POST">
            <!-- Método POST es importante para enviar la información del formulario -->
            <div class="user-box">
                <input name="nombre" type="text" required="">
                <label>Ingrese su nombre</label>
            </div>
            <div class="user-box">
                <input name="dni" type="number" required="">
                <label>Ingrese su identificación</label>
            </div>
            <div class="user-box">
                <input name="fecha" type="date" required="">
                <label>Ingrese su fecha de nacimiento</label>
            </div>
            <div class="user-box">
                <input name="direccion" type="text" required="">
                <label>Ingrese su dirección</label>
            </div>
            <div class="user-box">
                <input name="telefono" type="number" required="">
                <label>Ingrese su teléfono</label>
            </div>
            <div class="user-box">
                <input name="correo" id="email" type="email" required="">
                <label>Ingrese su correo</label>
            </div>
            <div class="user-box">
                <input name="password" id="password" type="password" required="">
                <label>Ingrese su contraseña</label>
            </div>
            <button type="submit" class="custom-btn btn" name="btn-registrar"><span>Enviar</span></button>
            <div id="mensaje" style="display:none;"><?php echo $message; ?></div>
        </form>
    </div>

    <script src="../js/registro.js"></script>
    <script src="../js/mensaje.js"></script>

</body>

</html>
