<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
$s = false;
$processForm = false;
$showTest1 = false;
$showTest2 = false;
$showTest3 = false;
$correctAnswer;
$options = ["a", "b", "c"];
// $checked = array();
$correctOptionMsg = "";

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

/**
 * Crea o actualiza cookie
 */
function setNewCookie($selectedTest)
{
    //Establecemos cookie
    if (!isset($_COOKIE['currentTest'])) {
        setcookie('currentTest', $selectedTest, time() + 3000);
    } else {
        setcookie('currentTest', "", time() - 36000);
    }
};

/**
 * Comprueba cookie para navegación
 */

function checkCookie($cookie)
{
    switch ($cookie) {
        case '1':
            setcookie('currentTest', "2", time() + 36000);
            break;
        case '2':
            setcookie('currentTest', "3", time() + 36000);
            break;
        case '3':
            setcookie('currentTest', "1", time() + 36000);
            break;
    }
}

//Cargamos arrays con las respuestas de cada test
$answersTest1 = getAnswers($aTests, 0);
$answersTest2 = getAnswers($aTests, 1);
$answersTest3 = getAnswers($aTests, 2);

//Si no hay cookie, la creamos y mostramos primera pantalla
if (!isset($_COOKIE['currentTest'])) {
    setcookie('currentTest', "", time() + 36000);
    $processForm = true;
} else {
    if ($_COOKIE['currentTest'] == 1) {
        $showTest1 = false;
        $showTest2 = true;
        $showTest3 = false;
    }
    
    if ($_COOKIE['currentTest'] == 2) {
        $showTest1 = false;
        $showTest2 = false;
        $showTest3 = true;
    }
    
    if ($_COOKIE['currentTest'] == 3) {
        $showTest1 = true;
        $showTest2 = false;
        $showTest3 = false;
    }
}

//Selección tipo test
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

//Pasa de un test a otro
if (isset($_POST["continue"])) {
    checkCookie($_COOKIE['currentTest']);
}

//Reinicia un test
if (isset($_POST["repeatTest"])) {
    setcookie('currentTest', $_COOKIE['currentTest'], time() + 36000);
}



if ($showTest1) {
    echo
    "<form method=\"post\">
    <div id=\"resultMsg\">
    <div id=\"buttons\">
    <button type=\"submit\" name=\"continue\" id=\"continueBtn\">Continuar</button>
    <button type=\"submit\" name=\"repeatTest\" id=\"repeatTest1Btn\">Repetir test</button>
    </div>
    </div></form>";
    //checkCookie($_COOKIE['currentTest']);
}

if ($showTest2) {
    echo
    "<form method=\"post\"><h1>Test 2</h1><div id=\"resultMsg\">
    <div id=\"buttons\">
    <button type=\"submit\" name=\"continue\" id=\"continueBtn\">Continuar</button>
    <button type=\"submit\" name=\"repeatTest1\" id=\"repeatTest1Btn\">Repetir test</button>
    </div>
    </div></form>";
    //checkCookie($_COOKIE['currentTest']);
}

if ($showTest3) {
    echo
    "<form method=\"post\"><h1>Test 3</h1><div id=\"resultMsg\">
    <div id=\"buttons\">
    <button type=\"submit\" name=\"continue\" id=\"continueBtn\">Continuar</button>
    <button type=\"submit\" name=\"repeatTest1\" id=\"repeatTest1Btn\">Repetir test</button>
    </div>
    </div></form>";
    //checkCookie($_COOKIE['currentTest']);
}



if ($processForm) {
?>
    <style>
        body {
            background-color: #F3F4F5;
        }

        main {
            display: flex;
            justify-content: center;
        }

        #container {
            margin-top: 60px;
            padding: 10px;
            text-align: center;

            width: 40%;

        }

        h1 {
            color: #2164A5;
            *background-color: pink;
            padding: 10px;
            text-align: center;
            font-size: 40px;
        }

        select {
            font-size: 15px;
            padding: 5px;
        }

        #startBtn {
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 10px;
            cursor: pointer;
            background-color: #2164A5;
            color: white;
            font-size: 15px;
            border-radius: .28571429rem;
        }
    </style>
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

//Muestra test1
if ($showTest1) {
?>
    <style>
        main {
            padding: 10px;
        }

        h1 {
            *color: blue;
            padding: 10px;
            text-align: center;
        }

        .question {
            background-color: #EBEFF0;
        }

        h3 {
            background-color: #2164A5;
            padding: 10px;
            color: white;
        }

        .answer {
            font-weight: bold;
        }

        .right {
            background-color: green;
            color: white;
        }

        .wrong {
            background-color: red;
            color: white;
        }

        .nsnc {
            color: black;
        }

        #resultMsg {
            position: fixed;
            top: 10px;
            right: 2%;
            background-color: #cdcdcd;
            border-radius: .28571429rem;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        #resultMsg>p {
            color: #008f39;
            font-size: 30px;
            margin-left: 8px;
            margin-right: 8px;
        }

        #continueBtn,
        #repeatTest1Btn {
            margin-top: 10px;
            margin-bottom: 10px;
            width: 40%;
            padding: 10px;
            cursor: pointer;
            background-color: #008f39;
            color: white;
            font-size: 15px;
            border-radius: .28571429rem;
        }

        #buttons {
            display: flex;
            justify-content: space-evenly;
        }
    </style>
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
                <button type=\"submit\" name=\"repeatTest1\" id=\"repeatTest1Btn\">Repetir test</button>
                </div>
                </div>";
            }
            ?>
            <button type="submit" name="submitTest1">Enviar</button>
        </form>
    </main>
<?php
}



//if ($showTest2) {
if ($s) {
?><form action="" method="post">
        <h1>Test 2: Permiso B</h1>
        <button type="submit" name="continue" id="continueBtn">Continuar</button>
    </form>
<?php

}

//if ($showTest3) {
if ($s) {
?>
    <h1>Test 3: Permiso B</h1>

<?php

}
?>