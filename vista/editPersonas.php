<?php

include "../controlador/database.php";
//TOMAR EL ID

$id = $_GET["id"];
//SENTENCIA SQL PARA ALMACENAR
$sql = $conn->query("SELECT * FROM tbl_personas WHERE id=$id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../estilos/load.css">
    <link rel="stylesheet" href="../estilos/menu.css">
    <link rel="stylesheet" href="../estilos/editarP.css">
    <link rel="icon" type="image/png" href="../imagenes/logo.png">

</head>

<body>

    <!--INICIO NAVBAR-->
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
    <!--FIN NAVBAR-->

    <!--MENU HAMBURGUESA-->
    <div id="main-content">
        <div class="hamburger">
            <div class="_layer -top"></div>
            <div class="_layer -mid"></div>
            <div class="_layer -bottom"></div>
        </div>
    </div>
        <form class="col-4 p-2" method="POST">
            <h5 class="text-center alert alert-secondary">Modificar registros</h5>
                <!--ESTE INPUT ES FUNDAMENTAL PARA LLEVAR EL ID A EL CONTROLADOR DE GUARDAR-->
            <input type="hidden" name="id" value="<?= $_GET["id"] ?>">

            <?php
            //AQUI ESTAMOS LLAMANDO LAS FUNCIONES PARA EL BOTON QUE VAN A ESTAR EN CONTROLADOR
            include "../controlador/guardarP.php";
            //RECORRER TODOS LOS DATOS
            while ($datos = $sql->fetchObject()) { ?>
                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                    <!--AQUI ES IMPORTANTE QUE SE TRAIGA EL DATO TAL CUAL ESTA EN EN LA BD-->
                    <input type="text" class="form-control" name="nombre" value="<?= $datos->NOMBRE ?>">
                </div>
                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">Identificación</label>
                    <input type="text" class="form-control" name="dni" value="<?= $datos->DNI ?>">
                </div>
                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="fecha" value="<?= $datos->FECNAC ?>">
                </div>
                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">dirección</label>
                    <input type="text" class="form-control" name="direccion" value="<?= $datos->DIR ?>">
                </div>

                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">teléfono</label>
                    <input type="number" class="form-control" name="telefono" value="<?= $datos->TFNO ?>">
                </div>
                <div class="mb-1">
                    <label for="exampleInputEmail1" class="form-label">correo</label>
                    <input type="email" class="form-control" name="correo" value="<?= $datos->CORREO ?>">
                </div>
            <?php }
            ?>
            <button type="submit" class="btn btn-primary" name="btn-registrar" value="ok">Guardar</button>
        </form>
    <script src="../js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>