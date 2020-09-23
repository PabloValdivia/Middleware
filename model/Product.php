<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');
require(MDLPH . 'DB.php');

class Product extends Base
{
    /** DB Connection */
    private $db;

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
                    FROM tm_product tp 
                    INNER JOIN tm_product_lang tpl ON tpl.id_product = tp.id_product AND tpl.id_lang = 2
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
}
