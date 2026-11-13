<?php
include "inicia.php";
$titol = "Inici";
include "header.php";
?>
    <main class="contenidor">
      <section class="panell">
        <span class="etiqueta">Examen pràctic · PHP</span>
        <h1>Benvingut al Trivial</h1>
        <p class="subtitol">
          Una aplicació de preguntes de cultura general.
        </p>
        <?php include "mensajes.php"; ?>
        <div class="grid">
          <div>
            <h2>Soc jugador</h2>
            <p>Registra't, inicia sessió i supera les preguntes una a una.</p>
            <?php if (!isset($_SESSION["usuari_actiu"])) { ?>
              <a class="btn" href="registre.php">Crear compte</a>
              <a class="btn btn-sec" href="login.php">Ja tinc compte</a>
            <?php } else { ?>
              <a class="btn" href="joc.php">Anar al joc</a>
            <?php } ?>
          </div>
          <div>
            <h2>Soc administrador</h2>
            <p>Gestiona el banc de preguntes: consulta, afegeix, edita i elimina.</p>
            <a class="btn btn-sec" href="admin.php">Anar a administració</a>
          </div>
        </div>
      </section>
    </main>
<?php include "footer.php"; ?>
