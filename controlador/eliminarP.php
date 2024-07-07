<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conn->prepare("DELETE FROM tbl_personas WHERE ID = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    
    if ($sql->rowCount() > 0) {
        echo '<div class="alert alert-success">Eliminado correctamente</div>';
    } else {
        echo '<div class="alert alert-danger">No se encontró el registro para eliminar</div>';
    }
}
?>
