<?php
session_start();
// Si no existe una sesión activa, lo saca volando pa el login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once 'conexion.php';

// Consulta que une las 3 tablas para traer toda la información escolar junta
$sql = "SELECT e.cedula AS est_cedula, e.nombres AS est_nombres, e.apellidos AS est_apellidos, 
               h.grado, h.turno, r.nombres AS rep_nombres, r.apellidos AS rep_apellidos, r.telefono_1 
        FROM estudiantes e
        INNER JOIN representantes r ON e.id_representante = r.id_representante
        INNER JOIN historial_academico h ON e.id_estudiante = h.id_estudiante
        ORDER BY h.grado ASC, e.apellidos ASC";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes Inscritos - E.B.M.J. "San Francisco"</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; color: #333; }
        .contenedor { max-width: 950px; background: white; padding: 25px; margin: auto; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1a4a75; text-transform: uppercase; margin-bottom: 20px; }
        .botones-navegacion { margin-bottom: 20px; }
        .btn { padding: 10px 15px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 14px; background: #1a4a75; color: white; }
        .btn:hover { background: #133657; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-size: 14px; }
        th { background-color: #1a4a75; color: white; text-transform: uppercase; font-size: 12px; }
        tr:hover { background-color: #f1f5f9; }
        .vacio { text-align: center; color: #666; font-style: italic; padding: 20px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Estudiantes Registrados</h2>
    
    <div class="botones-navegacion">
        <a href="menu.php" class="btn">← Volver al Menú</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cédula / Escolar</th>
                <th>Alumno (Apellidos y Nombres)</th>
                <th>Grado</th>
                <th>Turno</th>
                <th>Representante</th>
                <th>Teléfono Contacto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['est_cedula']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['est_apellidos'] . ", " . $fila['est_nombres']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['grado']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['turno']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['rep_apellidos'] . ", " . $fila['rep_nombres']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['telefono_1']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='vacio'>No hay estudiantes registrados en el sistema actualmente.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php $conexion->close(); ?>
