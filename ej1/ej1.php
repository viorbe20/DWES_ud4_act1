<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
$processForm = false;
$showTest1 = false;
$showTest2 = false;
$showTest3 = false;
$showResultTest1 = false;
$showResultTest2 = false;
$showResultTest3 = false;
$options = ["a", "b", "c"];
$correctOptionMsg = "";
$continueTest = false;

if (isset($_POST["restart"])) {
    setcookie('currentTest', "", time() - 1000);
    setcookie('test1', "", time() - 1000);
    setcookie('test2', "", time() - 1000);
    setcookie('test3', "", time() - 1000);
    $processForm = true;
}

if ((isset($_COOKIE["test1"])) and (isset($_COOKIE["test2"])) and (isset($_COOKIE["test3"]))) {

    $css = file_get_contents("css/lastPage.css");
    echo "<style>$css</style>
    <form method=\"post\">
    <h1>Has realizado todos los tests</h1>
    <button type=\"submit\" name=\"restart\" id=\"restartBtn\">Comenzar</button>
    </form>";
} else {
    /**
     * Devuelve un array de respuestas.
     * Recibe como parámetro el número del test del que quiero las respuestas
     */
    function getAnswers($aTests, $testNumber)
    {

        $answers = array();

        foreach ($aTests as $key => $value) {

            if ($key == $testNumber) {

                foreach ($value as $level1 => $value) {

                    if ($level1 == "Corrector") {
                        $answers = $value;
                        return $answers;
                    }
                }
            }
        }
    };

    //Cargamos arrays con las respuestas de cada test
    $answersTest1 = getAnswers($aTests, 0);
    $answersTest2 = getAnswers($aTests, 1);
    $answersTest3 = getAnswers($aTests, 2);

    //Pasa de un test a otro
    if (isset($_POST["continue"])) {
        $continueTest = true;
        switch ($_COOKIE['currentTest']) {
            case '1':
                setcookie('currentTest', "2", time() + 36000);
                $showTest2 = true;
                if (!isset($_COOKIE['test1'])) {
                    setcookie('test1', "1", time() + 36000);
                }
                break;
            case '2':
                setcookie('currentTest', "3", time() + 36000);
                $showTest3 = true;
                if (!isset($_COOKIE['test2'])) {
                    setcookie('test2', "2", time() + 36000);
                }
                break;
            case '3':
                setcookie('currentTest', "1", time() + 36000);
                $showTest1 = true;
                if (!isset($_COOKIE['test3'])) {
                    setcookie('test3', "3", time() + 36000);
                }
                break;
        }
    }

    //Reinicia un test
    if (isset($_POST["repeatTest"])) {
        setcookie('currentTest', $_COOKIE['currentTest'], time() + 36000);
    }

    //Primera carga página. Si no hay cookie, la creamos y mostramos primera pantalla
    if (!isset($_COOKIE['currentTest'])) {
        setcookie('currentTest', "", time() + 36000);
        $processForm = true;
    } else {
        if ((!$continueTest)) {
            switch ($_COOKIE['currentTest']) {
                case '1':
                    $showTest1 = true;
                    break;
                case '2':
                    $showTest2 = true;
                    break;
                case '3':
                    $showTest3 = true;
                    break;
            }
        }
    }

    //Selección tipo test página inicio
    if (isset($_POST['start'])) {
        $selectedTest = $_POST['selectedTest'];
        //setNewCookie($selectedTest);
        $processForm = false;

        switch ($selectedTest) {
            case '1':
                $showTest1 = true;
                //$_COOKIE['currentTest'] = 1;
                setcookie('currentTest', "1", time() + 36000);
                break;
            case '2':
                $showTest2 = true;
                //$_COOKIE['currentTest'] = 2;
                setcookie('currentTest', "2", time() + 36000);
                break;
            case '3':
                $showTest3 = true;
                //$_COOKIE['currentTest'] = 3;
                setcookie('currentTest', "3", time() + 36000);
                break;
        }
    }

    //Muestra respuestas test 1
    if (isset($_POST["submitTest1"])) {
        $showTest1 = true;
        $showResultTest1 = true;
        $a_userAnswers = array();
        $errors = 0;

        //Guardamos las respuestas seleccionadas
        //var_dump($_POST); => Imprime número de pregunta e índice (0,1,2) según respuesta
        foreach ($aTests as $key => $value) {

            if ($key == 0) {

                foreach ($value as $level1 => $value) {

                    if ($level1 == "Preguntas") {

                        //Recorre como tantas preguntas tenga el test
                        for ($i = 0; $i < count($value); $i++) {

                            //Comprobamos si está respondida o no
                            if (isset($_POST[$i])) {
                                //Si ha respondido la pasamos a letra
                                if ($answersTest2[$i] == $options[$_POST[$i]]) {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "right"));
                                } else {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "wrong"));
                                }
                            } else {
                                array_push($a_userAnswers, array("option" => array_search($answersTest2[$i], $options), "status" => "right"));
                            }
                        }
                    }
                }
            }
        }

        //var_dump($checked);
    }

    //Muestra respuestas test 2
    if (isset($_POST["submitTest2"])) {
        $showTest2 = true;
        $showResultTest2 = true;
        $a_userAnswers = array();
        $errors = 0;

        //Guardamos las respuestas seleccionadas
        //var_dump($_POST); => Imprime número de pregunta e índice (0,1,2) según respuesta
        foreach ($aTests as $key => $value) {

            if ($key == 1) {

                foreach ($value as $level1 => $value) {

                    if ($level1 == "Preguntas") {

                        //Recorre como tantas preguntas tenga el test
                        for ($i = 0; $i < count($value); $i++) {

                            //Comprobamos si está respondida o no
                            if (isset($_POST[$i])) {
                                //Si ha respondido la pasamos a letra
                                if ($answersTest2[$i] == $options[$_POST[$i]]) {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "right"));
                                } else {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "wrong"));
                                }
                            } else {
                                array_push($a_userAnswers, array("option" => array_search($answersTest2[$i], $options), "status" => "right"));
                            }
                        }
                    }
                }
            }
        }

        //var_dump($checked);
    }

    //Muestra respuestas test 3
    if (isset($_POST["submitTest3"])) {
        $showTest3 = true;
        $showResultTest3 = true;
        $a_userAnswers = array();
        $errors = 0;

        //Guardamos las respuestas seleccionadas
        //var_dump($_POST); => Imprime número de pregunta e índice (0,1,2) según respuesta
        foreach ($aTests as $key => $value) {

            if ($key == 2) {

                foreach ($value as $level1 => $value) {

                    if ($level1 == "Preguntas") {

                        //Recorre como tantas preguntas tenga el test
                        for ($i = 0; $i < count($value); $i++) {

                            //Comprobamos si está respondida o no
                            if (isset($_POST[$i])) {
                                //Si ha respondido la pasamos a letra
                                if ($answersTest3[$i] == $options[$_POST[$i]]) {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "right"));
                                } else {
                                    array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "wrong"));
                                }
                            } else {
                                array_push($a_userAnswers, array("option" => array_search($answersTest3[$i], $options), "status" => "right"));
                            }
                        }
                    }
                }
            }
        }

        //var_dump($a_userAnswers);
    }

    //Página de inicio
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
                        <option value="1">Test 1</option>
                        <option value="2">Test 2</option>
                        <option value="3">Test 3</option>
                    </select>
                    <br>
                    <br>
                    <button type="submit" name="start" id="startBtn">Comenzar</button>
                </form>
            </div>

        </main>

    <?php
    }
    function getCss()
    {
        $css = file_get_contents("css/style.css");
        $content =  <<<EOD
    <style>$css</style>
    EOD;
        return $content;
    }

    //Muestra test1
    if ($showTest1) {
        echo getCss();
    ?>
        <main>
            <form action="" method="post">
                <button type="submit" name="submitTest1">Enviar</button>

                <h1>Test 1: Permiso B</h1>
                <?php
                foreach ($aTests as $key => $value) {
                    if ($key == 0) {
                        foreach ($value as $level1 => $value) {
                            if ($level1 == "Preguntas") {
                                //var_dump($value);
                                foreach ($value as $level2 => $value2) {

                                    //echo('<br>'. $level2);// 0 a 9
                                    echo "<div class='question'>";
                                    echo "<h3>Pregunta " . $value2['Pregunta'] . "</h3>";

                                    //Comprueba si la foto existe
                                    if (file_exists("dir_img_test1/img" . $value2['idPregunta'] . ".jpg")) {
                                        echo "<img src=dir_img_test1/img" . $value2['idPregunta'] . ".jpg>";
                                    }

                                    echo "<p class='answer'>Respuestas</p>";

                                    //Imprime posibles respuestas, en este caso es un bucle de 3
                                    for ($i = 0; $i < count($value2['respuestas']); $i++) {

                                        //Muestra aciertos
                                        if ($showResultTest1) {
                                            //var_dump($a_userAnswers[$level2]['option']);
                                            if (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "right")) {
                                                $className = "right";
                                            } elseif (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "wrong")) {
                                                $className = "wrong";
                                                $errors++;
                                            } else {
                                                $className = "nsnc";
                                                $errors++;
                                            }

                                            //Desabilita radiobutton cuando muestra resultados
                                            $disabled = "disabled";
                                        } else {
                                            $className = "";
                                            $disabled = "";
                                        }

                                        echo "<label class=\"$className\">" . $value2['respuestas'][$i] . "</label>";
                                        $name = ($value2['idPregunta'] - 1);
                                        echo "<input type=\"radio\" name=" . $name . " value=\"$i\" $disabled/>";
                                        echo ('<br>');
                                    }

                                    echo '<br>';
                                    if ($showResultTest1) {
                                        $correctOptionMsg = $answersTest1[$level2];
                                        echo "<span> Respuesta correcta: " . $correctOptionMsg . "</span>";
                                    }

                                    echo ("</div>");
                                }
                            }
                        }
                    }
                }

                if ($showResultTest1) {
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
                ?>
                <button type="submit" name="submitTest1">Enviar</button>
            </form>
        </main>
    <?php
    }

    //Muestra test2
    if ($showTest2) {
        echo getCss();
    ?>
        <main>
            <form action="" method="post">
                <button type="submit" name="submitTest2">Enviar</button>

                <h1>Test 2: Permiso B</h1>
                <?php
                foreach ($aTests as $key => $value) {
                    if ($key == 1) {
                        foreach ($value as $level1 => $value) {
                            if ($level1 == "Preguntas") {
                                //var_dump($value);
                                foreach ($value as $level2 => $value2) {

                                    //echo('<br>'. $level2);// 0 a 9
                                    echo "<div class='question'>";
                                    echo "<h3>Pregunta " . $value2['Pregunta'] . "</h3>";

                                    //Comprueba si la foto existe
                                    if (file_exists("dir_img_test2/img" . $value2['idPregunta'] . ".jpg")) {
                                        echo "<img src=dir_img_test2/img" . $value2['idPregunta'] . ".jpg>";
                                    }

                                    echo "<p class='answer'>Respuestas</p>";

                                    //Imprime posibles respuestas, en este caso es un bucle de 3
                                    for ($i = 0; $i < count($value2['respuestas']); $i++) {

                                        //Muestra aciertos
                                        if ($showResultTest2) {
                                            //var_dump($a_userAnswers[$level2]['option']);
                                            if (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "right")) {
                                                $className = "right";
                                            } elseif (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "wrong")) {
                                                $className = "wrong";
                                                $errors++;
                                            } else {
                                                $className = "nsnc";
                                                $errors++;
                                            }

                                            //Desabilita radiobutton cuando muestra resultados
                                            $disabled = "disabled";
                                        } else {
                                            $className = "";
                                            $disabled = "";
                                        }

                                        echo "<label class=\"$className\">" . $value2['respuestas'][$i] . "</label>";
                                        $name = ($value2['idPregunta'] - 1);
                                        echo "<input type=\"radio\" name=" . $name . " value=\"$i\" $disabled/>";
                                        echo ('<br>');
                                    }

                                    echo '<br>';
                                    if ($showResultTest2) {
                                        $correctOptionMsg = $answersTest2[$level2];
                                        echo "<span> Respuesta correcta: " . $correctOptionMsg . "</span>";
                                    }

                                    echo ("</div>");
                                }
                            }
                        }
                    }
                }

                if ($showResultTest2) {
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
                ?>
                <button type="submit" name="submitTest2">Enviar</button>
            </form>
        </main>
    <?php
    }

    //Muestra test3
    if ($showTest3) {
        echo getCss();
    ?>
        <main>
            <form action="" method="post">
                <button type="submit" name="submitTest3">Enviar</button>

                <h1>Test 3: Permiso B</h1>
                <?php
                foreach ($aTests as $key => $value) {
                    if ($key == 2) {
                        foreach ($value as $level1 => $value) {
                            if ($level1 == "Preguntas") {
                                //var_dump($value);
                                foreach ($value as $level2 => $value2) {

                                    //echo('<br>'. $level2);// 0 a 9
                                    echo "<div class='question'>";
                                    echo "<h3>Pregunta " . $value2['Pregunta'] . "</h3>";

                                    //Comprueba si la foto existe
                                    if (file_exists("dir_img_test3/img" . $value2['idPregunta'] . ".jpg")) {
                                        echo "<img src=dir_img_test3/img" . $value2['idPregunta'] . ".jpg>";
                                    }

                                    echo "<p class='answer'>Respuestas</p>";

                                    //Imprime posibles respuestas, en este caso es un bucle de 3
                                    for ($i = 0; $i < count($value2['respuestas']); $i++) {

                                        //Muestra aciertos
                                        if ($showResultTest3) {
                                            //var_dump($a_userAnswers[$level2]['option']);
                                            if (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "right")) {
                                                $className = "right";
                                            } elseif (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "wrong")) {
                                                $className = "wrong";
                                                $errors++;
                                            } else {
                                                $className = "nsnc";
                                                $errors++;
                                            }

                                            //Desabilita radiobutton cuando muestra resultados
                                            $disabled = "disabled";
                                        } else {
                                            $className = "";
                                            $disabled = "";
                                        }

                                        echo "<label class=\"$className\">" . $value2['respuestas'][$i] . "</label>";
                                        $name = ($value2['idPregunta'] - 1);
                                        echo "<input type=\"radio\" name=" . $name . " value=\"$i\" $disabled/>";
                                        echo ('<br>');
                                    }

                                    echo '<br>';
                                    if ($showResultTest3) {
                                        $correctOptionMsg = $answersTest3[$level2];
                                        echo "<span> Respuesta correcta: " . $correctOptionMsg . "</span>";
                                    }

                                    echo ("</div>");
                                }
                            }
                        }
                    }
                }

                if ($showResultTest3) {
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
                ?>
                <button type="submit" name="submitTest3">Enviar</button>
            </form>
        </main>
<?php
    }
}
?>