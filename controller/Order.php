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
        $order->action = (isset($_POST['controller'])) ? base64_decode($_POST['controller']) : null ;
        
        if ( $order->isModule() && $order->isCRUD()) {
            /** This is the method to execute */
            $act = $order->action . ucfirst($order->module) ;
        } else {
            $order->getError(0);
        }
    } else {
        $order->getError(0);
    }

    $order->getView();
    if ($order->isView()) {
        if(!$order->view->isCached($order->html)) {
            /** Execute */
            $order->$act();
            $order->view->assign('title', $order->module)
                        ->assign('description', $order->description)
                        ->assign('thead', $order->thead)
                        ->assign('data', $order->data);
        }
        $order->view->display($order->html);
    } 
}