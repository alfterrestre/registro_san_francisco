<?php

require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cedula = $_POST['est_cedula'];

// Validacion para por si la cédula ya existe
$sql_check = "SELECT id_estudiante FROM estudiantes WHERE cedula = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("s", $cedula);
$stmt_check->execute();
$resultado_check = $stmt_check->get_result();

if ($resultado_check->num_rows > 0) {
    // Si ya existe, detenemos el proceso y muestra una alerta
    echo "<script>alert('ERROR: Ya existe un estudiante registrado con la Cédula/Escolar v-$cedula.'); window.history.back();</script>";
    $stmt_check->close();
    exit; // Bloquea la inscripcion
}
$stmt_check->close();

   
    //Datos del representante 
    $rep_parentesco    = $_POST['rep_parentesco'];
    $rep_estado_civil  = $_POST['rep_estado_civil'];
    $rep_apellidos     = $_POST['rep_apellidos'];
    $rep_nombres       = $_POST['rep_nombres'];
    $rep_nacionalidad  = $_POST['rep_nacionalidad'];
    $rep_cedula        = $_POST['rep_cedula'];
    $rep_fecha_nac     = !empty($_POST['rep_fecha_nac']) ? $_POST['rep_fecha_nac'] : NULL;
    $rep_direccion     = $_POST['rep_direccion'];
    $rep_instruccion   = $_POST['rep_instruccion'];
    $rep_ocupacion     = $_POST['rep_ocupacion'];
    $rep_telefono1     = $_POST['rep_telefono1'];
    $rep_telefono2     = $_POST['rep_telefono2'];
    $vivienda_condicion= $_POST['vivienda_condicion'];
    $vivienda_tipo     = $_POST['vivienda_tipo'];

    //Datos del estudiante
    $est_apellidos     = $_POST['est_apellidos'];
    $est_nombres       = $_POST['est_nombres'];
    $est_nacionalidad  = $_POST['est_nacionalidad'];
    $est_cedula        = $_POST['est_cedula'];
    $est_fecha_nac     = $_POST['est_fecha_nac'];
    $est_sexo          = $_POST['est_sexo'];
    $est_lugar_nac     = $_POST['est_lugar_nac'];
    $est_estado_nac    = $_POST['est_estado_nac'];
    $est_municipio     = $_POST['est_municipio'];
    $est_parroquia     = $_POST['est_parroquia'];
    $est_direccion     = $_POST['est_direccion'];
    $est_canaima       = $_POST['est_canaima'];
    $est_serial_canaima= $_POST['est_serial_canaima'];
    $est_beca          = $_POST['est_beca'];

        //Datos del historial academico
    $hist_fecha  = $_POST['hist_fecha'];
    $hist_grado  = $_POST['hist_grado'];
    $hist_turno  = $_POST['hist_turno'];
    $hist_repite = $_POST['hist_repite'];

    
   
    // Se inserta primero el representante
    // Usamos una consulta preparada para evitar errores con caracteres especiales
    $sql_rep = "INSERT INTO representantes (parentesco, apellidos, nombres, nacionalidad, cedula, fecha_nacimiento, estado_civil, direccion_habitacion, grado_instruccion, ocupacion, telefono_1, telefono_2, condicion_vivienda, tipo_vivienda) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_rep = $conexion->prepare($sql_rep);
    $stmt_rep->bind_param("ssssssssssssss", $rep_parentesco, $rep_apellidos, $rep_nombres, $rep_nacionalidad, $rep_cedula, $rep_fecha_nac, $rep_estado_civil, $rep_direccion, $rep_instruccion, $rep_ocupacion, $rep_telefono1, $rep_telefono2, $vivienda_condicion, $vivienda_tipo);
    
    if ($stmt_rep->execute()) {
        // Conseguimos el ID automático que MySQL le asignó a este representante
        $id_representante_guardado = $conexion->insert_id;
        
        // Seinserta al estudiante usando el ID del representante
        $sql_est = "INSERT INTO estudiantes (apellidos, nombres, nacionalidad, cedula, fecha_nacimiento, sexo, lugar_nacimiento, estado_nacimiento, municipio_nacimiento, parroquia_nacimiento, direccion_habitacion, tiene_canaima, serial_canaima, goza_beca, id_representante) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt_est = $conexion->prepare($sql_est);
        $stmt_est->bind_param("ssssssssssssssi", $est_apellidos, $est_nombres, $est_nacionalidad, $est_cedula, $est_fecha_nac, $est_sexo, $est_lugar_nac, $est_estado_nac, $est_municipio, $est_parroquia, $est_direccion, $est_canaima, $est_serial_canaima, $est_beca, $id_representante_guardado);
        
        if ($stmt_est->execute()) {
                        // Conseguimos el ID del estudiante que se acaba de guardar
            $id_estudiante_guardado = $conexion->insert_id;

            // Insertamos los datos académicos en la tercera tabla
            $sql_hist = "INSERT INTO historial_academico (id_estudiante, fecha_inscripcion, grado, repite, turno) 
                         VALUES (?, ?, ?, ?, ?)";
            $stmt_hist = $conexion->prepare($sql_hist);
            $stmt_hist->bind_param("issss", $id_estudiante_guardado, $hist_fecha, $hist_grado, $hist_repite, $hist_turno);
            $stmt_hist->execute();
            $stmt_hist->close();

            // Si no hay ningun error, se muestra un mensaje de éxito
            echo "<div style='font-family:Arial; text-align:center; margin-top:50px; color:#28a745;'>";
            echo "<h2>¡Inscripción Guardada con Éxito!</h2>";
            echo "<p>Los datos del estudiante y el representante han sido digitalizados.</p>";
            echo "<a href='index.php' style='text-decoration:none; background:#1a4a75; color:white; padding:10px 20px; border-radius:4px;'>Volver a la Planilla</a>";
            echo "</div>";
        } else {
            echo "Error al registrar al estudiante: " . $stmt_est->error;
        }
        $stmt_est->close();
        
    } else {
        // Alerta por si meten una cédula de representante que ya existe
        if($conexion->errno == 1062) {
            echo "<script>alert('Error: Ya existe un representante registrado con esa Cédula.'); window.history.back();</script>";
        } else {
            echo "Error al registrar al representante: " . $stmt_rep->error;
        }
    }
    
    $stmt_rep->close();
}

// Cerrar la conexión al terminar
$conexion->close();
?>