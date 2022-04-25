<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
//include "dir_img_test1";

$processForm = false;
$showTest1 = true;
$showResultTest1 = false;
$showTest2 = false;
$showTest3 = false;

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
    foreach ($aTests as $key => $value) {
        
        if ($key == 0) {
            
            foreach ($value as $level1 => $value) {
                
                if ($level1 == "Preguntas") {
                    
                    //Recorre como tantas preguntas tenga el test
                    for ($i=0; $i < count($value); $i++) { 
                        echo($_POST['answerQ' . $i+1 ]);

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
        main{
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

                            echo "<label for='a'>" . $value2['respuestas'][0] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . " id='a'/><br>";

                            echo "<label for='a'>" . $value2['respuestas'][1] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . " id='b'/><br>";

                            echo "<label for='a'>" . $value2['respuestas'][2] . "</label>";
                            echo "<input type='radio' name='answerQ" . $value2['idPregunta'] . " id='c'/><br>";

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