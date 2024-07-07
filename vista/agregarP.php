<?php
include "../controlador/database.php";

// Variable para mensajes al usuario
$message = '';

// Procesar el formulario cuando se envíe
if (isset($_POST['btn-registrar'])) {
    // Validar y obtener los datos del formulario
    $nombre = htmlspecialchars($_POST["nombre"]);
    $dni = htmlspecialchars($_POST["dni"]);
    $fecha = htmlspecialchars($_POST["fecha"]);
    $direccion = htmlspecialchars($_POST["direccion"]);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);

    // Validación básica (puedes agregar más validaciones según necesites)
    if (!empty($nombre) && !empty($dni) && !empty($fecha) && !empty($direccion) && !empty($telefono) && !empty($correo)) {
        try {
            // Verificar si el DNI ya existe
            $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_personas WHERE DNI = ?");
            $stmt->execute([$dni]);
            $dniExists = $stmt->fetchColumn();

            if ($dniExists) {
                $message = "<div class='alert alert-danger'>El DNI ya existe. Por favor, verifique nuevamente.</div>";
            } else {
                // Preparar la consulta SQL para insertar en tbl_personas
                $stmt = $conn->prepare("INSERT INTO tbl_personas (NOMBRE, DNI, FECNAC, DIR, TFNO, CORREO) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $dni, $fecha, $direccion, $telefono, $correo]);
                
                // Verificar si se insertó correctamente
                if ($stmt->rowCount() > 0) {
                    $message = "<div class='alert alert-success'>Persona agregada correctamente</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Error al agregar la persona, verifique nuevamente</div>";
                }
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Error al ejecutar la consulta: " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Por favor complete todos los campos</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../estilos/load.css">
    <link rel="stylesheet" href="../estilos/menu.css">
    <link rel="stylesheet" href="../estilos/agregarP.css">
    <link rel="icon" type="image/png" href="../imagenes/logo.png">
</head>

<body>

    <!-- INICIO NAVBAR -->
    <div class="nav" id="main-nav">
        <input type="checkbox" id="nav-check">
        <div class="nav-btn">
            <label for="nav-check">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>

        <div class="nav-links">
            <a href="#" target="_blank">Centro de ayuda</a>
            <a href="/Modelo/config.php" target="_blank"><i class="fas fa-cog"></i></a>
            <a href="#" target="_blank"><i class="fa-solid fa-volume-off"></i></a>
            <a href="#" target="_blank"><i class="fa-regular fa-bell"></i></a>
            <img class="user-profile" src="../imagenes/user2.png" alt="">
            <?php if (!empty($user)) : ?>
                <p><?= $user['email']; ?>
                <?php else : ?>
                <?php endif; ?>
        </div>
    </div>
    <!-- FIN NAVBAR -->

    <!-- MENU HAMBURGUESA -->
    <div id="main-content">
        <div class="hamburger">
            <div class="_layer -top"></div>
            <div class="_layer -mid"></div>
            <div class="_layer -bottom"></div>
        </div>
    </div>

    <div class="col-10 p-4 content-form">
        <form class="col-4 p-2" method="POST">
            <h5 class="text-center alert alert-secondary">Agregar Persona</h5>

            <!-- Mostrar mensajes aquí -->
            <?= $message; ?>

            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Identificación</label>
                <input type="text" class="form-control" name="dni" required>
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" name="fecha" required>
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Teléfono</label>
                <input type="number" class="form-control" name="telefono" required>
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-registrar">Guardar</button>
        </form>
    </div>

    <script src="../js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // Espera 3 segundos y luego muestra el contenido principal
        setTimeout(function() {
            document.querySelector('.load').style.display = 'none'; // Oculta la animación de carga
            document.getElementById('main-content').style.display = 'block'; // Muestra el contenido principal
        }, 1000); // segundos
    </script>
</body>

</html>
