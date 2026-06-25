<?php
session_start();
// Condicion si no existe una sesión activa lo saca para el login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
} 

require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Inscripción - E.B.M.J. San Francisco</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; color: #333; }
        .contenedor { max-width: 800px; background: white; padding: 30px; margin: auto; border-radius: 8px; box-shadow: 0px 0px 12px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1a4a75; text-transform: uppercase; margin-bottom: 5px; margin-top: 5px; }
        h4 { text-align: center; margin-top: 0; font-size: 13px; color: #666; line-height: 1.4; }
        .seccion { background: #1a4a75; color: white; padding: 6px 12px; margin: 25px 0 15px 0; font-weight: bold; text-transform: uppercase; border-radius: 3px; font-size: 15px; }
        .campo { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 13px; color: #44px; }
        input[type="text"], input[type="date"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        button { width: 100%; background: #28a745; color: white; padding: 14px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; margin-top: 20px; }
        button:hover { background: #218838; }
        .fila { display: flex; gap: 15px; }
        .columna { flex: 1; }
    </style>
</head>
<body>
<div class="contenedor">
    <h4>REPÚBLICA BOLIVARIANA DE VENEZUELA<br>MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN<br>E.B.M.J. "SAN FRANCISCO"<br>BARQUISIMETO ESTADO LARA</h4>
    <h2>Ficha de Inscripción</h2>
    
    <form action="guardar.php" method="POST">
        
        <div class="seccion">Datos del(la) Estudiante</div>
        <div class="fila">
            <div class="columna campo">
                <label>Apellidos del Estudiante:</label>
                <input type="text" name="est_apellidos" required>
            </div>
            <div class="columna campo">
                <label>Nombres del Estudiante:</label>
                <input type="text" name="est_nombres" required>
            </div>
        </div>
        <div class="fila">
            <div class="columna campo" style="flex: 0.2;">
                <label>Nac.:</label>
                <select name="est_nacionalidad">
                    <option value="V">V</option>
                    <option value="E">E</option>
                </select>
            </div>
            <div class="columna campo">
                <label>C.I. o Cédula Escolar:</label>
                <input type="text" name="est_cedula" placeholder="Ej: 1102345678" required>
            </div>
            <div class="columna campo">
                <label>Fecha de Nacimiento:</label>
                <input type="date" name="est_fecha_nac" required>
            </div>
            <div class="columna campo" style="flex: 0.3;">
                <label>Sexo:</label>
                <select name="est_sexo" required>
                    <option value="">...</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Natural de (Lugar de Nacimiento):</label>
                <input type="text" name="est_lugar_nac" placeholder="Ej: Hospital Central">
            </div>
            <div class="columna campo">
                <label>Estado:</label>
                <input type="text" name="est_estado_nac" placeholder="Ej: Lara">
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Municipio:</label>
                <input type="text" name="est_municipio" placeholder="Ej: Iribarren">
            </div>
            <div class="columna campo">
                <label>Parroquia:</label>
                <input type="text" name="est_parroquia" placeholder="Ej: Catedral">
            </div>
        </div>
        <div class="campo">
            <label>Dirección de Habitación del Estudiante:</label>
            <textarea name="est_direccion" rows="2" required></textarea>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>¿Tiene Computadora Canaima?</label>
                <select name="est_canaima">
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                </select>
            </div>
            <div class="columna campo">
                <label>Serial Canaima (Si posee):</label>
                <input type="text" name="est_serial_canaima">
            </div>
            <div class="columna campo">
                <label>¿Goza de alguna Beca?</label>
                <select name="est_beca">
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                </select>
            </div>
        </div>
        
        <div class="seccion">Datos del(la) Representante</div>
        <div class="fila">
            <div class="columna campo">
                <label>Parentesco:</label>
                <select name="rep_parentesco" required>
                    <option value="">Seleccione...</option>
                    <option value="Madre">Madre</option>
                    <option value="Padre">Padre</option>
                    <option value="Hermano(a)">Hermano(a)</option>
                    <option value="Tio(a)">Tío(a)</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div class="columna campo">
                <label>Estado Civil:</label>
                <select name="rep_estado_civil">
                    <option value="S">Soltero(a)</option>
                    <option value="C">Casado(a)</option>
                    <option value="D">Divorciado(a)</option>
                    <option value="V">Viudo(a)</option>
                </select>
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Apellidos del Representante:</label>
                <input type="text" name="rep_apellidos" required>
            </div>
            <div class="columna campo">
                <label>Nombres del Representante:</label>
                <input type="text" name="rep_nombres" required>
            </div>
        </div>
        <div class="fila">
            <div class="columna campo" style="flex: 0.2;">
                <label>Nac.:</label>
                <select name="rep_nacionalidad">
                    <option value="V">V</option>
                    <option value="E">E</option>
                </select>
            </div>
            <div class="columna campo">
                <label>Cédula de Identidad:</label>
                <input type="text" name="rep_cedula" required>
            </div>
            <div class="columna campo">
                <label>Fecha de Nacimiento:</label>
                <input type="date" name="rep_fecha_nac">
            </div>
        </div>
        <div class="campo">
            <label>Dirección de Habitación del Representante:</label>
            <textarea name="rep_direccion" rows="2" required></textarea>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Grado de Instrucción:</label>
                <input type="text" name="rep_instruccion">
            </div>
            <div class="columna campo">
                <label>Ocupación / Oficio:</label>
                <input type="text" name="rep_ocupacion">
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Teléfono 1 (Principal):</label>
                <input type="text" name="rep_telefono1" required>
            </div>
            <div class="columna campo">
                <label>Teléfono 2:</label>
                <input type="text" name="rep_telefono2">
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Condición Vivienda:</label>
                <select name="vivienda_condicion">
                    <option value="Propia">Propia</option>
                    <option value="Prestada">Prestada</option>
                    <option value="Alquilada">Alquilada</option>
                    <option value="Cedida">Cedida</option>
                    <option value="Otra">Otra</option>
                </select>
            </div>
            <div class="columna campo">
                <label>Tipo de Vivienda:</label>
                <select name="vivienda_tipo">
                    <option value="Casa">Casa</option>
                    <option value="Apartamento">Apartamento</option>
                    <option value="Quinta">Quinta</option>
                    <option value="Rancho">Rancho</option>
                </select>
            </div>
        </div>
        
        <div class="seccion">Historial Académico (Inscripción Actual)</div>
        <div class="fila">
            <div class="columna campo">
                <label>Fecha de Inscripción:</label>
                <input type="date" name="hist_fecha" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="columna campo">
                <label>Grado a Cursar:</label>
                <select name="hist_grado" required>
                    <option value="">Seleccione...</option>
                    <option value="1° Grado">1° Grado</option>
                    <option value="2° Grado">2° Grado</option>
                    <option value="3° Grado">3° Grado</option>
                    <option value="4° Grado">4° Grado</option>
                    <option value="5° Grado">5° Grado</option>
                    <option value="6° Grado">6° Grado</option>
                </select>
            </div>
        </div>
        <div class="fila">
            <div class="columna campo">
                <label>Turno:</label>
                <select name="hist_turno" required>
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                </select>
            </div>
            <div class="columna campo">
                <label>¿El alumno es Repitiente?</label>
                <select name="hist_repite" required>
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                </select>
            </div>
        </div>

       <div class="fila" style="margin-top: 30px; align-items: center;">
            <div class="columna" style="flex: 0.3;">
                <a href="menu.php" style="display: block; text-align: center; background: #e2e8f0; color: #333; padding: 14px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 16px; border: 1px solid #cbd5e0;">
                    ✕ Cancelar y Volver
                </a>
            </div>
            <div class="columna" style="flex: 0.7;">
                <button type="submit" style="margin-top: 0; background: #28a745;">
                    💾 Guardar Inscripción
                </button>
            </div>
        </div>

    </form>
</div>
</body>
</html>

