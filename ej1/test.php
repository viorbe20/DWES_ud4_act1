<main>
            <form action="" method="post">
                <button type="submit" name="submitTest1">Enviar</button>
    
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
                    <button type=\"submit\" name=\"repeatTest\" id=\"repeatTest1Btn\">Repetir test</button>
                    </div>
                    </div>";
                }
                ?>
                <button type="submit" name="submitTest1">Enviar</button>
            </form>
        </main>