<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Order.php');
/*
|--------------------------------------------------------------------------
| Order Controller
|--------------------------------------------------------------------------
|
| This code handles all request about order controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $order = new Order();
    
    $order->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $order->isValid() ) {
        $order->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $order->method = (isset($_POST['method'])) ? base64_decode($_POST['method']) : null ;
        
        if ( $order->isModule() && $order->isCRUD()) {
            /** This is the method to execute */
            $act = $order->method . ucfirst($order->module) ;
        }
    }

    $order->getView();
    if ($order->isView()) {
        if(!$order->view->isCached($order->html)) {
            /** Execute */
            $order->$act();
            $order->view
                ->assign('title', $order->module)
                ->assign('description', $order->description)
                ->assign('thead', $order->thead)
                ->assign('data', $order->data)
                ->assign('synchronized', $order->synchronized);
        }
        $order->view->display($order->html);
    } 
}