<?php
session_start();

// Cargo los datos iniciales solo si todavía no existen en la sesión
if (!isset($_SESSION["preguntes"])) {
    include "dades.php";
    $_SESSION["categories"] = $categories;
    $_SESSION["preguntes"] = $preguntes;
}
if (!isset($_SESSION["usuaris"])) {
    include "dades.php";
    $_SESSION["usuaris"] = $usuaris;
}
