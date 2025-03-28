<?php
class AnalysisModel extends CI_Model {

    public function getProductCount() {
        $shop_code = $this->session->userdata('shop_code'); // logged-in shop code
        $this->db->where('shop_code', $shop_code);
        return $this->db->count_all_results('shop_inventory');
    }

    public function getSellsCount() {
        $shop_code = $this->session->userdata('shop_code');
        $this->db->where('shop_code', $shop_code);
        return $this->db->count_all_results('generated_bills');
    }

    public function getProductWiseSales() {
        $shop_code = $this->session->userdata('shop_code');
        $this->db->select('items');
        $this->db->where('shop_code', $shop_code);
        $query = $this->db->get('generated_bills');
        $results = $query->result_array();
    
        $productSales = array();
    
        foreach ($results as $row) {
            $items = json_decode($row['items'], true);
            if ($items && is_array($items)) {
                foreach ($items as $item) {
                    $productName = $item['name'];
                    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                    if (!isset($productSales[$productName])) {
                        $productSales[$productName] = 0;
                    }
                    $productSales[$productName] += $quantity;
                }
            }
        }
        return $productSales;
    }

    public function getStockStats() {
        $shop_code = $this->session->userdata('shop_code');
        $this->db->where('shop_code', $shop_code);
        $this->db->where('quantity >', 0);
        $in_stock = $this->db->count_all_results('shop_inventory');
    
        $this->db->reset_query();
        
        $this->db->where('shop_code', $shop_code);
        $this->db->where('quantity', 0);
        $out_stock = $this->db->count_all_results('shop_inventory');
    
        return ['in_stock' => $in_stock, 'out_stock' => $out_stock];
    }

    public function getProductStockStats() {
        $shop_code = $this->session->userdata('shop_code');
        $this->db->select('item_name, quantity');
        $this->db->where('shop_code', $shop_code);
        $query = $this->db->get('shop_inventory');
        $results = $query->result_array();
    
        $names = array();
        $quantities = array();
        
        foreach ($results as $row) {
            $names[] = $row['item_name'];
            $quantities[] = (int)$row['quantity'];
        }
        
        return ['names' => $names, 'quantities' => $quantities];
    }
    
    // New method: Group sales by month using the 'created_at' column
    public function getMonthlySales() {
        $shop_code = $this->session->userdata('shop_code');
        $this->db->select('items, created_at');
        $this->db->where('shop_code', $shop_code);
        $query = $this->db->get('generated_bills');
        $results = $query->result_array();
    
        // Initialize an array for all months (using abbreviated month names)
        $monthlySales = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
        ];
    
        foreach ($results as $row) {
            $createdAt = $row['created_at'];
            // Get abbreviated month name (e.g., Jan, Feb)
            $month = date('M', strtotime($createdAt));
    
            // Decode JSON string stored in 'items'
            $items = json_decode($row['items'], true);
            if ($items && is_array($items)) {
                foreach ($items as $item) {
                    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                    if (isset($monthlySales[$month])) {
                        $monthlySales[$month] += $quantity;
                    }
                }
            }
        }
        return $monthlySales;
    }
}
?>
