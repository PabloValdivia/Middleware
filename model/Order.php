<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');
require(MDLPH . 'DB.php');

class Order extends Base
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
    public $thead = ['#', 'Reference', 'Customer', 'Payment Method', 'Total'];

    /** Order ID */
    private $id = 0;

    /** Order Number */
    public $doc_number = '';

    /** Order Reference */
    public $doc_reference = '';

    public function readOrder()
    {
        $this->db = new DB('prestashop');

        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection
                ->getAll(
                    "SELECT tor.id_order, tor.reference, CONCAT(tc.firstname, ' ', tc.lastname) as name, tor.payment, tor.total_paid
                    FROM tm_orders tor
                    left join tm_customer tc on tor.id_customer = tc.id_customer"
                );
            $this->title = $this->module;
            $this->description = ucfirst($this->module) . ' details';
        } else {
            $this->_error = $this->db->connection->errorMsg();
        }
    }

    public function infoOrder()
    {
        $this->db = new DB('prestashop');

        if ($this->db->connection->isConnected()) {
            $this->synchronized = $this->db->connection
                ->getOne(
                    "SELECT MAX(tor.date_upd) AS date_upd FROM tm_orders tor"
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
