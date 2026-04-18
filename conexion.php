<?php
class Bd
{
 private static ?PDO $pdo = null;

 static function pdo(): PDO
 {
  if (self::$pdo === null) {
  $dbDir = __DIR__ . DIRECTORY_SEPARATOR . 'database';
  if (!is_dir($dbDir)) {
   @mkdir($dbDir, 0755, true);
  }

  $dbFile = $dbDir . DIRECTORY_SEPARATOR . 'bd.db';

  if (!is_writable($dbDir) && !is_writable($dbFile)) {
   throw new RuntimeException("No se puede escribir en la carpeta de base de datos: $dbDir. Ajusta permisos para el usuario del servidor web.");
  }

  self::$pdo = new PDO(
   "sqlite:" . $dbFile,
   null,
   null,
   [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

   self::$pdo->exec(
    "CREATE TABLE IF NOT EXISTS USUARIO (
      USU_ID INTEGER PRIMARY KEY AUTOINCREMENT,
      USU_CUE TEXT NOT NULL UNIQUE,
      USU_MATCH TEXT NOT NULL,
      CONSTRAINT USU_CUE_NV CHECK(LENGTH(USU_CUE) > 0)
     )"
   );

   $stmt = self::$pdo->query("SELECT COUNT(*) FROM USUARIO");
   if ($stmt->fetchColumn() == 0) {
     self::$pdo->exec("INSERT INTO USUARIO (USU_CUE, USU_MATCH) VALUES ('admin', 'secreto')");
   }
  }
  return self::$pdo;
 }
}