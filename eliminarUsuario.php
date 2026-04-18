<?php
session_start();
if(!isset($_SESSION["x"])) {
  header("location: index.php");
  return;
}
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: info.php');
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  header('Location: info.php');
  exit;
}

$bd = Bd::pdo();
$stmt = $bd->prepare('DELETE FROM USUARIO WHERE USU_ID = :id');
$stmt->execute([':id' => $id]);

header('Location: info.php');
exit;
