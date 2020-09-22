<?php 

/*
|--------------------------------------------------------------------------
| Project data
|--------------------------------------------------------------------------
|
| ###
|
*/
$_NAME = 'Middleware';

/*
|--------------------------------------------------------------------------
| Project configuration
|--------------------------------------------------------------------------
|
| ###
|
*/
ini_set('memory_limit', '262M');

/*
|--------------------------------------------------------------------------
| Key Generator
|--------------------------------------------------------------------------
|
| ###
|
*/
$private = 'pEmHPrfGkThPehUsJvnhez6efpIh1q1WurNQMf+P/hGDhb/Vd22EIOGZpKACFVKT2gf+iCdOtNpKinf/AZuilZwf6CU/7JrgD62OViiXe5qYnPDwFKSW/ZmQXfO8rfa0hl00tJNI1ApWuMntxVc8s2lxs79W6hbPxQWh5TvywECj2cAC/e+xvj3';
$tkn = sha1($private.rand(2780,999999));

/*
|--------------------------------------------------------------------------
| Mode Debug
|--------------------------------------------------------------------------
|
| ###
|
*/
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');


/*
|--------------------------------------------------------------------------
| DB Credentials
|--------------------------------------------------------------------------
|
| ###
|
*/

$_DB = array (
  'prestashop' => 
  array (
    'database_system' => 'mysql',
    'database_host' => '127.0.0.1',
    'database_port' => '',
    'database_name' => 'todomarket',
    'database_user' => 'pan_web',
    'database_password' => '439511541',
    'database_prefix' => 'tm_',
    'database_engine' => 'InnoDB',
  ),
  'idempiere' => 
  array(
    'database_system' => 'postgres',
    'database_host' => '192.168.0.14',
    'database_port' => '5432',
    'database_name' => 'idempiere',
    'database_user' => 'adempiere',
    'database_password' => 'adempiere',
  )
);  