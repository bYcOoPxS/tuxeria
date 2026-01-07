<?php
require_once('./mysql_connect.php');
    $mensaje_exito = "";
    $mensaje_error = "";
    $konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
    mysqli_set_charset($konexioa, 'utf8');
    if (isset($_POST['bqpizza'])){

$nom_pizza = strval($_POST['quitar_pizza']);

$sql_delete = "DELETE from Pizza where nom_pizza = '$nom_pizza';";
$lerroak_delete = mysqli_query($konexioa, $sql_delete);

if ($lerroak_delete){
    $mensaje_exito = $nom_pizza." izeneko pizza Tuxeriatik kendu da :(";
    } else {
        $mensaje_error = $nom_pizza." izeneko pizza ezin izan da Tuxeriatik kendu!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tuxestilo.css">
    <title>Pizza bat kendu</title>
</head>
<body>
<div class="container-qpizza">
    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rcliente">

<?php
    if ($mensaje_exito) {
            echo "<p class='mensaje-exito'>$mensaje_exito</p>";
        }
        if ($mensaje_error) {
            echo "<p class='mensaje-error'>$mensaje_error</p>";
        }
?>

    <form action="#" method="post">
        <label for="quitar_pizza">Pizza bat kendu</label>
        <select name="quitar_pizza">
            <option value="-1">Aukeratu Kentzeko pizza</option>
<?php
$sql_pizzas = "SELECT * from Pizza;";
$lerroak_pizzas = mysqli_query($konexioa, $sql_pizzas);

            while($apizzas = mysqli_fetch_assoc($lerroak_pizzas)){
                $nom_pizza = $apizzas['nom_pizza'];
                echo "<option value='$nom_pizza'>$nom_pizza</option>";
            }
?>
        </select>
        <input type="submit" name="bqpizza" value="Pizza Kendu">
    </form>
</div>
<?php
    mysqli_close($konexioa);
?>
</body>
</html>