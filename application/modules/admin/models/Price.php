<?php

class Admin_Model_Price {

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
            $this->setDbTable('Admin_Model_DbTable_Price');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("p" => "price"), array("p.*"))
                ->joinLeft(array("l" => "location"), "p.from_location_id=l.location_id", array("l.name as from_location"))
                ->joinLeft(array("k" => "location"), "p.to_location_id=k.location_id", array("k.name as to_location"));

        $result = $db->fetchAll($select);
        return $result;
    }

    public function add($formData) {
        $lastId = $this->getDbTable()->insert($formData);
        var_dump($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("price_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function update($formData, $id) {
        $this->getDbTable()->update($formData, "price_id='$id'");
    }

    public function delete($id) {

        $this->getDbTable()->delete("price_id='$id'");
    }

    public function getAllLocation($from = null) {
        if (!$from) {
            $locationId = "from_location_id";
        } else {
            $locationId = "to_location_id";
        }
        $sql = "SELECT distinct(p.$locationId) as location_id, l.name  from price as p left join location as l on p.$locationId=l.location_id where 1";
        $db = Zend_DB_Table::getDefaultAdapter();
        $results = $db->fetchAll($sql);
        $arr = array("" => "--Select--");
        foreach ($results as $result) {
            $arr[$result['location_id']] = $result['name'];
        }
        return $arr;
    }

     public function getPrice($pickup,$return) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("ur" => "price"), array("ur.*"))
                ->where("ur.from_location_id='$pickup' AND ur.to_location_id='$return'");
        $results = $db->fetchAll($select);
        return $results;
    }

}

?>
