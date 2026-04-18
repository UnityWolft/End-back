<?php
session_start();
if(isset($_SESSION["x"])) {
 unset($_SESSION["x"]);
}
session_destroy();
header("location: index.php");