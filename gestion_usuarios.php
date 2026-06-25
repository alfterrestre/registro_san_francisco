<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
require_once 'conexion.php';

$mensaje = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave_actual = $_POST['clave_actual'];
    $clave_nueva  = $_POST['clave_nueva'];
    $id_usuario   = $_SESSION['id_usuario'];

    // Verifica si la clave actual es correcta
    $sql = "SELECT clave FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    if ($clave_actual === $user['clave']) {
        // Actualiza a la nueva contraseña
        $sql_update = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $stmt_up = $conexion->prepare($sql_update);
        $stmt_up->bind_param("si", $clave_nueva, $id_usuario);
        
        if ($stmt_up->execute()) {
            $mensaje = "¡Contraseña actualizada con éxito!";
        } else {
            $error = "No se pudo actualizar la contraseña en la base de datos.";
        }
        $stmt_up->close();
    } else {
        $error = "La contraseña actual es incorrecta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - E.B.M.J. "San Francisco"</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; }
        .box { max-width: 400px; background: white; padding: 30px; margin: auto; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        h2 { color: #1a4a75; text-transform: uppercase; margin-bottom: 20px; font-size: 18px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 13px; color: #555; }
        input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-block; cursor: pointer; }
        .btn-primary { background: #1a4a75; color: white; border: none; width: 100%; font-size: 15px; }
        .btn-primary:hover { background: #133657; }
        .btn-back { background: #e2e8f0; color: #333; margin-bottom: 20px; }
        .alert { padding: 10px; border-radius: 4px; font-size: 14px; margin-bottom: 15px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="box">
    <a href="menu.php" class="btn btn-back">← Volver al Menú</a>
    <h2>Seguridad de la Cuenta</h2>

    <?php if(!empty($mensaje)): ?>
        <div class="alert success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <?php if(!empty($error)): ?>
        <div class="alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label>Contraseña Actual:</label>
        <input type="password" name="clave_actual" required placeholder="Escriba la clave de ahora">

        <label>Nueva Contraseña:</label>
        <input type="password" name="clave_nueva" required placeholder="Mínimo 4 caracteres">

        <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
    </form>
</div>

</body>
</html>
