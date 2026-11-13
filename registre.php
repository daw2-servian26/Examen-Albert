<?php
include "inicia.php";

$error = "";
$usuari = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_POST["usuari"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($usuari == "" || $password == "" || $password2 == "") {
        $error = "Cal omplir tots els camps.";
    } elseif ($password != $password2) {
        $error = "Les contrasenyes no coincideixen.";
    } else {
        // Se comprueba que no exista
        $existeix = false;
        foreach ($_SESSION["usuaris"] as $u) {
            if ($u["usuari"] == $usuari) {
                $existeix = true;
            }
        }

        if ($existeix) {
            $error = "Aquest nom d'usuari ja existeix.";
        } else {
            $nou = [
                "id" => count($_SESSION["usuaris"]) + 1,
                "usuari" => $usuari,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "rol" => "jugador"
            ];
            array_push($_SESSION["usuaris"], $nou);
            $_SESSION["missatge"] = "Compte creat. Ja pots iniciar sessió.";
            header("Location: login.php");
            exit;
        }
    }
}

$titol = "Registre";
include "header.php";
?>
    <main class="contenidor">
      <section class="panell ample-mig">
        <h1>Registre de jugador</h1>
        <p class="subtitol">Crea un compte per poder jugar.</p>
        <?php if ($error != "") { ?>
          <div class="alerta" style="background:#fde8e8;color:#a12020"><?php echo $error; ?></div>
        <?php } ?>
        <form action="registre.php" method="post">
          <label class="camp">Nom d'usuari
            <input type="text" name="usuari" value="<?php echo htmlspecialchars($usuari); ?>" required /></label>
          <label class="camp">Contrassenya
            <input type="password" name="password" required /></label>
          <label class="camp">Repeteix la contrassenya
            <input type="password" name="password2" required /></label>
          <button class="btn" type="submit">Registrar-me</button>
        </form>
      </section>
    </main>
<?php include "footer.php"; ?>
