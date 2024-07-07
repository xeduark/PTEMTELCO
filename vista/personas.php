<?php
session_start();

require '../controlador/database.php';

if (isset($_SESSION['usuario_id'])) {

  $records = $conn->prepare('SELECT id, CORREO, CONTRASENA FROM admin WHERE id = :id');
  $records->bindParam(':id', $_SESSION['usuario_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  if ($results) {

    $user = $results;
  }
} else {
  header("Location: ../modelo/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../estilos/load.css">
    <link rel="stylesheet" href="../estilos/menu.css">
    <link rel="stylesheet" href="../estilos/personas.css">
    <link rel="icon" type="image/png" href="../imagenes/logo.png">
    <style>
        /* Estilos para ocultar solo el contenido principal */
        #main-content {
            display: none;
        }
    </style>
</head>
<body>
    <!--ESTO ES PARA PREGUNTAR ANTES DE ELIMINAR-->
    <script>
        function eliminar() {
            var respuesta = confirm("¿Estás seguro de eliminar esta persona?");
            return respuesta;
        }
    </script>
    <?php
    // Conexión a la base de datos
    include "../controlador/database.php";
    ?>

    <!--CARGA-->
    <div class="load">
        <hr />
        <hr />
        <hr />
        <hr />
    </div>

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
                <p><?= $user['CORREO']; ?></p>
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

        <div class="col-10 p-4 content-tabla">
            <?php include "../controlador/eliminarP.php"; ?>

            <!-- Buscador Dinámico -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search" placeholder="Buscar..." aria-label="Buscar" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table id="tablaPersonas" class="table">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">DNI</th>
                            <th scope="col">FECHA DE NAC</th>
                            <th scope="col">DIRECCIÓN</th>
                            <th scope="col">TELÉFONO</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">
                                <a href="../vista/agregarP.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> AÑADIR</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php
                        // Conexión a la tabla de personas
                        $sql = $conn->query("SELECT * FROM tbl_personas");
                        // Condicional para recorrer todos los registros
                        while ($datos = $sql->fetchObject()) { ?>
                            <tr>
                                <td><?= $datos->id ?></td>
                                <td><?= $datos->NOMBRE ?></td>
                                <td><?= $datos->DNI ?></td>
                                <td><?= $datos->FECNAC ?></td>
                                <td><?= $datos->DIR ?></td>
                                <td><?= $datos->TFNO ?></td>
                                <td><?= $datos->CORREO ?></td>
                                <td>
                                    <a href="../vista/editPersonas.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a onclick="return eliminar()" href="personas.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="text-end mb-3">
                    <button onclick="exportarExcel()" class="btn btn-sm btn-success"><i class="fa-solid fa-file-excel"></i> Exportar a Excel</button>
                </div>
            </div>

            <!-- Espacio para mostrar los horarios -->
            <div id="horariosContainer">
                <h4 style="color: blue;">Horarios Disponibles:</h4>
                <ul id="horariosList"></ul>
            </div>
        </div>
    </div>

    <script src="../js/menu.js"></script>
    <script src="../js/horarios.js"></script>
    <script>
        // Espera 3 segundos y luego muestra el contenido principal
        setTimeout(function() {
            document.querySelector('.load').style.display = 'none'; // Oculta la animación de carga
            document.getElementById('main-content').style.display = 'block'; // Muestra el contenido principal
        }, 1000); // segundos
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script>
        // Función para exportar a Excel
        function exportarExcel() {
            const wb = XLSX.utils.table_to_book(document.getElementById('tablaPersonas'), { sheet: "Sheet JS" });
            XLSX.writeFile(wb, 'personas.xlsx');
        }
    </script>
    <script>
        // Función para el filtro dinámico
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
