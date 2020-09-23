<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');
require(MDLPH . 'DB.php');

class Category extends Base
{
    /** DB Connection */
    private $db;

    /** Table Head */
    public $thead = ['#', 'Parent', 'Category', 'Status', 'Updated'];

    /** Category ID */
    private $id = 0;

    public function readCategory()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT ROW_NUMBER() OVER (ORDER BY tc_p.id_category, tc.id_category) as position, COALESCE(tcl_p.name, '') AS parent, tcl.name, CASE WHEN tc.active = 1 THEN 'active' ELSE 'inactive' END AS status, tc.date_upd 
                    FROM tm_category tc 
                    INNER JOIN tm_category_lang tcl ON tcl.id_category = tc.id_category AND tcl.id_lang = 2
                    LEFT JOIN tm_category tc_p ON tc_p.id_category = tc.id_parent 
                    LEFT JOIN tm_category_lang tcl_p ON tcl_p.id_category = tc_p.id_category AND tcl_p.id_lang = 2"
                );
            $this->title = $this->module;
            $this->description = ucfirst($this->module) . ' details';
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }
    }
}
