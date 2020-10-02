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
    /** Org ID */
    public $ad_org_id;

    /** Sequence ID */
    public $sequence_id;

    /** Sales Rep */
    public $salesrep_id;

    public function __construct()
    {
        /** Information about the construction of the module */
        $this->author      = 'Totto Marquez';
        $this->email       = 'davidmarsant@gmail.com';
        $this->version     = '1.0.3';
        $this->description = 'Sync partner data between PrestaShop and iDempiere';

        /** All data about PrestaShop customer module */
        $this->table = 'tm_customer';
        $this->column = ['id', 'name', 'email', 'active', 'created', 'updated', 'last synchronized'];
    
        /** All data to insert every customer on iDempiere */
        $this->ad_org_id        = 1000066; // COMERCIALIZADORA ONE CLICK C.A.
        $this->ad_sequence_id = [
            'c_location'  =>  60,          // Secuencia de la tabla Location
            'ad_user'   =>  25             // Secuencia de la tabla User
        ];
        $this->salesrep_id      = 1006512; // Tienda Web
    }

    public function info()
    {
        # ...
    }

    /**
     * Insert a list of elements in the table with a loop that
     * duplicates the records depending on the languages and 
     * stores that the PrestaShop platform handles
     * 
     * @param string $system Name of system
     * @param string $table Name of table
     * @param array $new Array with all values of the new register
     * 
     * @return array $new Array supplied with updated values
     */
    public function create($system, $table, $new)
    {
        $db = new DB($system);

        if ( $db->connection->isConnected() ) {
            
            $primary = $this->getUniqueKey($system, $table);

            if ($system == "idempiere") {
                $new[$table.'_id'] = $db->connection->getOne("SELECT nextid(". $this->ad_sequence_id[$table] .", 'N')");
                $new[$table.'_uu'] = $db->connection->getOne("SELECT generate_uuid()");
            }
            
            $db->connection->autoExecute($table, $new, 1);
            $this->setSynchronized($system, $table, $new[$primary]);
        } else {
            $this->_error = $db->connection->errorMsg();
        }

        $db->connection->close();

        return $new;
    }

    public function read()
    {
        /**
         * Get all the records in the table
         * 
         * @return array
         */
        $db = new DB('prestashop');

        if ( $db->connection->isConnected() ) {
            $this->data = $db->connection->getAll(
                    "SELECT tc.id_customer, tc.firstname, tc.email, tc.active, tc.date_add, tc.date_upd, case when tc.lastsynchronized = '0000-00-00 00:00:00' then null else tc.lastsynchronized end as lastsynchronized
                    FROM $this->table tc
                    JOIN tm_customer_group tcg ON tcg.id_customer = tc.id_customer
                    JOIN tm_group_lang tgl ON tgl.id_group = tcg.id_group AND tgl.id_lang = 2"
            );
        } else {
            $this->_error = $db->connection->errorMsg();
        }

        $db->connection->close();
    }

    /**
     * Update a register just in some fields 
     * 
     * @param string $system Name of system
     * @param string $table Name of table
     * @param int $id ID of the row to update
     * @param array $new Array with all updated values
     */
    public function update($system, $table, $id, $new)
    {
        $upColumns = [
            'idempiere' =>  [
                'c_location'=>  ['address1', 'address2', 'postal', 'city'],
                'ad_user'   =>  ['']
            ],
            'prestashop'=>  [
                'tm_address'   =>  ['c_location_id'],
                'tm_customer'  =>  ['ad_user_id']
            ]
        ];
        
        $db = new DB($system);
        
        if ( $db->connection->isConnected() ) {
            /** Unique and Primary key of table */
            $primary = $this->getUniqueKey($system, $table);

            /** Fields to update */
            $fields = '';
            foreach ($upColumns[$system][$table] as $key => $column) {
                if (array_key_exists($column, $new)) {
                    $fields .= ($key == 0) ? $column . '=' . $new[$column] : ', ' . $column . '=' . $new[$column] ;    
                }
            }

            /** Where clause */
            $clause = $primary . ' = ' . $id;

            $db->connection->execute('UPDATE ' . $table . ' SET ' . $fields . ' WHERE '. $clause);
            $this->setSynchronized($system, $table, $id);
        }

        $db->connection->close();
    }

    public function sync()
    {
        /**
         * New data to insert or update in iDempiere table.
         * Get all address of customer to insert on C_Location table.
         * Get all customer that no are convert yet (Cliente Potencial => Customer_Group => 3)
         * also get every modified customer 
         * 
         * @return array
         */
        $db = new DB('prestashop');

        $result = [];

        if ( $db->connection->isConnected() ) {

             /** Address => Location  */
            $result['idempiere']['c_location'] = $db->connection->getAssoc(
                "SELECT 
                    ta.id_address as id, ta.c_location_id AS c_location_id, 1000001 AS ad_client_id, 0 AS ad_org_id, 'Y' AS isactive, ta.date_add AS created, $this->salesrep_id AS createdby, ta.date_upd AS updated, $this->salesrep_id AS updatedby, ta.address1 AS address1,
                    ta.address2 AS address2, ta.city AS city, ta.postcode AS postal, null AS postal_add, tc.c_country_id AS c_country_id, ts.c_region_id AS c_region_id, tci.c_city_id AS c_city_id, ts.name AS regionname, null AS address3, 
                    null AS address4, null AS c_location_uu, null AS validateaddress, null AS result, 'N' AS isvalid, null AS c_addressvalidation_id, null AS address5, null AS comments, case when ta.lastsynchronized = '0000-00-00 00:00:00' then null else ta.lastsynchronized end AS lastsynchronized, ta.id_address
                FROM 
                    tm_address ta
                    JOIN tm_country tc ON tc.id_country = ta.id_country
                    LEFT JOIN tm_state ts ON ts.id_state = ta.id_state 
                    LEFT JOIN tm_city tci ON tci.id_city = ta.id_city
                WHERE
                    (ta.lastsynchronized IS NULL OR ta.lastsynchronized < ta.date_upd) 
                    AND ta.active = 1 AND ta.deleted = 0"
            );

            /** Customer => User */
            $result['idempiere']['ad_user'] = $db->connection->getAssoc(
                "SELECT DISTINCT 
                    tc.id_customer as id, tc.ad_user_id AS ad_user_id, 1000001 AS ad_client_id, 0 AS ad_org_id, 'Y' AS isactive, now() AS created, 1000440 AS createdby,
                    now() AS updated, 1000440 AS updatedby, CONCAT(tc.firstname, ' ', tc.lastname) AS name, null AS description, null AS password, tc.email, null AS superviso_id,
                    null AS c_bpartner_id, 'N' AS processing, null AS emailuser, null AS emailuserpw, null AS c_bpartner_location_id, null AS c_greeting_id, null AS title,
                    null AS comments, ta.phone AS phone, ta.phone_mobile AS phone2, null AS fax, null AS lastcontact, null AS lastresult, tc.birthday AS birthday, null AS ad_orgtrx_id, null AS emailverify, null AS emailverifydate,
                    'X' AS notificationtype, 'Y' AS isfullbpaccess, null AS ldapuser, null AS connectionprofile, tc.firstname AS value, null AS userpin, 'N' AS isinpayroll,
                    '' AS ad_user_uu, null AS ismenuautoexpand, null AS salt, 'N' AS islocked, null AS dateaccountlocked, 0 AS failedlogincount, null AS datepasswordchanged, null AS datelastlogin,
                    'N' AS isnopasswordreset, 'N' AS isexpired, null AS securityquestion, null AS answer, 'Y' AS issaleslead, ta.c_location_id AS c_location_id, 'WS' AS leadsource,
                    null AS leadstatus, null AS leadsourcedescription, null AS leadstatusdescription, null AS c_campaign_id, null AS salesrep_id, case when ta.company = '' or ta.company is null then concat(tc.firstname, ' ', tc.lastname) else ta.company end AS bpname, null AS bp_location_id,
                    'N' AS isaddmailtextautomatically, null AS r_defaultmailtext_id, null AS ad_image_id, 'N' AS isnoexpire, 'N' AS issupportuser, case when tc.lastsynchronized = '0000-00-00 00:00:00' then null else tc.lastsynchronized end AS lastsynchronized, tc.id_customer
                FROM 
                    $this->table tc 
                    JOIN tm_customer_group tcg ON tcg.id_customer = tc.id_customer 
                    JOIN tm_address ta ON ta.id_customer = tc.id_customer 
                WHERE 
                    (tc.lastsynchronized IS NULL OR tc.lastsynchronized < tc.date_upd)
                    AND tcg.id_group IN (3, 4) AND ta.deleted = 0"
            );
        }

        $db->connection->close();

        /**
         * Get updated data on iDempiere table to synchronize
         * 
         * @return array
         */

        $db = new DB('idempiere');

        if ( $db->connection->isConnected() ) {
            
        }

        $db->connection->close();

        /**
         * Loops to get every row and do what have to do 
         * 
         *  1) result ['idempiere']
         *  2) result ['idempiere'] ['ad_user']
         *  3) result ['idempiere'] ['ad_user'] [1]
         * 
         */

        /** First loop to pass between systems */
        foreach ($result as $system => $tables) {

            /** Second loop pass throw tables */
            foreach ($tables as $table => $rows) {

                /** Third loop pass throw registers */
                foreach ($rows as $id => $value) {
                    if (is_null($value['lastsynchronized'])) {

                        /** Create the current register on the parallel system */
                        $new = $this->create($system, $table, $value);

                        /** Update the current register with the new ID */
                        $this->update(
                            $this->getCrossValue('system', $system),
                            $this->getCrossValue('table', $table),
                            $id,
                            $new
                        );
                    } else {
                        //$this->update($system, $table, $id, $value);
                    }
                }
            }
        }

        $this->read();
    }

    /** 
     * Change the potencial client to client
     * 
     * @param $client ID of the client on the customer table
     */
    private function convertClient($client)
    {
        $db = new DB('idempiere');

        if ( $db->connection->isConnected() ) {
            $db->connection->execute('UPDATE tm_customer_group SET id_group = 4 WHERE id_customer = $client');
        }

        $db->connection->close();
    }

    /**
     * Set date and time of the last synchronized on a register
     * 
     * @param string $system Name of system
     * @param string $table Name of table
     * @param string $row ID of register on the table
     */
    private function setSynchronized($system, $table, $row)
    {
        $db = new DB($system);

        if ( $db->connection->isConnected() ) {
            $date = ($system == 'idempiere') ? 'current_timestamp' : 'now()' ;

            $primary = $this->getUniqueKey($system, $table) ;

            $db->connection->execute('UPDATE ' . $table . ' SET lastsynchronized = ' . $date . ' WHERE ' . $primary . ' = ' . $row);
        }

        $db->connection->close();
    }

    /**
     * Get the name of the unique and primary key depends
     * of the table
     * 
     * @param string $system
     * @param string $table
     * 
     * @return string name of primary key
     */
    private function getUniqueKey($system, $table)
    {
        if ( $system == 'prestashop' ) {
            $table = explode($this->px, $table);
            $table = $table[1];
        }
        
        return ($system == 'prestashop') ? 'id_' . $table : $table . '_id';
    }

    /**
     * Get the name of the system, table or field on the 
     * parallel database
     * 
     * @param string $type Type of value
     * @param string $value
     * 
     * @return string Parallel name
     */
    private function getCrossValue($type, $value)
    {
        $systems = [
            'prestashop'    =>  'idempiere',
            'idempiere'     =>  'prestashop'
        ];

        $tables = [
            'ad_user'       =>  'tm_customer',
            'tm_customer'   =>  'ad_user',
            'c_location'    =>  'tm_address',
            'tm_address'    =>  'c_location'
        ];

        switch ($type) {
            case 'system':
                return $systems[$value];
                break;
            case 'table':
                return $tables[$value];
                break;
        }
    }
}
