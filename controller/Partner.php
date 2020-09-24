<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Partner.php');
/*
|--------------------------------------------------------------------------
| Partner Controller
|--------------------------------------------------------------------------
|
| This code handles all request about partner controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $partner = new Partner();
    
    $partner->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $partner->isValid() ) {
        $partner->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $partner->method = (isset($_POST['method'])) ? base64_decode($_POST['method']) : null ;
        
        if ( $partner->isModule() && $partner->isCRUD()) {
            /** This is the method to execute */
            $act = $partner->method . ucfirst($partner->module) ;
        }
    }

    $partner->getView();
    if ($partner->isView()) {
        if(!$partner->view->isCached($partner->html)) {
            /** Execute */
            $partner->$act();
            $partner->view
                ->assign('title', $partner->module)
                ->assign('description', $partner->description)
                ->assign('thead', $partner->thead)
                ->assign('data', $partner->data)
                ->assign('synchronized', $partner->synchronized);
        }
        $partner->view->display($partner->html);
    } 
}