<?php

class Admin_Model_Location {

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
            $this->setDbTable('Admin_Model_DbTable_Location');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $result = $this->getDbTable()->fetchAll();
        return $result->toArray();
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
        $row = $this->getDbTable()->fetchRow("location_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }
     public function update($formData, $id) {
        $this->getDbTable()->update($formData, "location_id='$id'");
    }
     public function delete($id) {
       
            $this->getDbTable()->delete("location_id='$id'");
       
    }
    public function getAllLocation()
    {
        $all = $this->getDbTable()->fetchAll();
        $arr = array();
        foreach($all as $data){
            $arr[$data->location_id] = $data->name;
        }
        return $arr;
    }
}

?>
