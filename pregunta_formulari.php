<?php
include "inicia.php";

// Solo se puede entrar si se es administrador
if (!isset($_SESSION["usuari_actiu"])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION["usuari_actiu"]["rol"] != "admin") {
    header("Location: joc.php");
    exit;
}

// uso id = 0 para indicar una pregunta nueva
$id = 0;
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
}

$error = "";

// dejo el formulario vacío
$pregunta = [
    "categoria" => "",
    "pregunta" => "",
    "opcions" => ["", "", "", ""],
    "correcta" => 0
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pregunta["categoria"] = $_POST["categoria"];
    $pregunta["pregunta"] = $_POST["pregunta"];
    $pregunta["opcions"] = [
        $_POST["opcio_0"],
        $_POST["opcio_1"],
        $_POST["opcio_2"],
        $_POST["opcio_3"]
    ];
    $pregunta["correcta"] = (int) $_POST["correcta"];

    // Se valida
    if ($pregunta["categoria"] == "" || $pregunta["pregunta"] == "") {
        $error = "La categoria i l'enunciat són obligatoris.";
    } elseif ($pregunta["opcions"][0] == "" || $pregunta["opcions"][1] == "" || $pregunta["opcions"][2] == "" || $pregunta["opcions"][3] == "") {
        $error = "Les quatre opcions són obligatòries.";
    } elseif ($pregunta["correcta"] < 0 || $pregunta["correcta"] > 3) {
        $error = "Resposta correcta no vàlida.";
    } else {
        if ($id == 0) {
            // buscoel id más grande y se le suma 1
            $max = 0;
            foreach ($_SESSION["preguntes"] as $p) {
                if ($p["id"] > $max) {
                    $max = $p["id"];
                }
            }
            $pregunta["id"] = $max + 1;
            array_push($_SESSION["preguntes"], $pregunta);
            $_SESSION["missatge"] = "Pregunta creada.";
        } else {
            // busco la posición y se sustituye
            $pregunta["id"] = $id;
            foreach ($_SESSION["preguntes"] as $i => $p) {
                if ($p["id"] == $id) {
                    $_SESSION["preguntes"][$i] = $pregunta;
                }
            }
            $_SESSION["missatge"] = "Pregunta actualitzada.";
        }
        header("Location: admin.php");
        exit;
    }
} else {
    // se rellena el formulario con la pregunta existente si se quiere editar
    if ($id != 0) {
        $trobada = false;
        foreach ($_SESSION["preguntes"] as $p) {
            if ($p["id"] == $id) {
                $pregunta = $p;
                $trobada = true;
            }
        }
        if (!$trobada) {
            $_SESSION["error"] = "La pregunta no existeix.";
            header("Location: admin.php");
            exit;
        }
    }
}

$titol = "Pregunta";
include "header.php";
?>
    <main class="contenidor">
      <section class="panell ample-mig">
        <h1>Crear o editar pregunta</h1>
        <?php if ($error != "") { ?>
          <div class="alerta" style="background:#fde8e8;color:#a12020"><?php echo $error; ?></div>
        <?php } ?>
        <form action="pregunta_formulari.php?id=<?php echo $id; ?>" method="post">
          <label class="camp">Categoria
            <select name="categoria" required>
              <option value="">Selecciona una categoria</option>
              <?php foreach ($_SESSION["categories"] as $cat) { ?>
                <option <?php if ($pregunta["categoria"] == $cat) { echo "selected"; } ?>><?php echo $cat; ?></option>
              <?php } ?>
            </select></label>
          <label class="camp">Enunciat
            <textarea name="pregunta" required placeholder="Escriu l'enunciat..."><?php echo htmlspecialchars($pregunta["pregunta"]); ?></textarea></label>
          <label class="camp">Opció A
            <input type="text" name="opcio_0" value="<?php echo htmlspecialchars($pregunta["opcions"][0]); ?>" required /></label>
          <label class="camp">Opció B
            <input type="text" name="opcio_1" value="<?php echo htmlspecialchars($pregunta["opcions"][1]); ?>" required /></label>
          <label class="camp">Opció C
            <input type="text" name="opcio_2" value="<?php echo htmlspecialchars($pregunta["opcions"][2]); ?>" required /></label>
          <label class="camp">Opció D
            <input type="text" name="opcio_3" value="<?php echo htmlspecialchars($pregunta["opcions"][3]); ?>" required /></label>
          <label class="camp">Resposta correcta
            <select name="correcta" required>
              <option value="0" <?php if ($pregunta["correcta"] == 0) { echo "selected"; } ?>>A</option>
              <option value="1" <?php if ($pregunta["correcta"] == 1) { echo "selected"; } ?>>B</option>
              <option value="2" <?php if ($pregunta["correcta"] == 2) { echo "selected"; } ?>>C</option>
              <option value="3" <?php if ($pregunta["correcta"] == 3) { echo "selected"; } ?>>D</option>
            </select></label>
          <div class="accions">
            <button class="btn" type="submit">Guardar pregunta</button>
            <a class="btn btn-sec" href="admin.php">Cancel·lar</a>
          </div>
        </form>
      </section>
    </main>
<?php include "footer.php"; ?>
