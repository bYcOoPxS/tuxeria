<?php
    require_once('./mysql_connect.php');
    $mensaje_exito = "";
    $mensaje_error = "";
if (isset($_POST['brpizza'])){

    $konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
    mysqli_set_charset($konexioa, 'utf8');

    $nombre = $_POST['nombre'];
    $desc = $_POST['desc'];
    $tprep = intval($_POST['tprep']);
    $precio = floatval($_POST['precio']);
    // pizzastotales pero default 0

    $sql_insert = "INSERT into Pizza (nom_pizza, tiempo_prep, precio, descripcion) values ('$nombre', $tprep, $precio, '$desc');";
    $insert_query = mysqli_query($konexioa, $sql_insert);

    if ($insert_query){
        $mensaje_exito = "PIZZA TXERTATUTA!<br>$nombre izeneko pizza datu basean txertatu da";
    } else {
        $mensaje_error = "PIZZA EZIN IZAN DA TXERTATU!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tuxestilo.css">
    <title>Pizza bat erregistratu</title>
</head>
<body>
    <div class="container-rpizza">
    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rcliente">

<?php
    if ($mensaje_exito) {
            echo "<p class='mensaje-exito'>$mensaje_exito</p>";
        }
        if ($mensaje_error) {
            echo "<p class='mensaje-error'>$mensaje_error</p>";
        }
?>

    <form class="rpizza-form" action="#" method="post">
        <label for="rpizza-nombre">Pizzaren Izena:</label>
        <input type="text" name="nombre" id="rpizza-nombre" required max="30">

        <label for="rpizza-desc">Deskribapena:</label>
        <input type="text" name="desc" id="rpizza-desc" required max="200">

        <label for="rpizza-tprep">Sukaldatzeko denbora(min):</label>
        <input type="number" name="tprep" id="rpizza-tprep" required>

        <label for="rpizza-precio">Salmenta prezioa(XX.YY):</label>
        <input type="text" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" name="precio" id="rpizza-precio" required>

        <input type="submit" name="brpizza" value="Registrar Pizza">
    </form>
    <a href="./1_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
</div>
<?php
    mysqli_close($konexioa);
?>
</body>
</html>