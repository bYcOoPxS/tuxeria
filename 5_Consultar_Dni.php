<?php
require_once('./mysql_connect.php');
$mensaje_exito = "";
$mensaje_error = "";
if (isset($_POST['bconalta'])){

    $konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
    mysqli_set_charset($konexioa, 'utf8');

    $dni = $_POST['dni'];

    $sql_cliente = "SELECT DNI, nombre, email from Cliente where DNI = '$dni';";
    $lerroak_cliente = mysqli_query($konexioa, $sql_cliente);

    // Comprobar si la consulta devolvió alguna fila
    if ($lerroak_cliente && mysqli_num_rows($lerroak_cliente) > 0) {
        $info_cliente = mysqli_fetch_assoc($lerroak_cliente);
        $nom_cliente = $info_cliente['nombre'];
        $dni_cliente = $info_cliente['DNI'];
        $mail_cliente = $info_cliente['email'];
        $mensaje_exito = "EXITO! El cliente ".$nom_cliente.", con DNI ".$dni_cliente." y mail ".$mail_cliente." esta correctamente registrado";
    } else {
        $mensaje_error = "ERROR! No se encuentra el DNI ".$dni." en la BBDD";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Cliente</title>
    <link rel="stylesheet" href="./tuxestilo.css">
</head>
<body>

<div class="container">  <!-- MISMA CAJA QUE EL PANEL -->

    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo">

    <h1 class="panel-title">BEZEROAREN ALTA</h1>

    <?php 
        if ($mensaje_exito) {
            echo "<p class='mensaje-exito'>$mensaje_exito</p>";
        }
        if ($mensaje_error) {
            echo "<p class='mensaje-error'>$mensaje_error</p>";
        }
    ?>

    <form action="#" method="post" class="conalta-form">
        <label for="conalta-dni">DNI:</label>
        <input type="text" name="dni" id="conalta-dni" required>

        <input type="submit" name="bconalta" value="Comprobar Cliente" class="button">
    </form>

    <a href="./1_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>

</div>

</body>
</html>
