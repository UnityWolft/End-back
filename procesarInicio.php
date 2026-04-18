<?php
require_once "conexion.php";
require_once "recuperaTexto.php";

const CUE = "cue";
const MATC = "matc";

try {
 $cue = recuperaTexto(CUE);
 $matc = recuperaTexto(MATC);

 if ($cue === false || trim($cue) === "")
  throw new Exception("La cuenta es obligatoria.", 1);

 if ($matc === false || $matc === "")
  throw new Exception("La contraseña es obligatoria.", 1);

 $bd = Bd::pdo();
 $stmt = $bd->prepare("SELECT USU_MATCH FROM USUARIO WHERE USU_CUE = :cue");
 $stmt->execute([":cue" => trim($cue)]);
 $fila = $stmt->fetch(PDO::FETCH_ASSOC);

 if ($fila === false || $fila["USU_MATCH"] !== $matc) {
  throw new Exception("Credenciales incorrectas.", 2);
 }

 session_start();
 $_SESSION["x"] = trim($cue);
 header("location: info.php");

} catch (Exception $error) {
 $errorHtml = htmlentities($error->getMessage());
 require "error.php";
}