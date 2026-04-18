<?php
require_once "conexion.php";
require_once "recuperaTexto.php";

const CUE = "cue";
const MATC = "matc";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width">
     <title>Crear Usuario</title>
     <link rel="stylesheet" href="./css/index.css">
    </head>
    <body>
     <?php require "header.php" ?>

     <main class="login-wrap">
        <section class="login-card">
            <h1>Crear Usuario Nuevo</h1>
            

            <form action="crearUsuario.php" method="post">
                <input type="text" name="cue" placeholder="Cuenta" required>
                <input type="password" name="matc" placeholder="Contraseña" required>
                <button type="submit" class="btn">Registrar</button>
            </form>

            <p class="register-link"><a href="index.php">Volver</a></p>
        </section>
     </main>

     <?php require "footer.php" ?>
    </body>
    </html>
    <?php
    exit;
}

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

