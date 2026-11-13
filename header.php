<!doctype html>
<html lang="ca">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $titol; ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <header class="cap">
      <div class="contenidor navegacio">
        <a class="marca" href="index.php">TRIVIAL Pe1</a>
        <nav class="enllacos">
          <a href="index.php">Inici</a>
          <?php if (!isset($_SESSION["usuari_actiu"])) { ?>
            <a href="registre.php">Registre</a>
            <a href="login.php">Login</a>
          <?php } else { ?>
            <?php if ($_SESSION["usuari_actiu"]["rol"] == "jugador") { ?>
              <a href="joc.php">Joc</a>
            <?php } ?>
            <a href="admin.php">Administració</a>
            <a href="logout.php">Logout</a>
          <?php } ?>
        </nav>
      </div>
    </header>