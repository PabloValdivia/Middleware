<?php

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

    /**
     * Validate that the keys received match.
     *
     * @return string
     */
    public $keys;

	public function isValid($token = null) {
        $this->index++;
		return $token['GT'] === sha1($token['PT']);
    }

    /**
     * List of possible actions or operations (CRUD) that can be executed 
     * by the system to manipulate the elements.
     *
     * @return string
     */
    public $moduleList = "brand|category|order|partner";

    /** Model */
    public $module = null;

    public function isModule ( $module ) {
        $this->index++;
        return in_array($module, explode("|", $this->moduleList));
    }

    /**
     * List of possible actions or operations (CRUD) that can be executed 
     * by the system to manipulate the elements.
     *
     * @return string
     */
    public $actionList = "create|read|update|delete";

    /** Action */
    public $action = null;

    public function isCRUD( $action ) {
        $this->index++;
        return in_array($action, explode("|", $this->actionList));
    }
    
    /**
	 * View contruction
	 * 
	 * @return view
	 */    
    public $view;
    public $html;

	public function getView( $module, $action ) {
        $this->index++;
		/** The class is instantiated to build the views that will be supplied to the client. **/
		$this->view = new Smarty;
        $this->view->template_dir = PUBPH . 'views/modules/';
        $this->view->compile_dir = VNDPH . 'smarty/demo/templates_c/';
        $this->view->config_dir = VNDPH . 'smarty/demo/configs/';
        $this->view->cache_dir = VNDPH . 'smarty/demo/cache/';
        
        $this->html = $this->template_dir . $module . $action . '.tpl';
    }

    public function isView() {
        return is_file($this->html);
    }
    
    /**
     * Automatic response list separated by language and 
     * index in an array.
     *
     * @return array
     */
    public $responseList = array (
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
    public $_error = null;

    public function getError($_lang = 0, $module, $index) {
        $this->_error = $this->responseList[$_lang][$module][$index];
    }
}
