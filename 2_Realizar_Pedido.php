<?php
// Primero el insert de Pedido y despues LineaPedido
require_once('./mysql_connect.php');
$mensaje = "";
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

// Recuperamos las pizzas y precios y generamos safe_to_orig
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

// Procesamos el formulario
if (isset($_POST['brpedido'])){
    $dni = $_POST['dni'];
    $importe = 0;

    foreach ($_POST as $valorname => $cantidad){
        if ($valorname == 'dni' || $valorname == 'brpedido') continue;
        if (!isset($safe_to_orig[$valorname])) continue;

        $cantidadPizzas = $cantidad;
        $nom_original = $safe_to_orig[$valorname];
        $importe += $precios[$nom_original] * intval($cantidad);
    }

    $sql_insert_pedido = "INSERT into Pedido (dni_cliente, importe) values ('$dni', $importe);";
    $lerroak_pedido = mysqli_query($konexioa, $sql_insert_pedido);
    $pedido_id = intval(mysqli_insert_id($konexioa));
    
    $sql_insert_lineapedido = "INSERT into LineaPedido (num_pedido, nom_pizza, unidades) values ($pedido_id, '$nom_original', $cantidadPizzas);";
    $lerroak_lineapedido = mysqli_query($konexioa, $sql_insert_lineapedido);

    if($lerroak_pedido && $lerroak_lineapedido){
        echo "Pedido insertado correctamente";
    } else {
        $mensaje = "Error al insertar";
    }

    echo "El importe total de tu pedido asciende a: ".$importe."€";
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

        <?php if($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>

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
    </div>
</body>
</html>
