<?php
// Conexión a la base de datos
require_once('./mysql_connect.php');
$mensaje_exito = "";
$mensaje_error = "";
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

// Recuperamos todas las pizzas con sus precios
$sql_pizzas = "SELECT nom_pizza, precio FROM Pizza";
$lerroak_pizza = mysqli_query($konexioa, $sql_pizzas);

$precios = [];
$safe_to_orig = [];

while($apizza = mysqli_fetch_assoc($lerroak_pizza)){
    $nom_pizza = $apizza['nom_pizza'];
    $precio = $apizza['precio'];
    $safe_name = str_replace(' ', '_', $nom_pizza);
    $precios[$nom_pizza] = $precio;
    $safe_to_orig[$safe_name] = $nom_pizza;
}

// Cuando se envía el formulario
if (isset($_POST['brpedido'])){

    $dni = $_POST['dni'];
    $importe = 0;
    $lineasPedido = [];

    // Sacar el nombre del cliente
    $sql_nom_cliente = "SELECT nombre from Cliente where DNI = '$dni';";
    $lerroak_nom_cliente = mysqli_query($konexioa, $sql_nom_cliente);
    $cliente = mysqli_fetch_assoc($lerroak_nom_cliente);
    $nombre = strtoupper($cliente['nombre']);

    // Resumen del pedido centrado y con clase
    $resumenPedido = "<div class='resumen-pedido'>";

    foreach ($_POST as $valorname => $cantidad){
        if ($valorname == 'dni' || $valorname == 'brpedido') continue;
        if (!isset($safe_to_orig[$valorname])) continue;

        $cantidad_int = intval($cantidad);
        if ($cantidad_int <= 0) continue;

        $nom_original = $safe_to_orig[$valorname];
        $importe += $precios[$nom_original] * $cantidad_int;

        $lineasPedido[] = [
            'nom_pizza' => $nom_original,
            'cantidad'  => $cantidad_int
        ];

        // Añadimos al resumen con <br>
        $resumenPedido .= "$nom_original ({$precios[$nom_original]} €) × $cantidad_int<br>";
    }

    $resumenPedido .= "</div>";

    // Insertamos pedido en la tabla Pedido
    $sql_insert_pedido = "INSERT into Pedido (dni_cliente, importe) values ('$dni', $importe);";
    $lerroak_pedido = mysqli_query($konexioa, $sql_insert_pedido);
    $pedido_id = mysqli_insert_id($konexioa);

    // Insertamos las líneas del pedido
    foreach ($lineasPedido as $linea) {
        $nom_pizza = $linea['nom_pizza'];
        $cantidad  = $linea['cantidad'];
        $sql_insert_lineapedido = "
            INSERT into LineaPedido (num_pedido, nom_pizza, unidades)
            values ($pedido_id, '$nom_pizza', $cantidad);
        ";
        mysqli_query($konexioa, $sql_insert_lineapedido);
    }

    // Mensaje de éxito con resumen y total
    if($lerroak_pedido){
        $mensaje_exito = "
            Eskaera gure chef-ari ailegatu zaio $nombre<br><br>
            <strong>Eskaeraren laburpena:</strong><br>
            $resumenPedido
            <strong>Eskaeraren prezio finala:</strong> $importe €
        ";
    } else {
        $mensaje_error = "Eskaera errore bat izan du!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tuxestilo.css">
    <title>Eskaera egin</title>
</head>
<body>
    <div class="container-rpedido">
        <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rcliente">

<?php
        if ($mensaje_exito) {
            echo "<p class='mensaje-exito'>$mensaje_exito</p>";
        }
        if ($mensaje_error) {
            echo "<p class='mensaje-error'>$mensaje_error</p>";
        }
?>

        <form class="rpedido-form" action="#" method="post">
            <label for="rpedido-dni">DNI:</label>
            <input type="text" name="dni" id="rpedido-dni" required>

            <?php
            foreach ($safe_to_orig as $safe_name => $nom_original){
                $precio = $precios[$nom_original];
                echo "<div class='pizza-item'>";
                echo "<label for='$safe_name'>$nom_original ($precio €)</label>";
                echo "<input type='number' name='$safe_name' id='$safe_name' min='0' value='0'>";
                echo "</div>";
            }
            ?>
            <br>
            <input type="submit" name="brpedido" value="Eskaera egin">
        </form>
        <a href="./1_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
    </div>
</body>
</html>
