<?php

$ejercicios = array (
    array ('id'=>1, 'titulo'=>'Test Autoescuela', 'descripcion'=>'Desarrollo de un sistema de test online para una autoescuela.', 'enlace'=>'ej1/ej1.php', 'github'=>'https://github.com/viorbe20/DWES_ud4_act1/blob/main/ej1/ej1.php'),
    array ('id'=>2, 'titulo'=>'Puzzle', 'descripcion'=>'Se debe crear una aplicación que permita resolver puzles infantiles de tres piezas.', 'enlace'=>'ej2/ej2.php', 'github'=>'https://github.com/viorbe20/DWES_ud4_act1/blob/main/ej2/ej2.php'),
)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virginia Ordoño Bernier</title>
</head>
<body>
<h1>Actividades de Repaso (DWES)</h1>
    <h3>Ejercicios Unidad 4</h3>
    <a href="../index.php">Volver al índice de ejercicios</a><br><br>
    <?php 
    foreach ($ejercicios as $key => $value) {
        echo '<a target="_blank" href="' . $value['enlace'] . '">' . $value['id'] . '.' . $value['titulo'] .'</a>' . '<br>' . $value['descripcion'] . '<br>';
        echo '<a target="_blank" href="' . $value['github'] . '">Enlace Github</a><br><br>';
    }
        ?>
</body>
</html>