<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - E.B.M.J. "San Francisco"</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .menu-container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1); width: 100%; max-width: 500px; text-align: center; }
        h1 { color: #1a4a75; margin-bottom: 5px; font-size: 24px; text-transform: uppercase; }
        .sub { color: #666; margin-bottom: 30px; font-size: 14px; }
        .saludo { background: #e2e8f0; padding: 10px; border-radius: 4px; color: #2d3748; font-weight: bold; margin-bottom: 25px; font-size: 14px; }
        .btn-menu { display: block; background: #1a4a75; color: white; padding: 15px; margin-bottom: 15px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background 0.2s; }
        .btn-menu:hover { background: #133657; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-secondary { background: #4a5568; }
        .btn-secondary:hover { background: #2d3748; }
    </style>
</head>
<body>

<div class="menu-container">
    <h1>E.B.M.J. "San Francisco"</h1>
    <div class="sub">Sistema de Gestión de Matrícula Escolar</div>
    
    <div class="saludo">¡Bienvenido(a), <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>!</div>
    
    <!-- Opciones del Menú -->
    <a href="index.php" class="btn-menu">📝 Inscribir Nuevo Estudiante</a>
    <a href="consultar.php" class="btn-menu">🔍 Ver Registros de Estudiantes</a>
    <a href="gestion_usuarios.php" class="btn-menu btn-secondary">⚙️ Gestión de Usuarios (Cambiar Clave)</a>
    <a href="salir.php" class="btn-menu btn-danger">🚪 Cerrar Sesión</a>
</div>

</body>
</html>

