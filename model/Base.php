<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

/** Smarty **/
include(VNDPH . 'smarty/libs/Smarty.class.php');

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
    /** Index of code process */
    public $index = 0;

    public $data;

    /**
     * Validate that the keys received match.
     *
     * @return string
     */
    public $keys;

	public function isValid() {
        $this->index++;
		return base64_encode($this->keys['GT']) === $this->keys['PT'];
    }

    /**
     * List of possible actions or operations (CRUD) that can be executed 
     * by the system to manipulate the elements.
     *
     * @return string
     */
    private $moduleList = "brand|category|order|partner";

    public $module;

    public function isModule () {
        $this->index++;
        return in_array($this->module, explode("|", $this->moduleList));
    }

    /**
     * List of possible actions or operations (CRUD) that can be executed 
     * by the system to manipulate the elements.
     *
     * @return string
     */
    private $actionList = "create|read|update|delete";

    public $action = null;

    public function isCRUD() {
        $this->index++;
        return in_array($this->action, explode("|", $this->actionList));
    }
    
    /**
	 * View contruction
	 * 
	 * @return view
	 */    
    public $view;
    public $html;
    public $title;
    public $description;

	public function getView() {
        $this->index++;
		/** The class is instantiated to build the views that will be supplied to the client. **/
        $this->view = new Smarty;
        $this->view->caching = true;
        $this->view->setTemplateDir(PUBPH . 'views/modules/')
                    ->setCacheDir(PUBPH . 'views/cache')
                    ->setCompileDir(PUBPH . 'views_c/');
        
        $this->html = $this->view->getTemplateDir(0) . '/' . $this->module . '/' . $this->action . '.tpl';
    }

    public function isView() {
        $this->index++;
        return is_file($this->html);
    }
    
    /**
     * Automatic response list separated by language and 
     * index in an array.
     *
     * @return array
     */
    private $responseList = array (
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

    public function getError($_lang = 0) {
        $this->_error = $this->responseList[$_lang][$this->module][$this->index];
    }
}
