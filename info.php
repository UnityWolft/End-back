<?php
session_start();
if(!isset($_SESSION["x"])) {
        header("location: index.php");
        return;
}
$usuario = htmlentities($_SESSION["x"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Información Privada</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <?php require "header.php" ?>

    <main>
        <h1>Usuarios</h1>
        <p class="muted">Bienvenido, <?= $usuario ?> — aquí puedes buscar, editar o eliminar usuarios.</p>

        <section class="controls">
            <?php
            require_once "conexion.php";
            $bd = Bd::pdo();
            $allStmt = $bd->query("SELECT USU_CUE FROM USUARIO ORDER BY USU_CUE LIMIT 500");
            $allCues = $allStmt->fetchAll(PDO::FETCH_COLUMN, 0);
            ?>
            <form method="get" action="info.php" class="search-form">
                <input list="users-list" type="search" name="q" placeholder="Buscar por cuenta" value="<?= isset($_GET['q']) ? htmlentities($_GET['q']) : '' ?>">
                <datalist id="users-list">
                    <?php foreach ($allCues as $c) { echo "<option value=\"" . htmlentities($c) . "\"></option>"; } ?>
                </datalist>
            </form>
            <div class="actions">
                <a class="btn create-btn" href="crearUsuario.php">Crear usuario</a>
            </div>
        </section>

        <?php
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';

        if ($q === '') {
            $stmt = $bd->query("SELECT USU_ID, USU_CUE, USU_MATCH FROM USUARIO ORDER BY USU_ID DESC");
        } else {
            $stmt = $bd->prepare("SELECT USU_ID, USU_CUE, USU_MATCH FROM USUARIO WHERE USU_CUE LIKE :q ORDER BY USU_ID DESC");
            $stmt->execute([':q' => "%$q%"]);
        }

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <section style="overflow:auto;">
            <table id="users-table" class="users-table">
                <thead>
                    <tr>
                            <th>ID</th>
                            <th>Cuenta</th>
                            <th>Contraseña</th>
                            <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-body">
                <?php if (count($usuarios) === 0) { ?>
                    <tr class="empty-row"><td colspan="4">No se encontraron usuarios.</td></tr>
                <?php } else {
                    foreach ($usuarios as $u) {
                        $id = (int)$u['USU_ID'];
                        $cue = htmlentities($u['USU_CUE']);
                        $matc = htmlentities($u['USU_MATCH']);
                ?>
                    <tr>
                        <td class="id-cell"><?= $id ?></td>
                        <td><?= $cue ?></td>
                        <td><?= $matc ?></td>
                        <td>
                            <div class="row-actions">
                              <a class="btn" href="editarUsuario.php?id=<?= $id ?>">Editar</a>
                              <form method="post" action="eliminarUsuario.php" class="action-form" onsubmit="return confirm('¿Eliminar usuario <?= addslashes($cue) ?>?');">
                                  <input type="hidden" name="id" value="<?= $id ?>">
                                  <button type="submit" class="btn danger">Eliminar</button>
                              </form>
                            </div>
                        </td>
                    </tr>
                <?php }
                } ?>
                </tbody>
            </table>
        </section>
    

    </main>

    <?php require "footer.php" ?>
</body>
</html>