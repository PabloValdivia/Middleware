<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Product.php');
/*
|--------------------------------------------------------------------------
| Product Controller
|--------------------------------------------------------------------------
|
| This code handles all request about product controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $product = new Product();
    
    $product->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $product->isValid() ) {
        $product->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $product->method = (isset($_POST['method'])) ? base64_decode($_POST['method']) : null ;
        
        if ( $product->isModule() && $product->isCRUD()) {
            /** This is the method to execute */
            $act = $product->method . ucfirst($product->module) ;
        }
    }

    $product->getView();
    if ($product->isView()) {
        if(!$product->view->isCached($product->html)) {
            /** Execute */
            $product->$act();
            $product->view
                ->assign('title', $product->module)
                ->assign('description', $product->description)
                ->assign('thead', $product->thead)
                ->assign('data', $product->data)
                ->assign('synchronized', $product->synchronized);
        }
        $product->view->display($product->html);
    } 
}