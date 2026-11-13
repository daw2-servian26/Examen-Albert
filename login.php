<?php
include "inicia.php";

// Si ya se está dentro, no hace falta
if (isset($_SESSION["usuari_actiu"])) {
    if ($_SESSION["usuari_actiu"]["rol"] == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: joc.php");
    }
exit;

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_POST["usuari"];
    $password = $_POST["password"];
    $trobat = false;
    foreach ($_SESSION["usuaris"] as $u) {
        if ($u["usuari"] == $usuari && password_verify($password, $u["password"])) {
            $trobat = true;
            $_SESSION["usuari_actiu"] = [
                "id" => $u["id"],
                "usuari" => $u["usuari"],
                "rol" => $u["rol"]
            ];
            $_SESSION["partida"] = [
                "punts" => 0,
                "superades" => []
            ];
        }
    }

    if ($trobat) {
     if ($_SESSION["usuari_actiu"]["rol"] == "admin") {
            header("Location: admin.php");
     } else {
            header("Location: joc.php");
        }
exit;
    }
}

$titol = "Login";
include "header.php";
?>
<main class="contenidor">
    <section class="panell ample-mig">
       
    <h1>Iniciar sessió</h1>
       
    <p class="subtitol">Accedeix com a jugador o administrador.</p>
    
        <form action="login.php" method="post">
          <label class="camp">Nom d'usuari
            <input name="usuari" type="text" required /></label>
          <label class="camp">Contrasenya
            <input name="password" type="password" required /></label>
          <button class="btn" type="submit">Entrar</button>
        </form>
      </section>
    </main>
    
<?php include "footer.php"; ?>
