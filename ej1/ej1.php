<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
$processForm = false;
$showTest1 = true;
$showTest2 = false;
$showTest3 = false;

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

if ($showTest1) {
?>
    <style>
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
                            echo "<p class='answer'>Respuestas</p>";

                            echo "<label for='a'>" . $value2['respuestas'][0] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . "id='a'><br>";

                            echo "<label for='a'>" . $value2['respuestas'][1] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . "id='b'><br>";

                            echo "<label for='a'>" . $value2['respuestas'][2] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . "id='c'><br>";

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