<?php
    $mensaje = "";
if (isset($_POST['brcliente'])){

    define('zerbitzaria', 'localhost');
    define('erabiltzailea', 'root');                      // CONSTANTES PARA LA CONEXION A LA BBDD
    define('pasahitza', '');
    define('db', 'tuxeria');

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
    echo "<h1>Cliente insertado</h1>";
    echo "El cliente ".$nombre.", con DNI ".$dni." ha sido correctamente registrado en la BBDD";
} else {
    $mensaje = "Error al insertar";
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

    <?php if($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>

    <form class="rcliente-form" action="#" method="post">
        <label for="rcliente-dni">DNI:</label>
        <input type="text" name="dni" id="rcliente-dni" required>

        <label for="rcliente-nombre">Nombre:</label>
        <input type="text" name="nombre" id="rcliente-nombre" required>

        <label for="rcliente-dir">Direccion:</label>
        <input type="text" name="dir" id="rcliente-dir" required>

        <label for="rcliente-pob">Poblacion:</label>
        <input type="text" name="pob" id="rcliente-pob" required>

        <label for="rcliente-tlf">Telefono:</label>
        <input type="number" name="tlf" id="rcliente-tlf" required>

        <label for="rcliente-email">Email:</label>
        <input type="email" name="email" id="rcliente-email" required>

        <input type="submit" name="brcliente" value="Registrar Cliente">
    </form>
</div>
</body>
</html>