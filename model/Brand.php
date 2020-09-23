<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');
require(MDLPH . 'DB.php');

class Brand extends Base
{
    /** DB Connection */
    private $db;

    /** Table Head */
    public $thead = ['#', 'Brand', 'Status', 'Updated'];

    /** Brand ID */
    private $id = 0;

    public function readBrand()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT ROW_NUMBER() OVER (ORDER BY tm.id_manufacturer) AS nro, tm.name, CASE WHEN tm.active = 1 THEN 'active' ELSE 'inactive' END AS status, tm.date_upd
                    FROM tm_manufacturer tm 
                    INNER JOIN tm_manufacturer_lang tml ON tml.id_manufacturer = tm.id_manufacturer AND tml.id_lang = 2"
                );
            $this->title = $this->module;
            $this->description = ucfirst($this->module) . ' details';
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }
    }
}
