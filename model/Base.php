<?php

/** Smarty **/
include(VNDPH . 'smarty/libs/Smarty.class.php');
/** Database */
include(MDLPH . 'DB.php');

/*
|--------------------------------------------------------------------------
| Base
|--------------------------------------------------------------------------
|
| ###
|
*/
class Base
{    
    /**
     * Index for all action execute by controller to get 
     * a flag message if the code crash
     * 
     * @return int
     */
    public $index = 0;

    /**
     * Variable to get all result data 
     * 
     * @return array
     */
    public $data;

    /**
     * Store and validate keys.
     *
     * @return boolean
     */
    public $keys;

    /** 
     * Hadle all connections to databases
     * 
     * @return object
     */
    public $db;

	public function isValid() { return base64_encode($this->keys['GT']) === $this->keys['PT']; }

    /**
     * List of possible modules to be used for the controller 
     * system to manipulate the objects.
     *
     * @return boolean
     */
    public $moduleList = "backup|brand|category|cron|order|partner|product";

    public function isModule() { return in_array($this->module, explode("|", $this->moduleList)); }

    /**
     * List of possible cron that can be executed by the system to 
     * manipulate the elements.
     * 
     * @return boolean
     */
    public $crontab = "brand|category|order|partner|product";

    public $cron;

    public function isCron() { return in_array($this->cron, explode("|", $this->crontab)); }

    /**
     * List of possible method or operations (CRUD) that can be executed 
     * by the system to manipulate the elements.
     *
     * @return boolean
     */
    public $methodList = "info|create|read|update|delete";

    public $method = null;

    public function isCRUD() { return in_array($this->method, explode("|", $this->methodList)); }

    /** 
     * Flag block, detect the current status
     * of elements
     * 
     * @return string
     */
    public $status = ['inactive', 'active', 'different', 'deleted'];
    public $label = ['label label-default', 'label label-success', 'label label-warning', 'label label-error'];
    public $button = ['btn btn-default', 'btn btn-primary', 'btn btn-warning', 'btn btn-error'];

    public function getFlag($e, $s) { return $this->$e[$s]; }

    /**
     * List of icon per modules and action
     * 
     * @return string
     */
    public $icon = [
        'module' => [
            "brand" => 'fa-copyright', 
            "category" => 'fa-sitemap', 
            "order" => 'fa-list', 
            "partner" => 'fa-users', 
            "product" => 'fa-th-large'
        ],
        'method' => [
            "info" => 'fa-eye', 
            "create" => 'fa-plus',
            "read" => 'fa-list',
            "update" => 'fa-edit',
            "delete" => 'fa-trash'
        ]
    ];

    public function getIcon($t, $d) { return $this->icon[$t][$d]; }

    /**
     * Set values in some variables to pass information 
     * about module to view
     * 
     * @return string
     */
    public function setInfo() 
    {
        $this->title = $this->module;
        $this->description = ucfirst($this->module) . ' details';
    }

    /**
     * Get the last moment when the file was modified
     * 
     * @return array
     */
    public $lastTime;
    
    public function getLastDay()
    {
        $now = new DateTime('NOW');
        $now->setTimezone(new DateTimeZone('America/Caracas'));

        /** Last modified */
        $this->lastTime = new DateTime(date('F d Y H:i:s.', getlastmod()));
        $this->lastTime->setTimezone(new DateTimeZone('America/Caracas'));

        $this->lastTime = $now->diff($this->lastTime);
    }

    /**
     * Get date of the last table synchronized
     * 
     * @return string
     */
    public $synchronized;

    public function getLastSynchronized( $table ) 
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->synchronized = $this->db->connection
                ->getOne(
                    "SELECT MAX(tb.date_upd) AS date_upd FROM $table tb"
                );
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }

        $this->db->connection->close();
    }
    
    /**
	 * Construct of the view to display data just if the modules 
     * have a file to get each template per action
	 * 
	 * @return string
	 */    
    public $view;
    public $html;
    public $title;
    public $description;

    public function getView() 
    {
        $this->view = new Smarty;
        $this->view->caching = true;
        $this->view
            ->setTemplateDir(PUBPH . 'views/modules/')
            ->setCacheDir(PUBPH . 'views/cache')
            ->setCompileDir(PUBPH . 'views_c/');
        
        $this->html = $this->view->getTemplateDir(0) . '/' . $this->module . '/' . $this->method . '.tpl';
    }

    public function isView() { return is_file($this->html); }
    
    /**
     * Automatic error list separated by language and 
     * index in an array.
     *
     * @return array
     */
    private $errorList = array (
        'spanish'   =>  array (
            'system'=>	array (
                1   =>  '¡Error de criptografia en la clave asimetrica RSA/PKCS!',
                2	=>	'¡Fallo la conexión!',
                3   =>  '¡No existe este modelo!',
                4	=>	'¡No existe este proceso!'
            ),
            'user'	=>	array(
                0	=>	'¡Esta dirección de email ya se encuentra registrada!',
                1	=>	'¡Este dirección de email no se encuentra registrada!'
            ),
            'order' =>  array(
                0   =>  '¡No hay ordenes registradas!',
                1   =>  ''
            )
        ),
        'english'   =>  array (
            'system'=>	array (
                0   =>  'Cryptographic error in the asymmetric key RSA / PKCS!',
                1	=>	'Connection failed!',
                2   =>  'This controller does not exist!',
                3	=>	'This process does not exist!'
            ),
            'user'	=>	array (
                0	=>	'This email address is already registered!',
                1	=>	'This email address is not registered!'
            )
        )
    );
    public $_error;
}
