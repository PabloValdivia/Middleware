<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Brand.php');
/*
|--------------------------------------------------------------------------
| Brand Controller
|--------------------------------------------------------------------------
|
| This code handles all request about brand controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $brand = new Brand();
    
    $brand->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $brand->isValid() ) {
        $brand->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $brand->method = (isset($_POST['method'])) ? base64_decode($_POST['method']) : null ;
        
        if ( $brand->isModule() && $brand->isCRUD()) {
            /** This is the method to execute */
            $act = $brand->method . ucfirst($brand->module) ;
        }
    }

    $brand->getView();
    if ($brand->isView()) {
        if(!$brand->view->isCached($brand->html)) {
            /** Execute */
            $brand->$act();
            $brand->view
                ->assign('title', $brand->module)
                ->assign('description', $brand->description)
                ->assign('thead', $brand->thead)
                ->assign('data', $brand->data)
                ->assign('synchronized', $brand->synchronized);
        }
        $brand->view->display($brand->html);
    } 
}