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
    /** DB Connection */
    private $db;

    /** Table Head */
    public $thead = ['ID', 'Reference', 'Customer', 'Payment Method', 'Total'];

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
}
