<?php

/**
 * Puzzles infantiles. 
 * Se debe crear una aplicación que permita resolver puzles infantiles de tres piezas. Se adjunta fichas de
 * ejemplo, pero es necesario que personalices las fichas del rompecabezas.
 * Aplica criterios de usabilidad en el diseño de la aplicación intentando conseguir la mejor experiencia de
 * usuario.
 * @source images from https://pixabay.com/es/users/ptra-359668/
 */


define("PICTURES_NUMBER", 6);


$css = file_get_contents("css/style.css");
$correctPuzzles = "";
$x = "";
$y = "";


session_start();

if (!isset($_SESSION['game'])) {

    //Array con id de imágenes
    for ($i = 0; $i < PICTURES_NUMBER; $i++) {

        for ($j = 0; $j < 3; $j++) {
            $_SESSION['game'][$i][$j] = $i . $j;
        }
    }
}

?>
<style>
    <?php
    echo $css;
    ?>
</style>

<body>
    <h1>Puzzle infantil</h1>
    <main>
        <form action="" method="get">

            <div id="container">

                <div class="part">
                    <?php
                    $x = rand(0, 5);
                    echo "<img class=\"dos\" src=\"img/" . $x . "0.png\">";
                    ?>


                </div>

                <div class="part">
                <?php
                $x = rand(0, 5);
                    echo "<img class=\"dos\" src=\"img/" . $x . "1.png\">";
                    ?>
                </div>

                <div class="part">
                <?php
                $x = rand(0, 5);
                    echo "<img class=\"dos\" src=\"img/" . $x . "2.png\">";
                    ?>
                </div>

            </div>

            <div id="container2">
                <label>echo <?php $correctPuzzles ?></label>
                <div id="buttons">
                    <a href="destroySession.php"><button type="submit" name="restart">Reiniciar</button></a>
                    <button type="submit" name="check">Comprobar</button>
                </div>

            </div>

        </form>
    </main>

</body>