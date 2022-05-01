<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";

$processForm = false;
$showTest1 = false;
$showSolution = false;
$showFinalPage = false;

//Cuenta número de cookies
//$cookiesAmount = array_count_values($_COOKIE);
//$aTestSolution = getTestSolution(0, $aTests);

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
function showSelectedTest($selectedTest, $aTests, $showSolution, $aUserAnswers)
{
    //Creamos cookie de nuevo test
    if (!isset($_COOKIE["test" . ($selectedTest + 1)])) {
        setcookie("test" . (($selectedTest + 1)), "test" . (($selectedTest + 1)), time() + 36000);
    }

    $errors = 0;
    $options = ["a", "b", "c"];
    $css = file_get_contents("css/style.css");
    echo "<style>$css</style>
    <main>
    <form method=\"post\">
        <button type=\"submit\" name=\"submitTest\">Enviar</button>
        <h1>Test " . $selectedTest + 1 . ": Permiso B</h1>";

    foreach ($aTests as $key => $value) {

        if ($key == $selectedTest) {

            foreach ($value as $level1 => $value) {

                if ($level1 == "Preguntas") {
                    //var_dump($value);
                    foreach ($value as $level2 => $value2) {

                        //echo ('<br>' . $level2); // 0 a 9
                        echo "<div class='question'>";
                        echo "<h3>Pregunta " . $value2['Pregunta'] . "</h3>";

                        //Comprueba si la foto existe
                        if (file_exists("dir_img_test" . $selectedTest + 1 . "/img" . $value2['idPregunta'] . ".jpg")) {
                            echo "<img src=dir_img_test" . $selectedTest + 1 . "/img" . $value2['idPregunta'] . ".jpg>";
                        }

                        echo "<p class='answer'>Respuestas</p>";

                        //Imprime posibles respuestas, en este caso es un bucle de 3
                        for ($i = 0; $i < count($value2['respuestas']); $i++) {
                            //echo ('<br>' . $i);
                            //Muestra aciertos
                            if ($showSolution) {
                                $aTestSolution = getTestSolution($selectedTest, $aTests);
                                //var_dump($aUserAnswers[$level2]['option'] );
                                if (($aUserAnswers[$level2]['option'] == $i) && ($aUserAnswers[$level2]['status'] == "right")) {
                                    $className = "right";
                                } elseif (($aUserAnswers[$level2]['option'] == $i) && ($aUserAnswers[$level2]['status'] == "wrong")) {
                                    $className = "wrong";
                                    $errors++;
                                } else {
                                    if ($aTestSolution[$level2] == $options[$i]) {
                                        $className = "right";
                                    } else {
                                        $className = "nsnc";
                                        $errors++;
                                    }
                                }

                                //Desabilita radiobutton cuando muestra resultados
                                $disabled = "disabled";
                            } else {
                                $className = "";
                                $disabled = "";
                            }

                            echo "<label class=\"$className\">" . $value2['respuestas'][$i] . "</label>";
                            echo "<input type=\"radio\" name=" . ($value2["idPregunta"] - 1) .  " value=\"$i\" $disabled/>";
                            echo ('<br>');
                        }

                        echo '<br>';
                        if ($showSolution) {
                            $aTestSolution = getTestSolution($selectedTest, $aTests);
                            $correctOptionMsg = $aTestSolution[$level2];
                            echo "<span> Respuesta correcta: " . $correctOptionMsg . "</span>";
                        }

                        echo ("</div>");
                    }
                }
            }
        }
    }

    if ($showSolution) {
        //Mensaje superación
        if ($errors > 2) {
            $resultMsg = "No has superado el test";
        } else {
            $resultMsg = "Has superado el test";
        }
        //Muestra mensaje con resultado
        echo
        "<div id=\"resultMsg\">
    <p>" . $resultMsg . "</p>
    <div id=\"buttons\">
    <button type=\"submit\" name=\"continue\" id=\"continueBtn\">Continuar</button>
    <button type=\"submit\" name=\"repeatTest\" id=\"repeatTestBtn\">Repetir test</button>
    </div>
    </div>";
    }
    echo "</form></main>";
}

//Empieza el test donde se quedó
if (!isset($_COOKIE["currentTest"])) {
    $processForm = true;
} else {
    $processForm = false;

    //Borra las cookies si se comienza de nuevo
    if (isset($_POST["restart"])) {
        setcookie('currentTest', "", time() - 1000);
        setcookie('test1', "", time() - 1000);
        setcookie('test2', "", time() - 1000);
        setcookie('test3', "", time() - 1000);
        $processForm = true;
    }

    //Carga el test en el que se quedara
    if (!isset($_POST["continue"])) {
        showSelectedTest(($_COOKIE["currentTest"]), $aTests, false, "");
    }
    //Muestra test con respuestas corregidas
    if (isset($_POST["submitTest"])) {
        $processForm = false;
        $selectedTest = $_COOKIE['currentTest'];
        $aUserAnswers = array();
        $showSolution = true;
        $aTestSolution = getTestSolution($selectedTest, $aTests);
        $options = ["a", "b", "c"];

        //Obtenemos las respuestas marcadas por el usuario
        foreach ($aTests as $key => $value) {

            if ($key == $selectedTest) {

                foreach ($value as $level1 => $value) {

                    if ($level1 == "Preguntas") {

                        //Recorre tantas veces como preguntas tenga el test
                        for ($i = 0; $i < count($value); $i++) {

                            //Comprobamos si está respondida o no
                            if (isset($_POST[$i])) {
                                //Si ha respondido la pasamos a letra
                                if ($aTestSolution[$i] == $options[$_POST[$i]]) {
                                    array_push($aUserAnswers, array("option" => $_POST[$i], "status" => "right"));
                                } else {
                                    array_push($aUserAnswers, array("option" => $_POST[$i], "status" => "wrong"));
                                }
                            } else {
                                array_push($aUserAnswers, array("option" => array_search($aTestSolution[$i], $options), "status" => "right"));
                            }
                        }
                        var_dump($aUserAnswers);
                    }
                }
            }
        }

        showSelectedTest($selectedTest, $aTests, $showSolution, $aUserAnswers);
    }

    //Repite test
    if (isset($_POST['repeatTest'])) {
        $processForm = false;
        showSelectedTest($_COOKIE['currentTest'], $aTests, false, "");
    }

    //Pasa al test siguiente
    if (isset($_POST["continue"])) {

        //Comprueba si se han realizado todos los tests según número de cookies creadas
        if (count(array_count_values($_COOKIE)) == (count($aTests) + 1)) {
            $processForm = false;
            $showFinalPage = true;
        } else {

            //Actualizamos cookie con el número de test actual (empieza por 0)
            if ($_COOKIE["currentTest"] == (count($aTests) - 1)) {
                setcookie('currentTest', 0, time() + 36000);
            } else {
                setcookie('currentTest', ($_COOKIE["currentTest"] + 1), time() + 36000);
            }

            showSelectedTest(($_COOKIE["currentTest"] + 1), $aTests, false, "");
        }
    }
}

//Tras el botón comenzar
if (isset($_POST["start"])) {
    $processForm = false;
    $selectedTest = $_POST['selectedTest'];
    $aUserAnswers = array();
    $showSolution = false;

    //Creamos cookie con el número de test seleccionado
    setcookie('currentTest', $selectedTest, time() + 36000);

    showSelectedTest($selectedTest, $aTests, $showSolution, $aUserAnswers);
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

//Muestra página final
if ($showFinalPage) {

    $css = file_get_contents("css/lastPage.css");
?>

    <style>
        <?php echo $css ?>
    </style>
    <form method="post">
        <h1>Has realizado todos los tests</h1>
        <button type="submit" name="restart" id="restartBtn">Comenzar</button>
    </form>
<?php

}
?>