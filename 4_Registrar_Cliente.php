<?php
    require_once('./mysql_connect.php');
    $mensaje_exito = "";
    $mensaje_error = "";
if (isset($_POST['brcliente'])){

    $konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
    mysqli_set_charset($konexioa, 'utf8');


    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $dir = $_POST['dir'];
    $pob = $_POST['pob'];
    $tlf = intval($_POST['tlf']);
    $email = $_POST['email'];
    // now()

$sql_insert = "INSERT into Cliente (DNI, nombre, direccion, poblacion, telefono, email, fecha_alta) values ('$dni', '$nombre', '$dir', '$pob', $tlf, '$email', now());";
$insert_query = mysqli_query($konexioa, $sql_insert);

if ($insert_query){
    $mensaje_exito = "BEZEROA ERREGISTRATUTA!<br>$nombre izeneko bezeroa, $dni DNI-arekin erregistratu egin da";
} else {
    $mensaje_error = "BEZEROA ERREGISTRATZEAN ERRORE BAT EGON DA!";
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tuxestilo.css">
    <title>Bezeroa erregistratu</title>
</head>
<body>
    <div class="container-rcliente">
    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rcliente">
<?php
    if ($mensaje_exito) {
            echo "<p class='mensaje-exito'>$mensaje_exito</p>";
        }
        if ($mensaje_error) {
            echo "<p class='mensaje-error'>$mensaje_error</p>";
        }
?>

    <form class="rcliente-form" action="#" method="post">
        <label for="rcliente-dni">DNI:</label>
        <input type="text" name="dni" id="rcliente-dni" required>

        <label for="rcliente-nombre">Izena:</label>
        <input type="text" name="nombre" id="rcliente-nombre" required>

        <label for="rcliente-dir">Helbidea:</label>
        <input type="text" name="dir" id="rcliente-dir" required>

        <label for="rcliente-pob">Herrialdea:</label>
        <input type="text" name="pob" id="rcliente-pob" required>

        <label for="rcliente-tlf">Telefonoa:</label>
        <input type="number" name="tlf" id="rcliente-tlf" required>

        <label for="rcliente-email">Emaila:</label>
        <input type="email" name="email" id="rcliente-email" required>

        <input type="submit" name="brcliente" value="Bezeroa erregistratu">
    </form>
    <a href="./1_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
</div>
<?php
    mysqli_close($konexioa);
?>
</body>
</html>