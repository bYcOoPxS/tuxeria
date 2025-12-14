<?php
// Conexión a la base de datos
require_once('./mysql_connect.php');
$mensaje = "";
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

// Recuperamos todas las pizzas con sus precios
$sql_pizzas = "SELECT nom_pizza, precio FROM Pizza";
$lerroak_pizza = mysqli_query($konexioa, $sql_pizzas);

// Arrays:
// $precios        => precio de cada pizza según el nombre real
// $safe_to_orig   => mapeo de nombres del formulario a los nombres reales
$precios = [];
$safe_to_orig = [];

while($apizza = mysqli_fetch_assoc($lerroak_pizza)){
    $nom_pizza = $apizza['nom_pizza'];
    $precio = $apizza['precio'];

    // Nombre del input seguro (sin espacios)
    $safe_name = str_replace(' ', '_', $nom_pizza);

    // Guardamos precio y mapeo
    $precios[$nom_pizza] = $precio;
    $safe_to_orig[$safe_name] = $nom_pizza;
}



// Cuando se envía el formulario
if (isset($_POST['brpedido'])){

    $dni = $_POST['dni'];

    // Importe total del pedido
    $importe = 0;

    // Array donde guardaremos todas las líneas de pedido
    // Cada elemento será: ['nom_pizza' => ..., 'cantidad' => ...]
    $lineasPedido = [];



    // 1. RECORREMOS EL FORMULARIO Y CONSTRUIMOS EL PEDIDO
    foreach ($_POST as $valorname => $cantidad){

        // Ignoramos DNI y el botón del formulario
        if ($valorname == 'dni' || $valorname == 'brpedido') continue;

        // Si no es un input válido (pizza real), lo saltamos
        if (!isset($safe_to_orig[$valorname])) continue;

        // Convertimos cantidad a número entero
        $cantidad_int = intval($cantidad);

        // Si es 0 o negativa, no se añade al pedido
        if ($cantidad_int <= 0) continue;

        // Obtenemos el nombre original de la pizza
        $nom_original = $safe_to_orig[$valorname];

        // Sumamos al importe total
        $importe += $precios[$nom_original] * $cantidad_int;

        // Guardamos la línea en el array para luego insertarla
        $lineasPedido[] = [
            'nom_pizza' => $nom_original,
            'cantidad'  => $cantidad_int
        ];
    }



    // 2. INSERTAMOS EL PEDIDO EN LA TABLA PEDIDO
    $sql_insert_pedido = "
        INSERT into Pedido (dni_cliente, importe)
        values ('$dni', $importe);
    ";

    $lerroak_pedido = mysqli_query($konexioa, $sql_insert_pedido);

    // Recuperamos el ID del pedido recién insertado
    $pedido_id = mysqli_insert_id($konexioa);



    // 3. INSERTAMOS TODAS LAS LÍNEAS DEL PEDIDO UNA A UNA
    foreach ($lineasPedido as $linea) {

        $nom_pizza = $linea['nom_pizza'];
        $cantidad  = $linea['cantidad'];

        $sql_insert_lineapedido = "
            INSERT into LineaPedido (num_pedido, nom_pizza, unidades)
            values ($pedido_id, '$nom_pizza', $cantidad);
        ";

        mysqli_query($konexioa, $sql_insert_lineapedido);
    }



    // Mensaje final
    if($lerroak_pedido){
        echo "Pedido insertado correctamente<br>";
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
