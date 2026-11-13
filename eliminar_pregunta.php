<?php
include "inicis.php";

// Solo se puede acceder como administrador
if (!isset($_SESSION["usuari_actiu"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["usuari_actiu"]["rol"] != "admin") {
    header("Location: joc.php");
    exit;
}

// Por url
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = (int) $_POST["id"];

    // creo n array nuevo con todas las preguntas menos la que se elimina
    $noves = [];
    foreach ($_SESSION["preguntes"] as $p) {
        if ($p["id"] != $id) {
            array_push($noves, $p);
        }
    }

    $_SESSION["preguntes"] = $noves;
    $_SESSION["missatge"] = "pregfunta eliminada";
}


header("Location: admin.php");
exit;
