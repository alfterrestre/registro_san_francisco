<?php
session_start();
// Si no hay sesión activa, lo enviamos al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
require_once 'conexion.php';

// --- Función auxiliar para obtener un solo número (conteos) ---
function contar($conexion, $sql) {
    $res = $conexion->query($sql);
    $fila = $res->fetch_row();
    return (int)$fila[0];
}

// --- Función auxiliar para obtener grupos (etiqueta => cantidad) ---
function agrupar($conexion, $sql) {
    $datos = [];
    $res = $conexion->query($sql);
    while ($f = $res->fetch_assoc()) {
        $clave = $f[array_key_first($f)];
        $datos[$clave === null || $clave === '' ? 'Sin dato' : $clave] = (int)$f['c'];
    }
    return $datos;
}

// --- Indicadores principales (KPIs) ---
$total_estudiantes   = contar($conexion, "SELECT COUNT(*) FROM estudiantes");
$total_representantes = contar($conexion, "SELECT COUNT(*) FROM representantes");
$total_inscripciones = contar($conexion, "SELECT COUNT(*) FROM historial_academico");
$total_repitientes   = contar($conexion, "SELECT COUNT(*) FROM historial_academico WHERE repite = 'SI'");
$total_canaima       = contar($conexion, "SELECT COUNT(*) FROM estudiantes WHERE tiene_canaima = 'SI'");
$total_becados       = contar($conexion, "SELECT COUNT(*) FROM estudiantes WHERE goza_beca = 'SI'");

// --- Agrupaciones para los gráficos ---
$por_grado = agrupar($conexion, "SELECT grado, COUNT(*) c FROM historial_academico GROUP BY grado ORDER BY grado ASC");
$por_turno = agrupar($conexion, "SELECT turno, COUNT(*) c FROM historial_academico GROUP BY turno");
$por_sexo  = agrupar($conexion, "SELECT sexo, COUNT(*) c FROM estudiantes GROUP BY sexo");

// Colores para los turnos y sexos
$colores_turno = ['Mañana' => '#f6ad55', 'Tarde' => '#4299e1'];
$colores_sexo  = ['M' => '#4299e1', 'F' => '#ed64a6'];
$etiqueta_sexo = ['M' => 'Masculino', 'F' => 'Femenino'];

// Función para calcular porcentaje seguro
function porcentaje($parte, $total) {
    return $total > 0 ? round(($parte / $total) * 100) : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E.B.M.J. "San Francisco"</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #eef1f6; margin: 0; color: #2d3748; }
        .barra-superior { background: #1a4a75; color: white; padding: 18px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .barra-superior h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .barra-superior .sub { font-size: 12px; opacity: 0.85; }
        .btn-volver { background: rgba(255,255,255,0.15); color: white; padding: 9px 16px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 13px; }
        .btn-volver:hover { background: rgba(255,255,255,0.28); }
        .contenedor { max-width: 1050px; margin: 25px auto; padding: 0 20px; }

        /* Tarjetas KPI */
        .kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 18px; margin-bottom: 25px; }
        .kpi { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.06); border-left: 5px solid #1a4a75; }
        .kpi .icono { font-size: 26px; }
        .kpi .numero { font-size: 34px; font-weight: bold; color: #1a4a75; line-height: 1.1; margin-top: 6px; }
        .kpi .texto { font-size: 13px; color: #718096; margin-top: 2px; }
        .kpi.verde { border-left-color: #38a169; } .kpi.verde .numero { color: #38a169; }
        .kpi.naranja { border-left-color: #dd6b20; } .kpi.naranja .numero { color: #dd6b20; }
        .kpi.morado { border-left-color: #805ad5; } .kpi.morado .numero { color: #805ad5; }
        .kpi.rojo { border-left-color: #e53e3e; } .kpi.rojo .numero { color: #e53e3e; }
        .kpi.rosa { border-left-color: #d53f8c; } .kpi.rosa .numero { color: #d53f8c; }

        /* Paneles de gráficos */
        .grid-graficos { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .panel { background: white; border-radius: 10px; padding: 22px; box-shadow: 0 3px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
        .panel.ancho { grid-column: 1 / -1; }
        .panel h3 { margin: 0 0 18px 0; color: #1a4a75; font-size: 15px; text-transform: uppercase; border-bottom: 2px solid #edf2f7; padding-bottom: 10px; }

        /* Barras horizontales */
        .barra-fila { display: flex; align-items: center; margin-bottom: 12px; }
        .barra-etiqueta { width: 95px; font-size: 13px; font-weight: bold; color: #4a5568; flex-shrink: 0; }
        .barra-pista { flex: 1; background: #edf2f7; border-radius: 20px; height: 24px; overflow: hidden; }
        .barra-relleno { height: 100%; border-radius: 20px; display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; color: white; font-size: 12px; font-weight: bold; min-width: 28px; transition: width 0.4s; }

        /* Barras verticales tipo columnas */
        .columnas { display: flex; align-items: flex-end; justify-content: space-around; height: 200px; gap: 12px; padding-top: 10px; }
        .columna-item { flex: 1; display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; }
        .columna-barra { width: 100%; max-width: 55px; background: linear-gradient(180deg, #2b6cb0, #1a4a75); border-radius: 6px 6px 0 0; position: relative; min-height: 4px; }
        .columna-valor { font-weight: bold; color: #1a4a75; font-size: 14px; margin-bottom: 4px; }
        .columna-label { font-size: 12px; color: #4a5568; margin-top: 8px; text-align: center; font-weight: bold; }

        .vacio { text-align: center; color: #a0aec0; font-style: italic; padding: 30px; }
        @media (max-width: 760px) { .grid-graficos { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="barra-superior">
    <div>
        <h1>📊 Dashboard Estadístico</h1>
        <div class="sub">E.B.M.J. "San Francisco" — Matrícula Escolar</div>
    </div>
    <a href="menu.php" class="btn-volver">← Volver al Menú</a>
</div>

<div class="contenedor">

    <!-- Indicadores principales -->
    <div class="kpis">
        <div class="kpi">
            <div class="icono">🎓</div>
            <div class="numero"><?php echo $total_estudiantes; ?></div>
            <div class="texto">Estudiantes inscritos</div>
        </div>
        <div class="kpi verde">
            <div class="icono">👨‍👩‍👧</div>
            <div class="numero"><?php echo $total_representantes; ?></div>
            <div class="texto">Representantes</div>
        </div>
        <div class="kpi morado">
            <div class="icono">📝</div>
            <div class="numero"><?php echo $total_inscripciones; ?></div>
            <div class="texto">Inscripciones</div>
        </div>
        <div class="kpi rojo">
            <div class="icono">🔁</div>
            <div class="numero"><?php echo $total_repitientes; ?></div>
            <div class="texto">Repitientes</div>
        </div>
        <div class="kpi naranja">
            <div class="icono">💻</div>
            <div class="numero"><?php echo $total_canaima; ?></div>
            <div class="texto">Con Canaima</div>
        </div>
        <div class="kpi rosa">
            <div class="icono">🎁</div>
            <div class="numero"><?php echo $total_becados; ?></div>
            <div class="texto">Becados</div>
        </div>
    </div>

    <!-- Estudiantes por grado (columnas) -->
    <div class="panel ancho">
        <h3>Estudiantes por Grado</h3>
        <?php if (!empty($por_grado)): ?>
            <?php $max_grado = max($por_grado); ?>
            <div class="columnas">
                <?php foreach ($por_grado as $grado => $cant): ?>
                    <div class="columna-item">
                        <div class="columna-valor"><?php echo $cant; ?></div>
                        <div class="columna-barra" style="height: <?php echo max(4, porcentaje($cant, $max_grado)); ?>%;"></div>
                        <div class="columna-label"><?php echo htmlspecialchars($grado); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="vacio">Aún no hay inscripciones registradas.</div>
        <?php endif; ?>
    </div>

    <div class="grid-graficos">
        <!-- Por turno -->
        <div class="panel">
            <h3>Distribución por Turno</h3>
            <?php if (!empty($por_turno)): ?>
                <?php foreach ($por_turno as $turno => $cant): $color = $colores_turno[$turno] ?? '#718096'; ?>
                    <div class="barra-fila">
                        <div class="barra-etiqueta"><?php echo htmlspecialchars($turno); ?></div>
                        <div class="barra-pista">
                            <div class="barra-relleno" style="width: <?php echo porcentaje($cant, $total_inscripciones); ?>%; background: <?php echo $color; ?>;"><?php echo $cant; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="vacio">Sin datos.</div>
            <?php endif; ?>
        </div>

        <!-- Por sexo -->
        <div class="panel">
            <h3>Distribución por Sexo</h3>
            <?php if (!empty($por_sexo)): ?>
                <?php foreach ($por_sexo as $sexo => $cant): $color = $colores_sexo[$sexo] ?? '#718096'; ?>
                    <div class="barra-fila">
                        <div class="barra-etiqueta"><?php echo htmlspecialchars($etiqueta_sexo[$sexo] ?? $sexo); ?></div>
                        <div class="barra-pista">
                            <div class="barra-relleno" style="width: <?php echo porcentaje($cant, $total_estudiantes); ?>%; background: <?php echo $color; ?>;"><?php echo $cant; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="vacio">Sin datos.</div>
            <?php endif; ?>
        </div>
    </div>

</div>
</body>
</html>
<?php $conexion->close(); ?>
