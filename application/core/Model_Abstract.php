<?php

class Model_Abstract extends MY_Model {
    public $_data;
    
    
    function __construct() {
        parent::__construct();
    }
    function load($id){
         $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        if ($query && $row = $query->row()){            
            $this->setData((array)$row);
            return $this;
        }   
        else {
            return false;
        }
        
    }
    //--- Lấy tất cả dữ liệu
    function getAllData($off = '', $limit = '') {
        $this->db->select('*');
        $this->db->from($this->_table);
        if ($limit != '' && $off != '') {
            $this->db->limit($off, $limit);
        }        
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }

   

    /**
     * Tổng số record
     * @return Int
     */
    function totalRows() {
        return $this->db->count_all($this->_table);
    }

    /**
     * Thêm mới user
     * @param Array $data
     * @return boolean
     */
    function add($data = array()) {
        if (!empty($data)) {
            if ($this->db->insert($this->_table, $data)){
                $id = $this->db->insert_id(); 
                $this->_data['id'] = $id;
                return $id;
            }
            else
                return FALSE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Xóa user 
     * @param Int $userid
     */
    function delete($id = '') {
        if ($loc_id != '') {
            $this->db->where_in('id', $id);
            if ($this->db->delete($this->_table)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Cập nhật thông tin user
     * @param Array $data
     * @param Int $userid
     * @return boolean
     */
    function update($data = array(), $id = '') {
        if (!empty($data) && $id != '' && is_numeric($id)) {
            $this->db->where('id', $id);
            if ($this->db->update($this->_table, $data))
                return $id;
            else
                return FALSE;
        }
        else {
            return FALSE;
        }
    }
    
    public function save(){
        if(isset($this->_data['id']))
            return $this->update($this->_data,$this->_data['id']);
        else
            return $this->add($this->_data);
    }
    
    public function setData($data){
        if(isset($this->_data ))
            $this->_data = array();
        
        $this->_data = $data;
    }
    
    public function getData(){
        return $this->_data;
    }
    
    public function setValue($key, $value){
        if(!isset($this->_data ))
            $this->_data = array();
        
        $this->_data[$key] = $value;
    }
}

?>
