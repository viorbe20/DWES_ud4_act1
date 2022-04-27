<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";

$processForm = true;
$showTest1 = false;
$showResultTest1 = false;
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

//Cargamos arrays con las respuestas de cada test
$answersTest1 = getAnswers($aTests, 0);
$answersTest2 = getAnswers($aTests, 1);
$answersTest3 = getAnswers($aTests, 2);

//Selección tipo test
if (isset($_POST['start'])) {
    $selectedTest = $_POST['selectedTest'];
    $processForm = false;

    switch ($selectedTest) {
        case '1':
            $showTest1 = true;
            break;
        case '1':
            $showTest2 = true;
            break;
        case '1':
            $showTest3 = true;
            break;
    }
}

if (isset($_POST['submitTest1'])) {
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

                        //"Corrector"=>array("a","b","c", "c", "c", "a", "c", "a", "c", "a"),
                        //Comprobamos si está respondida o no
                        if (isset($_POST[$i])) {
                            //Si ha respondido la pasamos a letra
                            if ($answersTest1[$i] == $options[$_POST[$i]]) {
                                array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "right"));
                            } else {
                                array_push($a_userAnswers, array("option" => $_POST[$i], "status" => "wrong"));
                            }
                        } else {
                            array_push($a_userAnswers, array("option" => "nsnc", "status" => "nsnc"));
                        }
                    }
                }
            }
        }
    }

    //var_dump($checked);
}


if ($processForm) {
?>
    <style>
        body {
            background-color: #F3F4F5;
        }

        main{
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
            color:white;
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
            font-size: 30px;
            color: white;
            text-align: center;
            padding: 5px;
            top: 20px;
            right: 2%;
            color: #008f39;
            background-color: #cdcdcd;
            border-style: solid;
            border-color: #cdcdcd;
            border-radius: .28571429rem;
        }
        #continueBtn {
            margin-top: 10px;
            margin-bottom: 10px;
            width: 30%;
            padding: 10px;
            cursor: pointer;
            background-color: #008f39;
            color:white;
            font-size: 15px;
            border-radius: .28571429rem;
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

                                //Imprime posibles respuestas
                                for ($i = 0; $i < count($value2['respuestas']); $i++) {

                                    //Muestra aciertos
                                    if ($showResultTest1) {
                                        $correctOptionMsg = $answersTest1[$level2];

                                        if (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "right")) {
                                            $className = "right";
                                        } elseif (($a_userAnswers[$level2]['option'] == $i) && ($a_userAnswers[$level2]['status'] == "wrong")) {
                                            $className = "wrong";
                                            $errors++;
                                        } else {
                                            $className = "nsnc";
                                            $errors++;
                                        }

                                        //Mensaje superación
                                        if ($errors > 2) {
                                            $resultMsg = "No has superado el test";
                                        } else {
                                            $resultMsg = "Has superado el test";
                                        }

                                        //Desabilita radiobutton cuando muestra resultados
                                        $disabled = "disabled";

                                        echo ('<br>' . $errors);
                                        if ($showResultTest1) {
                                            echo "<div id=\"resultMsg\">" . $resultMsg . "
                                               <button type=\"submit\" name=\"continue\" id=\"continueBtn\">Continuar</button>
                                           </div>";
                                        }
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
                                    echo "<span> Respuesta correcta: " . $correctOptionMsg . "</span>";
                                }

                                echo ("</div>");
                            }
                        }
                    }
                }
            }
            ?>





            <button type="submit" name="submitTest1">Enviar</button>
        </form>
    </main>
<?php

}



if ($showTest2) {
?>
    <h1>Test 2: Permiso B</h1>

<?php

}

if ($showTest3) {
?>
    <h1>Test 3: Permiso B</h1>

<?php

}
?>