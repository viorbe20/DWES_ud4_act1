<?php

/**
 * Test online para una autoescuela.
 * @author Virginia Ordoño Bernier
 * @date April 2022
 */
include "config/tests_cnf.php";
$processForm = true;
$showTest1 = false;
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
    <h1>Test 1: Permiso B</h1>

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