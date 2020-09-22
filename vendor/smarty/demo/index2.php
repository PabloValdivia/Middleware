<?php
/**
 * Example Application
 *
 * @package Example-application
 */

require '../libs/Smarty.class.php';

$smarty = new Smarty;

  $smarty->assign('title', 'My Title');
  $smarty->assign('string', 'My ffffff');
  
$smarty->assign("datos", array(
    "nombre" => "alex",
    "apellido" => "jmz"
                                  
));
 
 $smarty->display('header.tpl');
