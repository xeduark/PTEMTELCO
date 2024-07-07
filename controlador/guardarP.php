<?php
if (!empty($_POST["btn-registrar"])) {
    //IMPORTANTE TRAER LOS DATOS POR SU NAME
    if (!empty($_POST["nombre"]) & !empty($_POST["dni"]) & !empty($_POST["fecha"]) & !empty($_POST["direccion"]) & !empty($_POST["telefono"]) & !empty($_POST["correo"])) {
        //AHORA RECOJEMOS CADA DATO EN UNA VARIABLE
        $id=$_POST["id"];
        $nombre=$_POST["nombre"];
        $dni=$_POST["dni"];
        $fecha=$_POST["fecha"];
        $direccion=$_POST["direccion"];
        $telefono=$_POST["telefono"];
        $correo=$_POST["correo"];
        //AHORA LLAMAMOS LA SENTENCIA SQL PARA GUARDAR LOS DATOS INGRESADOS EN LA TABLA PERSONAS Y AQUI RECOJIMOS EL ID TOMADO EN EL INPUT 
        $sql=$conn->query(" UPDATE tbl_personas SET NOMBRE='$nombre',DNI='$dni',FECNAC='$fecha',DIR='$direccion',TFNO='$telefono',CORREO='$correo' WHERE ID=$id");
        if ($sql->rowCount() > 0) {
            header("location:personas.php");
            exit(); // Detener la ejecución para evitar mensajes de error adicionales
        } else {
            echo "<div class='alert alert-danger'>No se guardó correctamente</div>";
        }
        
    }else{
        echo "<div class='alert alert-warning'>campos vacios</div>";
    }
}
?>
