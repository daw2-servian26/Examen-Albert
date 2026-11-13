<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accio"]) && $_POST["accio"] == "reiniciar") {

    // Como administrador, se puede reiniciar
    if (!isset($_SESSION["usuari_actiu"]) || $_SESSION["usuari_actiu"]["rol"] != "admin") {
        header("Location: login.php");
        exit;
    }

    // Se borra todo
    $_SESSION = [];
    session_destroy();

} else {

    // Solo borro el usuario y la partida
    unset($_SESSION["usuari_actiu"]);
    unset($_SESSION["partida"]);
}

header("Location: index.php");
exit;
