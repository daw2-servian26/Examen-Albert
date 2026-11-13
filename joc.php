<?php
include "inicia.php";

// identifivo a los jugadores
if (!isset($_SESSION["usuari_actiu"])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION["usuari_actiu"]["rol"] != "jugador") {
    header("Location: admin.php");
    exit;
}

// Por si la partida no existe
if (!isset($_SESSION["partida"])) {
    $_SESSION["partida"] = [
        "punts" => 0,
        "superades" => []
    ];
}

// Se busca la primera pregunta que aún no se ha superado
$pregunta = null;
foreach ($_SESSION["preguntes"] as $p) {
    if ($pregunta == null && !in_array($p["id"], $_SESSION["partida"]["superades"])) {
        $pregunta = $p;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["accio"] == "nova") {
        // Se inicia una partida nueva
        $_SESSION["partida"] = [
            "punts" => 0,
            "superades" => []
        ];

    } elseif ($_POST["accio"] == "respondre") {

        // compruebo respuesta a la pregunta actual
        if ($pregunta != null && isset($_POST["resposta"]) && $_POST["id"] == $pregunta["id"]) {
            if ($_POST["resposta"] == $pregunta["correcta"]) {
                $_SESSION["partida"]["punts"] = $_SESSION["partida"]["punts"] + 1;
                array_push($_SESSION["partida"]["superades"], $pregunta["id"]);
                $_SESSION["missatge"] = "Correcte! Has sumat un punt.";
            } else {
                $_SESSION["error"] = "Resposta incorrecta. Torna-ho a provar!";
            }
        }
    }

    // redirigo para que no se repita el formulario si se recarga la página (me pasaba todo el rato)
    header("Location: joc.php");
    exit;
}

// calculo estadísticas
$total = count($_SESSION["preguntes"]);
$pendents = 0;
foreach ($_SESSION["preguntes"] as $p) {
    if (!in_array($p["id"], $_SESSION["partida"]["superades"])) {
        $pendents = $pendents + 1;
    }
}
$progres = $total - $pendents;

$titol = "Trivial";
include "header.php";
?>
    <main class="contenidor">
      <section class="panell">
        <h1>Hola, <?php echo htmlspecialchars($_SESSION["usuari_actiu"]["usuari"]); ?>!</h1>
        <div class="estadistiques">
          <span><strong>Puntuació:</strong> <?php echo $_SESSION["partida"]["punts"]; ?> punts</span>
          <span><strong>Progrés:</strong> <?php echo $progres; ?> de <?php echo $total; ?></span>
          <span><strong>Pendents:</strong> <?php echo $pendents; ?></span>
        </div>

        <?php include "mensajes.php"; ?>

        <?php if ($pregunta != null) { ?>
        <span class="etiqueta"><?php echo $pregunta["categoria"]; ?></span>

    
        <h2 style="margin-top: 15px"><?php echo htmlspecialchars($pregunta["pregunta"]); ?></h2>
        
        <form method="post" action="joc.php">
        <input type="hidden" name="accio" value="respondre" />
        <input type="hidden" name="id" value="<?php echo $pregunta["id"]; ?>" />
            <?php foreach ($pregunta["opcions"] as $i => $opcio) { ?>
              <label class="resposta">
                <input type="radio" name="resposta" value="<?php echo $i; ?>" required /><?php echo htmlspecialchars($opcio); ?>
              </label>
            <?php } ?>
            <button class="btn" type="submit">Comprovar resposta</button>
          </form>
        <?php } else { ?>
          <h2>partida acabada.</h2>
          <p class="subtitol">Resultat final: <?php echo $_SESSION["partida"]["punts"]; ?> punts de <?php echo $total; ?>.</p>
          <form method="post" action="joc.php">
            <input type="hidden" name="accio" value="nova" />
            <button class="btn" type="submit">Nova partida</button>
          </form>
        <?php } ?>
      </section>
    </main>
<?php include "footer.php"; ?>
