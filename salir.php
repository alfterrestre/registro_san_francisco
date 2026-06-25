<?php
session_start();
session_destroy(); // Destruye el pase temporal
header("Location: login.php");
exit;
?>
