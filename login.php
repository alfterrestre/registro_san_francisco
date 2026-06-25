<?php
// Iniciar sesión y activar errores
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión
require_once 'conexion.php';

$error = "";

// Procesar el formulario cuando se presiona el botón
if (isset($_POST['btn_entrar'])) {
    $usuario = $_POST['usuario'];
    $clave   = $_POST['clave'];

    // Consulta a la base de datos
    $sql = "SELECT id_usuario, usuario, clave, nombre FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $user = $resultado->fetch_assoc();
            
            // Verifica la contraseña en texto plano
            if ($clave === $user['clave']) {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre_usuario'] = $user['nombre'];
                
                // Redirección segura usando JavaScript
                echo "<script>window.location.href='menu.php';</script>";
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El usuario no existe en el sistema.";
        }
        $stmt->close();
    } else {
        $error = "Error al preparar la consulta médica en la base de datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema - E.B.M.J. "San Francisco"</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; height: 100vh; justify-content: center; align-items: center; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 350px; text-align: center; }
        h2 { color: #1a4a75; margin-bottom: 20px; text-transform: uppercase; font-size: 20px; }
        .campo { margin-bottom: 15px; text-align: left; }
        label { font-weight: bold; font-size: 14px; color: #555; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { width: 100%; background: #1a4a75; color: white; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #133657; }
        .error { color: red; font-size: 14px; margin-bottom: 15px; font-weight: bold; background: #ffe6e6; padding: 8px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Control de Acceso</h2>
    <p style="font-size: 12px; color: #777; margin-top: -10px;">E.B.M.J. "San Francisco"</p>
    
    <?php if(!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="campo">
            <label>Usuario:</label>
            <input type="text" name="usuario" placeholder="Ej: admin" required>
        </div>
        <div class="campo">
            <label>Contraseña:</label>
            <input type="password" name="clave" placeholder="••••••••" required>
        </div>
        <button type="submit" name="btn_entrar" class="btn-submit">Entrar al Sistema</button>
    </form>
</div>

</body>
</html>
