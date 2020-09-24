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
    /**
     * Information about the construction 
     * of the module
     * 
     * @return string
     */
    public $author = 'Totto Marquez';
    public $email = 'davidmarsant@gmail.com';
    public $version = '1.0.2';

    /** DB Connection */
    private $db;

    /** Table Head */
    public $thead = ['#', 'Parent', 'Category', 'Status', 'Updated'];

    /** Category ID */
    private $id;

    /** Last Synchronized */
    public $synchronized;

    public function readCategory()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT ROW_NUMBER() OVER (ORDER BY tc_p.id_category, tc.id_category) as position, COALESCE(tcl_p.name, '') AS parent, tcl.name, tc.active, tc.date_upd 
                    FROM tm_category tc 
                    INNER JOIN tm_category_lang tcl ON tcl.id_category = tc.id_category AND tcl.id_lang = 2
                    LEFT JOIN tm_category tc_p ON tc_p.id_category = tc.id_parent 
                    LEFT JOIN tm_category_lang tcl_p ON tcl_p.id_category = tc_p.id_category AND tcl_p.id_lang = 2"
                );
            $this->synchronized = $this->db->connection
                ->getOne(
                    "SELECT MAX(tc.date_upd) AS date_upd FROM tm_category tc"
                );
            $this->setInfo();
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }

        $this->db->connection->close();
    }

    public function infoCategory()
    {
        $this->db = new DB('prestashop');

        if ($this->db->connection->isConnected()) {
            $this->synchronized = $this->db->connection
                ->getOne(
                    "SELECT MAX(tc.date_upd) AS date_upd FROM tm_category tc"
                );
            $this->setInfo();
            $this->getLastDay();
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
