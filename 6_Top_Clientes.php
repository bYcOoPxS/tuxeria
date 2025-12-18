<?php
require_once('./ahilak.php');
require_once('./mysql_connect.php');
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

$sql_top_clientes = "SELECT * from top_clientes order by cant_pizzas desc, cant_pedidos";
$lerroak_top_clientes = mysqli_query($konexioa, $sql_top_clientes);

$sql_mes = "SELECT MONTHNAME(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AS hila_inglesa;";
$lerroak_mes = mysqli_query($konexioa, $sql_mes);
$resultado_meses = mysqli_fetch_assoc($lerroak_mes);

$mes = $resultado_meses['hila_inglesa'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./tuxestilo.css">
    <title>TOP BEZEROAK TUXERIAn</title>
</head>
<body>

<div class="container-topclientes" id="top-clientes-container">
    <img src="./images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rtopclientes">
    <h1 class="panel-title">TOP BEZEROAK (<?php echo $ahilak[$mes] ?>)</h1>

    <table id="tabla-top-clientes">
        <thead>
            <tr>
                <th>Izena</th>
                <th>Eskaera totalak</th>
                <th>Pizza Totalak</th>
            </tr>
        </thead>
        <tbody>
        <?php while($atopclientes = mysqli_fetch_assoc($lerroak_top_clientes)): 
            $nombre = $atopclientes['nombre'];
            $cant_pedidos = $atopclientes['cant_pedidos'];
            $cant_pizzas = $atopclientes['cant_pizzas'];
        ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $cant_pedidos; ?></td>
                <td><?php echo $cant_pizzas; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="./1_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
</div>
</body>
</html>
