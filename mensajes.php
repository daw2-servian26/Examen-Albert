<?php
// muestyor los mensajes y luego los borran
if (isset($_SESSION["missatge"])) {
    echo '<div class="alerta">' . $_SESSION["missatge"] . '</div>';
    unset($_SESSION["missatge"]);
}
if (isset($_SESSION["error"])) {
    echo '<div class="alerta">' . $_SESSION["error"] . '</div>';
    unset($_SESSION["error"]);
}
