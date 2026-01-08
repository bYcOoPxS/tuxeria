<?php
// Lógica PHP primero
require_once('./tuxconexion.php');

$mensaje_error = "";

if(isset($_POST['blogin'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    try { // Intenta conectarse con las credenciales proporcionadas en las credenciales 
        
    $konexioa = mysqli_connect(zerbitzaria, $user, $pass, db);
    mysqli_set_charset($konexioa, 'utf8');

        header("Location: ./1_Panel.php");
        exit;
    } 
    catch(mysqli_sql_exception) {
        $mensaje_error = "Erabiltzailea edo pasahitza txarto"; // Si no lo consigue en vez de soltar tremendo error tye sale el mensaje de error que se especifica
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tuxeria Pizzeria</title>
    <link rel="stylesheet" href="./tuxestilo.css">
</head>
<body>
<div class="container">
    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo">

    <?php if($mensaje_error) echo "<p class='error'>$mensaje_error</p>"; ?>

    <form action="#" method="post">
        <label for="user">Erabiltzailea</label>
        <input type="text" name="user" id="user" required>

        <label for="pass">Pasahitza:</label>
        <input type="password" name="pass" id="pass" required>

        <input type="submit" name="blogin" value="Sisteman sartu">
    </form>
</div>
</body>
</html>
