
<?php

include "inicia.php";

// No se puede entrar sin iniciar sesión
if (!isset($_SESSION["usuari_actiu"])) {
    header("Location: login.php");
    exit;
}

$es_admin = false;
if ($_SESSION["usuari_actiu"]["rol"] == "admin") {
    $es_admin = true;
}

$titol = "Administració";
include "header.php";
?>
    <main class="contenidor">
      <section class="panell">
    <div class="navegacio">
          <div>
            <h1>Gestió de preguntes</h1>
            <p class="subtitol">Total: <?php echo count($_SESSION["preguntes"]); ?> preguntes</p>
          </div>
          <?php if ($es_admin) { ?>
            <a class="btn" href="pregunta_formulari.php">+ Nova pregunta</a>
          <?php } ?>
        </div>

        <?php include "mensajes.php"; ?>

        <div class="taula-responsive">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Enunciat</th>
                <?php if ($es_admin) { ?>
                  <th>Accions</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION["preguntes"] as $p) { ?>
                <tr>
                  <td><?php echo $p["id"]; ?></td>
                  <td><?php echo htmlspecialchars($p["categoria"]); ?></td>
                  <td><?php echo htmlspecialchars($p["pregunta"]); ?></td>
                  <?php if ($es_admin) { ?>
                  <td>
     <a class="btn btn-sec" href="pregunta_formulari.php?id=<?php echo $p["id"]; ?>">Editar</a>
          <form method="post" action="eliminar_pregunta.php" style="display:inline">
            <input type="hidden" name="id" value="<?php echo $p["id"]; ?>" />
                  <button class="btn btn-perill" type="submit">Eliminar</button>
               </form>
                    </td>
             <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <?php if ($es_admin) { ?>
          <form method="post" action="logout.php" style="margin-top:20px">
            <input type="hidden" name="accio" value="reiniciar" />
            <button class="btn btn-perill" type="submit">Reiniciar l'aplicació</button>
          </form>
        <?php } else { ?>
          <p class="nota">Només l'administrador pot modificar les preguntes.</p>
        <?php } ?>
      </section>
    </main>
<?php include "footer.php"; ?>
