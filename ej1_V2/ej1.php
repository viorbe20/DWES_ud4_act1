<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";

$aTestSolution;
$processForm = true;
$showSolution = false;

//Cuenta número de cookies
$cookiesAmount = array_count_values($_COOKIE);
$aTestSolution = getTestSolution(0, $aTests);

/**
 * Dado un número de test, devuelve las respuestas de ese test
 */
function getTestSolution($selectedTest, $aTests)
{
    for ($i = 0; $i < count($aTests); $i++) {
        foreach ($aTests[$selectedTest] as $level1 => $value) {
            if ($level1 == "Corrector") {
                return $value;
            }
        }
    }
}

/**
 * Muestra el test seleccionado
 */
function showSelectedTest($selectedTest, $aTests, $showSolution)
{

    for ($i = 0; $i < count($aTests); $i++) {
        foreach ($aTests[$selectedTest] as $level1 => $value) {
            if ($level1 == "Preguntas") {
                foreach ($value as $key) {
                    $css = file_get_contents("css/style.css");
                    echo "<style>$css</style>";
                    //var_dump($key);
                    echo "<div class='question'>";
                    echo "<h3>Pregunta " . $key['Pregunta'] . "</h3>";

                    //Comprueba si la foto existe
                    if (file_exists("dir_img_test" . $selectedTest + 1 . "/img" . $key['idPregunta'] . ".jpg")) {
                        echo "<img src=dir_img_test" . $selectedTest + 1 . "/img" . $key['idPregunta'] . ".jpg>";
                    }

                    echo "<p class='answer'>Respuestas</p>";

                    //Imprime el número de  respuestas que tenga el test
                    for ($i = 0; $i < count($key['respuestas']); $i++) {

                        //Muestra aciertos
                        if ($showSolution) {
                            // if (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "right")) {
                            //     $className = "right";
                            // } elseif (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "wrong")) {
                            //     $className = "wrong";
                            //     $errors++;
                            // } else {
                            //     $className = "nsnc";
                            //     $errors++;
                            // }

                            //Desabilita radiobutton cuando muestra resultados
                            $disabled = "disabled";
                        } else {
                            $className = "";
                            $disabled = "";
                        }

                        echo "<label class=\"$className\">" . $key['respuestas'][$i] . "</label>";
                        $name = ($key['idPregunta'] - 1);
                        echo "<input type=\"radio\" name=" . $name . " value=\"$i\" $disabled/>";
                        echo ('<br>');
                    }
                }
            }
        }
    }
}

//Tras el botón comenzar
if (isset($_POST["start"])) {
    $processForm = false;
    $selectedTest = $_POST['selectedTest'];

    //Creamos cookie con el número de test seleccionado
    setcookie('currentTest', $selectedTest, time() + 36000);

    showSelectedTest($selectedTest, $aTests, false);
}

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