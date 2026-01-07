<?php
require_once('../ahilak.php');
require_once('../mysql_connect.php');
$konexioa = mysqli_connect(zerbitzaria, erabiltzailea, pasahitza, db);
mysqli_set_charset($konexioa, 'utf8');

$sql_clientes_sinpe= "SELECT nombre, fecha_alta, ped_realizados from clientes_nuevossinped order by ped_realizados desc, fecha_alta";
$lerroak_clientes_sinpe = mysqli_query($konexioa, $sql_clientes_sinpe);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../tuxestilo.css">
    <title>ESKAERIK GABEKO BEZEROAK TUXERIAn</title>
</head>
<body>

<div class="container-topclientes" id="top-clientes-container">
    <img src="../images/tuxxeria_blue.png" alt="Tuxeria Logo" class="logo-rtopclientes">
    <h1 class="panel-title">ESKAERIK GABEKO BEZEROAK</h1>

    <table id="tabla-top-clientes">
        <thead>
            <tr>
                <th>Izena</th>
                <th>Altako Data</th>
                <th>Eskaera Totalak</th>
            </tr>
        </thead>
        <tbody>
        <?php while($aclientessinpe = mysqli_fetch_assoc($lerroak_clientes_sinpe)){ 
            $nombre = $aclientessinpe['nombre'];
            $fecha_alta = $aclientessinpe['fecha_alta'];
            $ped_realizados = $aclientessinpe['ped_realizados'];
        ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $fecha_alta; ?></td>
                <td><?php echo $ped_realizados; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <a href="./1_Estatistikak_Panel.php" class="button" style="margin-top: 1rem;">Atzera</a>
</div>
<?php
    mysqli_free_result($lerroak_clientes_sinpe);

    mysqli_close($konexioa);
?>
</body>
</html>
