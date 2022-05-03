<?php

/**
 * Puzzles infantiles. 
 * Se debe crear una aplicación que permita resolver puzles infantiles de tres piezas. Se adjunta fichas de
 * ejemplo, pero es necesario que personalices las fichas del rompecabezas.
 * Aplica criterios de usabilidad en el diseño de la aplicación intentando conseguir la mejor experiencia de
 * usuario.
 * @source images from https://pixabay.com/es/users/ptra-359668/
 * @author Virginia Ordoño Bernier
 * @since April 2022
 */

define("PICTURES_NUMBER", 6);
$css = file_get_contents("css/style.css");
$donePuzzles = "";
$x = "";
$y = "";
$aUserParts = array();

session_start();

if (!isset($_SESSION['game'])) {

    //Array con id de imágenes
    for ($i = 0; $i < PICTURES_NUMBER; $i++) {

        for ($j = 0; $j < 3; $j++) {
            $_SESSION['game'][$i][$j] = $i . $j;
        }
    }

    //Mostramos imagend e manera aleatoria
    $_SESSION['part1'] = rand(0, 5) . 0;
    $_SESSION['part2'] = rand(0, 5) . 1;
    $_SESSION['part3'] = rand(0, 5) . 2;
    $_SESSION['done'] = 0;
}

//Clic en la imagen, muestra otra parte
if (isset($_GET["part1"])) {
    $_SESSION['part1'] = rand(0, 5) . 0;
}

if (isset($_GET["part2"])) {
    $_SESSION['part2'] = rand(0, 5) . 1;
}

if (isset($_GET["part3"])) {
    $_SESSION['part3'] = rand(0, 5) . 2;
}

//Comprueba acierto
if (isset($_GET["check"])) {
    array_push($aUserParts, $_SESSION['part1'], $_SESSION['part2'], $_SESSION['part3']);

    for ($i = 0; $i < PICTURES_NUMBER; $i++) {
        $aRightParts = array();
        for ($j = 0; $j < 3; $j++) {
            array_push($aRightParts, $_SESSION['game'][$i][$j]);
            if ($aRightParts == $aUserParts) {
                $_SESSION['game'][$i][$j] = "done";
                $_SESSION['done'] = $_SESSION['done'] + 1;
            }

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
                    echo "<a href=ej2.php?part1=$x>";
                    echo "<img class=\"dos\" src=\"img/" . $_SESSION["part1"] . ".png\">";
                    ?>
                    </a>
                </div>


                <div class="part">
                    <?php
                    echo "<a href=ej2.php?part2=$x>";
                    echo "<img class=\"dos\" src=\"img/" . $_SESSION["part2"] . ".png\">";
                    ?>
                    </a>
                </div>

                <div class="part">
                    <?php
                    echo "<a href=ej2.php?part3=$x>";
                    echo "<img class=\"dos\" src=\"img/" . $_SESSION["part3"] . ".png\">";
                    ?>
                    </a>
                </div>

            </div>

            <div id="container2">
                <label>Has completado <?php echo $_SESSION['done']?> de <?php echo count($_SESSION['game'])?></label>
                <div id="buttons">
                    <button type="submit" name="restart"><a href="destroySession.php">Reiniciar</a></button>
                    <button type="submit" name="check">Comprobar</button>
                </div>

            </div>

        </form>
    </main>

</body>