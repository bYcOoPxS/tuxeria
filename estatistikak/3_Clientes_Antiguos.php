<?php
require_once('../ahilak.php');
require_once('../mysql_connect.php');
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

$sql_clientes_antiguos = "SELECT nombre, ped_realizados, pizzastotales from clientes_antiguos order by ped_realizados desc, pizzastotales";
$lerroak_clientes_antiguos = mysqli_query($konexioa, $sql_clientes_antiguos);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../tuxestilo.css">
    <title>TOP BEZEROAK TUXERIAn</title>
</head>
<body>

<div class="container-topclientes" id="top-clientes-container">
    <img src="../images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rtopclientes">
    <h1 class="panel-title">ASPALDIKO BEZEROAK</h1>

    <table id="tabla-top-clientes">
        <thead>
            <tr>
                <th>Izena</th>
                <th>Eskaera totalak</th>
                <th>Pizza Totalak</th>
            </tr>
        </thead>
        <tbody>
        <?php while($acliants = mysqli_fetch_assoc($lerroak_clientes_antiguos)){ 
            $nombre = $acliants['nombre'];
            $cant_pedidos = $acliants['ped_realizados'];
            $cant_pizzas = $acliants['pizzastotales'];
        ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $cant_pedidos; ?></td>
                <td><?php echo $cant_pizzas; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="./1_Estatistikak_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
</div>
</body>
</html>
