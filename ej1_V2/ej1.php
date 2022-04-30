<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";

$aTestSolution;
$processForm = true;
/**
 * Dado un número de test, devuelve las respuestas de ese test
 */
function getTestSolution($testNUmber, $aTests)
{
    for ($i = 0; $i < count($aTests); $i++) {
        foreach ($aTests[$testNUmber] as $level1 => $value) {
            if ($level1 == "Corrector") {
                return $value;
            }
        }
    }

    //return $aTestSolution;
}

$aTestSolution = getTestSolution(0, $aTests);

//Muestra página inicial. Muestra tantos tests como tenga el array
if ($processForm) {
    $css = file_get_contents("css/mainPage.css");
    echo "<style>$css</style>";
?>
    <main>
        <div id=container>
            <h1>Test online Autoescuela</h1>
            <h3>Selecciona el test por el que quieras comenzar.</h3>
            <form action="" method="post">
                <select name="selectedTest" id="select">
                    <?php
                    for ($i = 0; $i < count($aTests); $i++) {
                        echo "<option value=\"$i\">Test " . $i + 1 . " </option>";
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit" name="start" id="startBtn">Comenzar</button>
            </form>
        </div>

    </main>
<?php
}
?>