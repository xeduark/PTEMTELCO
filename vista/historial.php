<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador Dinámico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Buscar Personas</h2>
    <input class="form-control mb-4" id="search" type="text" placeholder="Buscar...">
    <div class="form-group has-search">
    <span class="fa fa-search form-control-feedback"></span>
    <input type="text" class="form-control" placeholder="Search">
  </div>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Los datos se cargarán aquí -->
            <?php
            include "../controlador/database.php";
            $sql = $conn->query("SELECT * FROM tbl_personas");
            while ($datos = $sql->fetchObject()) {
                echo "<tr>";
                echo "<td>{$datos->id}</td>";
                echo "<td>{$datos->NOMBRE}</td>";
                echo "<td>{$datos->DNI}</td>";
                echo "<td>{$datos->FECNAC}</td>";
                echo "<td>{$datos->DIR}</td>";
                echo "<td>{$datos->TFNO}</td>";
                echo "<td>{$datos->CORREO}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //AQUI SE LE DA DINAMISMO AL BUSCADOR CON JQUERY PARA FILTRAR RESULTADOS
    $(document).ready(function(){
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
