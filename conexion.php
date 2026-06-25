<?php
// Configuración de la conexión a la base de datos de XAMPP
$servidor = "localhost";
$usuario  = "root";
$clave    = ""; // En XAMPP la clave por defecto viene vacía
$base_datos = "escuelasanfrancisco";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);

// Verificar si hay algún error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Configurar para que acepte acentos y eñes sin problemas
$conexion->set_charset("utf8mb4");
?>

