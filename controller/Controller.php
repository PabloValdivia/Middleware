<?php

session_start();

/*
|--------------------------------------------------------------------------
| Project Path
|--------------------------------------------------------------------------
|
| Define some path to make more easy include file in the system.
|
*/

/** Project **/
define('ROOT', dirname(__FILE__) . '/../');

/** Includes **/
define('INCPH', ROOT . 'inc/');

/** Controller **/
define('CTRPH', ROOT . 'controller/');

/** Models **/
define('MDLPH', ROOT . 'model/');

/** Vendors **/
define('VNDPH', ROOT . 'vendor/');

/** Sources **/
define('PUBPH', ROOT . 'public/');