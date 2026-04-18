<?php
session_start();
 if(isset($_SESSION["x"])) {
 header("location: info.php");
 return;
}
?><!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width">
 <title>Iniciar Sesión</title>
 <link rel="stylesheet" href="./css/index.css">
</head>
<body>
 <?php require "header.php" ?>

 <main class="login-wrap">
    <section class="login-card">
        <h1>Inicio de Sesión</h1>
        <p class="lead">Accede a tu cuenta para continuar</p>

        <form action="procesarInicio.php" method="post">
            <input type="text" name="cue" placeholder="Correo electrónico" required>
            <input type="password" name="matc" placeholder="Contraseña" required>
            <button type="submit" class="btn">Iniciar sesión</button>
        </form>

        <p class="register-link">¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
    </section>
 </main>

 <?php require "footer.php" ?>
</body>
</html>