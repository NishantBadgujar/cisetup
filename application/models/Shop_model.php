<?php
class Shop_model extends CI_Model {

    public function get_all_shops() {
        return $this->db->get('shops')->result_array();
    }

    public function insert_shop($data) {
        return $this->db->insert('shops', $data);
    }

    public function get_shop_by_id($id) {
        return $this->db->get_where('shops', array('id' => $id))->row_array();
    }

    public function update_shop($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('shops', $data);
    }

    public function delete_shop($id) {
        return $this->db->delete('shops', array('id' => $id));
    }
    

    public function get_shop_inventory() {
        $this->db->select('shop_code, item_name, quantity');
        $this->db->from('shop_inventory');
        $this->db->order_by('shop_code', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    
}
public function shop_code_exists($shop_code) {
    $this->db->where('shop_code', $shop_code);
    $query = $this->db->get('shops');
    return $query->num_rows() > 0;
}

public function get_shop_by_code($shop_code) {
    return $this->db->get_where('shops', ['shop_code' => $shop_code])->row();
}
}
