<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');

class Product extends Base
{
    /**
     * Information about the construction 
     * of the module
     * 
     * @return string
     */
    public $author = 'Totto Marquez';
    public $email = 'davidmarsant@gmail.com';
    public $version = '1.0.2';
    
    /** Table */
    private $table = "tm_product";

    /** Table Head */
    public $thead = ['#', 'Reference', 'Product', 'Category', 'Brand'];

    /** Product ID */
    private $id = 0;

    public function readProduct()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT ROW_NUMBER() OVER (ORDER BY tp.id_product) AS nro, tp.reference, tpl.name AS product, tcl.name AS category, tm.name AS brand, CASE WHEN tp.active = 1 THEN 'active' ELSE 'inactive' END AS status, tp.date_add AS created, tp.date_upd AS updated
                    FROM $this->table tp 
                    INNER JOIN ". $this->table ."_lang tpl ON tpl.id_product = tp.id_product AND tpl.id_lang = 2
                    LEFT JOIN tm_category tc ON tc.id_category = tp.id_category_default 
                    LEFT JOIN tm_category_lang tcl ON tcl.id_category = tc.id_category AND tcl.id_lang = 2
                    INNER JOIN tm_manufacturer tm ON tm.id_manufacturer = tp.id_manufacturer 
                    INNER JOIN tm_manufacturer_lang tml ON tml.id_manufacturer = tm.id_manufacturer AND tml.id_lang = 2"
                );
            $this->title = $this->module;
            $this->description = ucfirst($this->module) . ' details';
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }
    }

    public function infoProduct()
    {
        $this->db = new DB('prestashop');

        if ($this->db->connection->isConnected()) {
            $this->setInfo();
            $this->getLastDay();
            $this->getLastSynchronized($this->table);
            $this->data = array(
                'icon'      =>  $this->getIcon('module', $this->module),
                'status'    =>  'active',
                'author'    =>  $this->author,
                'email'     =>  $this->email,
                'version'   =>  $this->version,
                'modified'  =>  $this->lastTime
            );
        }

        $this->db->connection->close();
    }
}
