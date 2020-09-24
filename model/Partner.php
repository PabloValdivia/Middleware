<?php

/**
 *
 * Author : David Marquez
 * Date   : 24 September 2020
 * 
 */
require(MDLPH . 'Base.php');

class Partner extends Base
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
    public $table = "tm_customer";

    /** Table Head */
    public $thead = ['#', 'partner', 'email', 'iso', 'status', 'updated'];

    /** Partner ID */
    public $id;

    public function readPartner()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT ROW_NUMBER() OVER (ORDER BY tc.id_customer) AS nro, CONCAT(tc.firstname, ' ', tc.lastname) AS name, tc.email, tl.iso_code,  tc.active, tc.date_upd 
                    FROM $this->table tc
                    INNER JOIN tm_lang tl ON tl.id_lang = tc.id_lang"
                );
            $this->setInfo();
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }

        $this->db->connection->close();
    }

    public function infoPartner()
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
