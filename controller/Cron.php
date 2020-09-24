<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Cron.php');
/*
|--------------------------------------------------------------------------
| Cron Controller
|--------------------------------------------------------------------------
|
| This code handles all request about cron controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $cron = new Cron();
    
    $cron->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $cron->isValid() ) {
        $cron->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $cron->method = (isset($_POST['method'])) ? base64_decode($_POST['method']) : null ;
        
        if ( $cron->isModule() && $cron->isCRUD()) {
            /** This is the method to execute */
            $act = $cron->method . ucfirst($cron->module) ;
        }
    }

    $cron->getView();
    if ($cron->isView()) {
        if(!$cron->view->isCached($cron->html)) {
            /** Execute */
            $cron->$act();
            $cron->view->assign('title', $cron->module)
                        ->assign('description', $cron->description)
                        ->assign('thead', $cron->thead)
                        ->assign('data', $cron->data);
        }
        $cron->view->display($cron->html);
    } 
}