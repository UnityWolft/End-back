<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width">
 <title>Error</title>
 <link rel="stylesheet" href="./css/index.css">
</head>
<body>
 <?php require "header.php" ?>
  <main>
   <h1>Error</h1>
   <p><?= isset($errorHtml) ? $errorHtml : "Error desconocido" ?></p>
   <p><a href="index.php">Volver al inicio</a></p>
  </main>
 <?php require "footer.php" ?>
</body>
</html>