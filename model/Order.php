<?php
/**
 *
 * Author : David Marquez
 * Date   : 20 September 2020
 * 
 */
require(MDLPH . 'Base.php');
require(MDLPH . 'DB.php');

class Order extends Base
{
    /** DB Connection */
    private $db;

    /** Order ID */
    private $id = 0;

    /** Order Number */
    public $doc_number = '';

    /** Order Reference */
    public $doc_reference = '';

    /** Data */
    public $data;

    public function readOrder($scope) {
        $this->db = new DB('prestashop');
        if ( $this->db->connection->isConnected() ) {
            $this->data = $this->db->connection->getAll('select * from tm_orders');
            
            if ( $this->data->numRows() > 0 ) {
                $this->index++;
            } else {
                $this->getError(0, $this->module, $this->index);
            }
        } else {
            $this->_errror = $this->db->connection->errorMsg();
        }
    }
}
