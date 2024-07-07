# Proyecto: Gestión de Personas

## Configuración Inicial

1. **Configuración del entorno de desarrollo**
   - Instalación y configuración de servidor web (Apache, Nginx, etc.).
   - Instalación de PHP.
   - Instalación de MySQL.
   - Instalación de herramientas adicionales (phpMyAdmin, etc.).

2. **Creación de la base de datos y tablas**
   - Crear la base de datos `ptemtelco`.
   - Crear la tabla `tbl_personas`:
     ```sql
     CREATE TABLE `tbl_personas` (
       `id` int(11) NOT NULL AUTO_INCREMENT,
       `DNI` varchar(10) DEFAULT NULL,
       `NOMBRE` varchar(100) DEFAULT NULL,
       `FECNAC` date DEFAULT NULL,
       `DIR` varchar(255) DEFAULT NULL,
       `TFNO` int(11) DEFAULT NULL,
       `CORREO` varchar(255) DEFAULT NULL,
       PRIMARY KEY (`id`)
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
     ```
   - Crear la tabla `admin`:
     ```sql
     CREATE TABLE `admin` (
       `id` int(11) NOT NULL AUTO_INCREMENT,
       `DNI` varchar(10) DEFAULT NULL,
       `NOMBRE` varchar(100) DEFAULT NULL,
       `FECNAC` date DEFAULT NULL,
       `DIR` varchar(255) DEFAULT NULL,
       `TFNO` int(11) DEFAULT NULL,
       `CORREO` varchar(255) DEFAULT NULL,
       `CONTRASENA` varchar(255) DEFAULT NULL,
       PRIMARY KEY (`id`)
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
     ```

## Conexión a la Base de Datos

3. **Clase PHP para manejar la conexión a la base de datos**
   - Crear un archivo `database.php` con la siguiente clase:
     ```php
     <?php
     class Database {
         private $host = 'localhost';
         private $db_name = 'ptemtelco';
         private $username = 'root';
         private $password = '';
         public $conn;

         public function getConnection() {
             $this->conn = null;

             try {
                 $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                 $this->conn->exec("set names utf8");
             } catch(PDOException $exception) {
                 echo "Connection error: " . $exception->getMessage();
             }

             return $this->conn;
         }
     }
     ?>
     ```

## Autenticación

4. **Sistema de login para la autenticación de usuarios**
   - Crear un archivo `login.php` con el siguiente contenido:
     ```php
     <?php
     session_start();

     require '../controlador/database.php';
     $database = new Database();
     $conn = $database->getConnection();

     if (isset($_SESSION['usuario_id'])) {
         header('Location: /PTEMTELCO');
         exit;
     }

     $message = '';

     if (!empty($_POST['email']) && !empty($_POST['password'])) {
         $records = $conn->prepare('SELECT id, CORREO, CONTRASENA FROM admin WHERE CORREO = :email');
         $records->bindParam(':email', $_POST['email']);
         $records->execute();
         $results = $records->fetch(PDO::FETCH_ASSOC);

         if ($results && password_verify($_POST['password'], $results['CONTRASENA'])) {
             $_SESSION['usuario_id'] = $results['id'];
             header("Location: ../vista/personas.php");
             exit;
         } else {
             $message = 'Lo siento, sus datos no coinciden';
         }
     }
     ?>
     <!-- HTML para el formulario de login -->
     ```

## Operaciones CRUD

5. **Formularios y scripts para operaciones CRUD**
   - Crear archivos PHP para `create.php`, `read.php`, `update.php`, `delete.php`.
   - Ejemplo de `create.php`:
     ```php
     <?php
     require '../controlador/database.php';
     $database = new Database();
     $conn = $database->getConnection();

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $dni = $_POST['DNI'];
         $nombre = $_POST['NOMBRE'];
         // Resto de los campos...

         $query = "INSERT INTO tbl_personas (DNI, NOMBRE, ...) VALUES (:dni, :nombre, ...)";
         $stmt = $conn->prepare($query);
         $stmt->bindParam(':dni', $dni);
         $stmt->bindParam(':nombre', $nombre);
         // Resto de los bindParam...

         if ($stmt->execute()) {
             $message = 'Persona creada correctamente';
         } else {
             $message = 'Error al crear persona';
         }
     }
     ?>
     <!-- HTML para el formulario de creación -->
     ```

## Interfaz de Usuario

6. **Diseño del formulario usando Bootstrap o Materialize**
   - Usar Bootstrap en tus formularios y tablas para una mejor presentación.
   - Ejemplo de formulario con Bootstrap:
     ```html
     <form action="create.php" method="POST">
         <div class="form-group">
             <label for="DNI">DNI</label>
             <input type="text" class="form-control" id="DNI" name="DNI" required>
         </div>
         <div class="form-group">
             <label for="NOMBRE">Nombre</label>
             <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required>
         </div>
         <!-- Resto de los campos -->
         <button type="submit" class="btn btn-primary">Guardar</button>
     </form>
     ```

7. **Uso de AJAX para mostrar los horarios sin recargar la página**
   - Ejemplo de AJAX para cargar horarios:
     ```html
     <script>
         function loadHorarios() {
             var xhr = new XMLHttpRequest();
             xhr.open('GET', 'horarios.php', true);
             xhr.onload = function() {
                 if (this.status == 200) {
                     document.getElementById('horarios').innerHTML = this.responseText;
                 }
             };
             xhr.send();
         }

         document.addEventListener('DOMContentLoaded', loadHorarios);
     </script>
     ```

## Funcionalidades Adicionales

8. **Exportar información a Excel**
   - Crear un script PHP para exportar los datos de la tabla a Excel.
   - Ejemplo de `export.php`:
     ```php
     <?php
     require '../controlador/database.php';
     $database = new Database();
     $conn = $database->getConnection();

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="datos_personas.xls"');

     $output = fopen('php://output', 'w');
     fputcsv($output, array('ID', 'DNI', 'Nombre', 'Fecha de Nacimiento', 'Dirección', 'Teléfono', 'Correo'));

     $query = "SELECT * FROM tbl_personas";
     $stmt = $conn->prepare($query);
     $stmt->execute();

     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         fputcsv($output, $row);
     }

     fclose($output);
     ?>
     ```

9. **Buscador avanzado**
   - Crear un formulario y script PHP para realizar búsquedas avanzadas.
   - Ejemplo de `search.php`:
     ```php
     <?php
     require '../controlador/database.php';
     $database = new Database();
     $conn = $database->getConnection();

     $search = $_POST['search'];
     $query = "SELECT * FROM tbl_personas WHERE NOMBRE LIKE :search OR DNI LIKE :search";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(':search', $search);
     $stmt->execute();

     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
     foreach ($results as $result) {
         echo $result['NOMBRE'] . '<br>';
     }
     ?>
     <!-- HTML para el formulario de búsqueda -->
     ```
