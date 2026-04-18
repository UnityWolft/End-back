<header>
  <p>
   <button type="button" id="hamburguesa"
    popovertarget="navegacionDelSitio"
    aria-controls="navegacionDelSitio"
    aria-label="Abrir navegación del sitio">
    ≡
   </button>
  </p>
  
  <nav popover="auto" id="navegacionDelSitio">
   <h2>Navegación</h2>
   <?php require "navegacion.php" ?>
  </nav>
  
  <nav id="navegacionAncha" aria-label="Navegación del sitio">
   <?php require "navegacion.php" ?>
  </nav>
</header>