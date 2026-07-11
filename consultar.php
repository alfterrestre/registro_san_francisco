<?php
session_start();
// Si no existe una sesión activa, lo saca volando pa el login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexion.php';

// Consulta que une las 3 tablas para traer toda la información escolar junta
$sql = "SELECT e.cedula AS est_cedula, e.nombres AS est_nombres, e.apellidos AS est_apellidos,
               e.sexo, h.grado, h.turno, h.repite, r.nombres AS rep_nombres,
               r.apellidos AS rep_apellidos, r.telefono_1
        FROM estudiantes e
        INNER JOIN representantes r ON e.id_representante = r.id_representante
        INNER JOIN historial_academico h ON e.id_estudiante = h.id_estudiante
        ORDER BY h.grado ASC, e.apellidos ASC";

$resultado = $conexion->query($sql);

// Guardamos las filas en un arreglo para poder contarlas y reutilizarlas
$estudiantes = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $estudiantes[] = $fila;
    }
}
$total = count($estudiantes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes Inscritos - E.B.M.J. "San Francisco"</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #eef1f6; margin: 0; color: #2d3748; }
        .barra-superior { background: #1a4a75; color: white; padding: 18px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .barra-superior h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .barra-superior .sub { font-size: 12px; opacity: 0.85; }
        .btn-volver { background: rgba(255,255,255,0.15); color: white; padding: 9px 16px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 13px; }
        .btn-volver:hover { background: rgba(255,255,255,0.28); }
        .contenedor { max-width: 1000px; margin: 25px auto; padding: 0 20px; }

        .barra-herramientas { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 18px; flex-wrap: wrap; }
        .buscador { flex: 1; min-width: 220px; position: relative; }
        .buscador input { width: 100%; padding: 11px 14px 11px 40px; border: 1px solid #cbd5e0; border-radius: 8px; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); }
        .buscador input:focus { outline: none; border-color: #1a4a75; box-shadow: 0 0 0 3px rgba(26,74,117,0.12); }
        .buscador .lupa { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #a0aec0; }
        .contador { background: #1a4a75; color: white; padding: 9px 16px; border-radius: 20px; font-size: 13px; font-weight: bold; white-space: nowrap; }
        .btn-nuevo { background: #38a169; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px; }
        .btn-nuevo:hover { background: #2f855a; }

        .tabla-caja { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.07); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 13px 14px; text-align: left; font-size: 14px; }
        th { background-color: #1a4a75; color: white; text-transform: uppercase; font-size: 11px; letter-spacing: 0.4px; }
        tbody tr { border-bottom: 1px solid #edf2f7; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:hover { background-color: #ebf4ff; }
        .nombre-alumno { font-weight: bold; color: #2d3748; }
        .cedula { font-family: 'Courier New', monospace; color: #4a5568; font-weight: bold; }

        /* Etiquetas de color */
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-grado { background: #ebf8ff; color: #2b6cb0; }
        .badge-manana { background: #fffaf0; color: #c05621; }
        .badge-tarde { background: #ebf8ff; color: #2c5282; }
        .badge-sexo-m { background: #ebf8ff; color: #2b6cb0; }
        .badge-sexo-f { background: #fff5f7; color: #b83280; }
        .badge-repite { background: #fff5f5; color: #c53030; margin-left: 5px; }
        .telefono { color: #4a5568; }

        .sin-resultados { text-align: center; color: #a0aec0; font-style: italic; padding: 35px; }
    </style>
</head>
<body>

<div class="barra-superior">
    <div>
        <h1>🔍 Estudiantes Registrados</h1>
        <div class="sub">E.B.M.J. "San Francisco" — Matrícula Escolar</div>
    </div>
    <a href="menu.php" class="btn-volver">← Volver al Menú</a>
</div>

<div class="contenedor">

    <div class="barra-herramientas">
        <div class="buscador">
            <span class="lupa">🔍</span>
            <input type="text" id="campoBusqueda" onkeyup="filtrarTabla()"
                   placeholder="Buscar por nombre, cédula, grado o representante...">
        </div>
        <span class="contador">👥 <?php echo $total; ?> estudiante<?php echo $total === 1 ? '' : 's'; ?></span>
        <a href="index.php" class="btn-nuevo">＋ Nuevo</a>
    </div>

    <div class="tabla-caja">
        <table id="tablaEstudiantes">
            <thead>
                <tr>
                    <th>Cédula / Escolar</th>
                    <th>Alumno (Apellidos y Nombres)</th>
                    <th>Grado</th>
                    <th>Turno</th>
                    <th>Representante</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($total > 0): ?>
                    <?php foreach ($estudiantes as $fila): ?>
                        <?php
                            $clase_turno = strtolower($fila['turno']) === 'mañana' ? 'badge-manana' : 'badge-tarde';
                            $clase_sexo  = $fila['sexo'] === 'F' ? 'badge-sexo-f' : 'badge-sexo-m';
                        ?>
                        <tr>
                            <td class="cedula"><?php echo htmlspecialchars($fila['est_cedula']); ?></td>
                            <td>
                                <span class="badge <?php echo $clase_sexo; ?>"><?php echo htmlspecialchars($fila['sexo'] ?: '-'); ?></span>
                                <span class="nombre-alumno"><?php echo htmlspecialchars($fila['est_apellidos'] . ', ' . $fila['est_nombres']); ?></span>
                            </td>
                            <td><span class="badge badge-grado"><?php echo htmlspecialchars($fila['grado']); ?></span></td>
                            <td>
                                <span class="badge <?php echo $clase_turno; ?>"><?php echo htmlspecialchars($fila['turno']); ?></span>
                                <?php if ($fila['repite'] === 'SI'): ?>
                                    <span class="badge badge-repite">Repite</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($fila['rep_apellidos'] . ', ' . $fila['rep_nombres']); ?></td>
                            <td class="telefono">📞 <?php echo htmlspecialchars($fila['telefono_1']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="sin-resultados">No hay estudiantes registrados en el sistema actualmente.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div id="mensajeVacio" class="sin-resultados" style="display:none;">No se encontraron estudiantes con ese criterio de búsqueda.</div>
    </div>

</div>

<script>
// Filtro de búsqueda en vivo (sin recargar la página)
function filtrarTabla() {
    const texto = document.getElementById('campoBusqueda').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaEstudiantes tbody tr');
    let visibles = 0;
    filas.forEach(fila => {
        const contenido = fila.textContent.toLowerCase();
        const coincide = contenido.includes(texto);
        fila.style.display = coincide ? '' : 'none';
        if (coincide) visibles++;
    });
    document.getElementById('mensajeVacio').style.display = (visibles === 0) ? 'block' : 'none';
}
</script>

</body>
</html>
<?php $conexion->close(); ?>
