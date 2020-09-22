<?php
/**
 * Example Application
 *
 * @package Example-application
 */

require './Smarty.class.php';

$smarty = new Smarty;

  $smarty->assign('title', 'My Title');
  $smarty->assign('string', 'My ffffff');
  
$smarty->assign("datos", array(
    "nombre" => "alex",
    "apellido" => "jmz"
                                  
));
 
 $smarty->display('info.phtml');
