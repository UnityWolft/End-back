<?php
header('Content-Type: text/html; charset=utf-8');
require_once "conexion.php";

$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$bd = Bd::pdo();

if ($q === '') {
  $stmt = $bd->query("SELECT USU_ID, USU_CUE, USU_MATCH FROM USUARIO ORDER BY USU_ID DESC");
} else {
  $stmt = $bd->prepare("SELECT USU_ID, USU_CUE, USU_MATCH FROM USUARIO WHERE USU_CUE LIKE :q ORDER BY USU_ID DESC");
  $stmt->execute([':q' => "%$q%"]);
}

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($usuarios) === 0) {
  echo '<tr class="empty-row"><td colspan="4">No se encontraron usuarios.</td></tr>';
  exit;
}

foreach ($usuarios as $u) {
  $id = (int)$u['USU_ID'];
  $cue = htmlentities($u['USU_CUE']);
  $matc = htmlentities($u['USU_MATCH']);
  $cue_js = addslashes($cue);
  echo "<tr>";
  echo "<td class=\"id-cell\">$id</td>";
  echo "<td>$cue</td>";
  echo "<td>$matc</td>";
  echo "<td>";
  echo "<div class=\"row-actions\">";
  echo "<a class=\"btn\" href=\"editarUsuario.php?id=$id\">Editar</a>";
  echo "<form method=\"post\" action=\"eliminarUsuario.php\" class=\"action-form\" onsubmit=\"return confirm('¿Eliminar usuario $cue_js?');\">";
  echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
  echo "<button type=\"submit\" class=\"btn danger\">Eliminar</button>";
  echo "</form>";
  echo "</div>";
  echo "</td>";
  echo "</tr>";
}
