<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
$processForm = true;

if (isset($_POST['start'])) {
    echo('<br>xxxxx') ;
    $selectedTest = $_POST['testSelection'];
    echo('<br>'. $selectedTest) ;
}


if ($processForm) {
?>
    <h1>Test online Autoescuela</h1>
    <h3>Selecciona el test por el que quieras comenzar.</h3>
<form action="" method="post">
<select name="testSelection" id="testSelection">
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
?>