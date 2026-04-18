<ul>
 <?php if (!isset($_SESSION["x"])) { ?>
  
  <li><a href="index.php">Iniciar Sesión</a></li>
  <li><a href="registro.php">Registrarse</a></li> <?php } else { ?>

  <li><a href="info.php">Información</a></li>
  <li><a href="cerrar.php">Cerrar Sesión</a></li>

 <?php } ?>
</ul>