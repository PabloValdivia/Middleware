<?php

require(dirname(__FILE__) . '/Controller.php');
require(MDLPH . 'Category.php');
/*
|--------------------------------------------------------------------------
| Category Controller
|--------------------------------------------------------------------------
|
| This code handles all request about category controller
|
*/
if (isset($_SESSION['temp']) || isset($_SESSION['User_ID'])) {

    $category = new Category();
    
    $category->keys = array('GT' => $_GET['token'], 'PT' => $_POST['token']);
    if ( $category->isValid() ) {
        $category->module = (isset($_POST['module'])) ? strtolower(base64_decode($_POST['module'])) : null ;    
        $category->action = (isset($_POST['controller'])) ? base64_decode($_POST['controller']) : null ;
        
        if ( $category->isModule() && $category->isCRUD()) {
            /** This is the method to execute */
            $act = $category->action . ucfirst($category->module) ;
        } else {
            $category->getError(0);
        }
    } else {
        $category->getError(0);
    }

    $category->getView();
    if ($category->isView()) {
        if(!$category->view->isCached($category->html)) {
            /** Execute */
            $category->$act();
            $category->view->assign('title', $category->module)
                        ->assign('description', $category->description)
                        ->assign('thead', $category->thead)
                        ->assign('data', $category->data);
        }
        $category->view->display($category->html);
    } 
}