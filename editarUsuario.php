<?php
session_start();
if(!isset($_SESSION["x"])) {
  header("location: index.php");
  return;
}
require_once "conexion.php";

$bd = Bd::pdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
  $cue = isset($_POST['cue']) ? trim((string)$_POST['cue']) : '';
  $matc = isset($_POST['matc']) ? (string)$_POST['matc'] : '';

  try {
    if ($id <= 0) throw new Exception('ID inválido');
    if ($cue === '') throw new Exception('La cuenta es obligatoria.');
    if ($matc === '' || strlen($matc) < 6) throw new Exception('Contraseña inválida (mínimo 6 caracteres).');

    $stmt = $bd->prepare('UPDATE USUARIO SET USU_CUE = :cue, USU_MATCH = :matc WHERE USU_ID = :id');
    $stmt->execute([':cue' => $cue, ':matc' => $matc, ':id' => $id]);

    header('Location: info.php');
    exit;
  } catch (Exception $e) {
    $error = $e->getMessage();
  }

} else {
  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  if ($id <= 0) {
    header('Location: info.php');
    exit;
  }
  $stmt = $bd->prepare('SELECT USU_ID, USU_CUE, USU_MATCH FROM USUARIO WHERE USU_ID = :id');
  $stmt->execute([':id' => $id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user) {
    header('Location: info.php');
    exit;
  }
  $cue = $user['USU_CUE'];
  $matc = $user['USU_MATCH'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="./css/index.css">
</head>
<body>
  <?php require "header.php" ?>
  <main>
    <h1>Editar Usuario</h1>
    <?php if (isset($error)) { ?><p class="error"><?= htmlentities($error) ?></p><?php } ?>
    <form method="post" action="editarUsuario.php">
      <input type="hidden" name="id" value="<?= isset($id) ? (int)$id : 0 ?>">
      <label for="cue">Cuenta</label>
      <input id="cue" type="text" name="cue" value="<?= isset($cue) ? htmlentities($cue) : '' ?>" required>

      <label for="matc">Contraseña (mínimo 6 caracteres)</label>
      <input id="matc" type="password" name="matc" value="<?= isset($matc) ? htmlentities($matc) : '' ?>" required>
      <div class="form-actions">
        <button class="btn" type="submit">Guardar</button>
        <a href="info.php" class="btn secondary">Cancelar</a>
      </div>
    </form>
  </main>
  <?php require "footer.php" ?>
</body>
</html>
