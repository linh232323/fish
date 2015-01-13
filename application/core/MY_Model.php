<?php

class MY_Model extends CI_Model {

    protected $_table = '';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function setTableName($tablename) {
        $this->_table = $tablename;
    }

    function getTableName() {
        return $this->_table;
    }

    function mockItem() {
        $obj      = new stdClass;
        $a_fields = $this->db->list_fields($this->_table);

        foreach ($a_fields as $field) {
            $obj->$field = '';
        }
        return $obj;
    }

    function listTable() {
        $a_tables = $this->db->list_tables();
        return $a_tables;
    }

    //--- Lấy tất cả dữ liệu
    function getAllData($off = '', $limit = '') {
        $this->db->select('*');
        $this->db->from($this->_table);
        if ($limit != '' && $off != '') {
            $this->db->limit($off, $limit);
        }
        
        $query = $this->db->get();
        $data  = $query->result();
        return $data;
    }

    /**
     * Tổng số record
     * @return Int
     */
    function totalRows() {
        return $this->db->count_all($this->_table);
    }

    function add($a_data) {
        $this->db->insert($this->_table, $a_data);
        return TRUE;
    }

}

?>
