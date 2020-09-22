<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

/**
 *
 * Author : David Marquez
 * Date   : 20 September 2020
 * 
 */

/**
 * Inclusion to the database.
 *
 * @return file
 */
require( VNDPH . '/adodb5/adodb.inc.php');
require( VNDPH . '/adodb5/tohtml.inc.php');

/*
|--------------------------------------------------------------------------
| DB
|--------------------------------------------------------------------------
|
| This class handles all configurations and methods for 
| interaction with databases
|
*/
class DB
{
    /*
    |--------------------------------------------------------------------------
    | Database Credential
    |--------------------------------------------------------------------------
    |
    | Define the data to make the relevant connections to the system databases.
    |
    */
    private $credential = array (
        'idempiere' => array (
            'host' => '192.168.0.14', 
            'user' => 'adempiere',
            'pass' => 'adempiere',
            'port' => '5432',
            'system' => 'postgres8',
            'name' => 'idempiere'
        ),
        'prestashop' => array (
            'host' => 'localhost', 
            'user' => 'pan_web',
            'pass' => '439511541',
            'port' => '3306',
            'system' => 'mysqli',
            'name' => 'todomarket'
        )
    );

    /** Database Fetch mode */
    private $DB_FETCH_MODE = ADODB_FETCH_ASSOC;

    /** Database Connection */
    public $connection;

    public function __construct($platform){
        $this->connection = newADOConnection($this->credential[$platform]['system']);
        $this->connection->connect(
            $this->credential[$platform]['host'], 
            $this->credential[$platform]['user'], 
            $this->credential[$platform]['pass'], 
            $this->credential[$platform]['name']
        );
        $this->connection->setCharset($this->credential[$platform]['charset']);
        $this->connection->selectDb($this->credential[$platform]['name']);
        $this->connection->setFetchMode($this->DB_FETCH_MODE); 
    }
}