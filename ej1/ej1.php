<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";

$processForm = false;
$showTest1 = true;
$showResultTest1 = false;
$showTest2 = false;
$showTest3 = false;
$correctAnswer;
$options = ["a", "b", "c"];

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
    $showTest1 = false;
    $showResultTest1 = true;

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
                            if ($answersTest1[$i-1] == $options[$_POST[$i]]) {
                                echo('<br>Correcta') ;
                            } else {
                                echo('<br>Incorrecta') ;
                            }
                        } else {
                            //echo('<br>No contesta') ;
                        }
                    }
                }
            }
        }
    }
}


if ($processForm) {
?>
    <h1>Test online Autoescuela</h1>
    <h3>Selecciona el test por el que quieras comenzar.</h3>
    <form action="" method="post">
        <select name="selectedTest">
            <option value="1">Test 1</option>
            <option value="2">Test 2</option>
            <option value="3">Test 3</option>
        </select>
        <br>
        <br>
        <button type="submit" name="start">Comenzar</button>
    </form>
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
    </style>
    <main>
        <form action="" method="post">
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
                                    echo "<label for='a'>" . $value2['respuestas'][$i] . "</label>";
                                    echo "<input type=\"radio\" name=" . $value2['idPregunta'] . " value=\"$i\"/>";
                                    echo('<br>') ;
                                }
                                echo ("</div>");
                            }
                        }
                    }
                }
            }
            ?>
            <br>
            <button type="submit" name="submitTest1">Enviar</button>
        </form>
    </main>
<?php

}

//MUestra resultados test1
if ($showResultTest1) {
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