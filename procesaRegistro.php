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

 if (strlen($matc) < 6)
  throw new Exception("La contraseña debe tener al menos 6 caracteres.", 1);

 $bd = Bd::pdo();

 $stmt = $bd->prepare(
   "INSERT INTO USUARIO (USU_CUE, USU_MATCH) 
    VALUES (:cue, :matc)"
 );

 $stmt->execute([
   ":cue" => trim($cue),
   ":matc" => $matc
 ]);

 header("Location: index.php");
 exit;

} catch (Exception $error) {
 if ($error->getCode() == "23000") {
    $errorHtml = "Ese nombre de usuario ya existe.";
 } else {
    $errorHtml = htmlentities($error->getMessage());
 }
 require "error.php";
}