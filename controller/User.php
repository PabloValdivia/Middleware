<?php

require('/model/User.php');
/*
|--------------------------------------------------------------------------
| User Controller
|--------------------------------------------------------------------------
|
| This code handles all request about user controller
|
*/
if (isset($_POST['form'])) {
    $id  = (isset($_SESSION['User_ID'])) ? $_SESSION['User_ID'] : $_POST['User_ID'];

    $user = new User($id);

    $form = $_POST['form'];
    

    echo json_encode($resp);

    #define('VIEW', $html->template_dir . $_POST['module'] . $_POST['controller'] . '.ptl');
    
}