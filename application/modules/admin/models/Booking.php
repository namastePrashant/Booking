<?php

class Admin_Model_Booking {

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
            $this->setDbTable('Admin_Model_DbTable_Booking');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $result = $this->getDbTable()->fetchAll("del='N'");
        return $result->toArray();
    }

    public function add($formData) {
        $data = $formData['extra_id'];
        unset($formData["extra_id"]);
        $lastId = $this->getDbTable()->insert($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        $arr = array();
        $extraBooking = new Admin_Model_Extrabooking();
        foreach ($data as $key => $val) {
            $arr['extra_id'] = $key;
            $arr['booking_id'] = $lastId;
            $extraBooking->add($arr);
        }
        return $lastId;
    }

    public function getDetailById($bookingId) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("b" => "booking"), array("b.*"))
                ->joinLeft(array("p" => "location"), "b.pickup_location=p.location_id", array("p.name as pickuplocation"))
                ->joinLeft(array("r" => "location"), "b.return_location=r.location_id", array("r.name as returnlocation"))
                ->where("b.booking_id=" . $bookingId);
        $results = $db->fetchAll($select);
        $result = array();
        if ($results) {
            $result = $results[0];
        }
        return $result;
    }

    public function getExtras($bookingId) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $extraSelect = $db->select();
        $extraSelect->from(array("eb" => "extra_booking"))
                ->joinLeft(array("e" => "extra"), "e.extra_id=eb.extra_id", array("e.*"))
                ->where("eb.booking_id=" . $bookingId);
        $extras = $db->fetchAll($extraSelect);
        return $extras;
    }

    public function update($formData, $bookingId) {
        $data = $formData['extra_id'];
        unset($formData["extra_id"]);
        $this->getDbTable()->update($formData, "booking_id='$bookingId'");
        $arr = array();
        $extraBooking = new Admin_Model_Extrabooking();
        $extraBooking->delete($bookingId);
        foreach ($data as $key => $val) {
            $arr['extra_id'] = $key;
            $arr['booking_id'] = $bookingId;
            $extraBooking->add($arr);
        }
        
    }

}

?>
