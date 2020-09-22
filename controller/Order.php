<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

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
if (isset($_POST['form'])) {

    /** Data form */
    $form = $_POST['form'];

    /** Key */
    $token['GT'] = $_GET['token'];
    $token['PT'] = parse_str($form['tkn']);
    
    #$order = new Order();

    /** Validation key */
    #$order->isValid($token);

    /**
	 * Verify the action to manipulate object
	 *
	 * @return array
	 */
	#$order->isCRUD($form['controller']);

    echo json_encode($form);    
}