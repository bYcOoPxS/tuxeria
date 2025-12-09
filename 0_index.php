<?php
// Lógica PHP primero
define('zerbitzaria', 'localhost');
define('erabiltzailea', 'root');                      // CONSTANTES PARA LA CONEXION A LA BBDD
define('pasahitza', '');
define('db', 'tuxeria');

$mensaje_error = "";

if(isset($_POST['blogin'])){
    $konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
    mysqli_set_charset($konexioa, 'utf8');

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $sql_login = "SELECT * FROM users WHERE username = '$user';";
    $resultado = mysqli_fetch_assoc(mysqli_query($konexioa, $sql_login));

    if($resultado && password_verify($pass, $resultado['password'])){
        // Redirigir al panel ANTES de HTML
        header("Location: ./1_Panel.php");
        exit;
    } else {
        $mensaje_error = "Erabiltzailea edo pasahitza txarto";
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
