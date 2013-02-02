<?php

class Admin_Model_Extrabooking {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_Extrabooking');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $result = $this->getDbTable()->fetchAll();
        return $result->toArray();
    }

    public function add($formData) {
        $lastId = $this->getDbTable()->insert($formData);
        //var_dump($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function delete($bookingId) {
        $this->getDbTable()->delete("booking_id=" . $bookingId);
    }

    public function getAllbyBookingId($id) {
        $row = $this->getDbTable()->fetchAll("booking_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        $extraIds = array();
        if ($row) {
            foreach ($row->toArray() as $data) {
                $extraIds[$data['extra_id']] = $data['booking_id'];
            }
        }
        return $extraIds;
    }

}