<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnalysisController extends CI_Controller{
    
    function index(){
        $this->load->model('AnalysisModel');
        
        $data['product_count'] = $this->AnalysisModel->getProductCount();
        $data['sell_count'] = $this->AnalysisModel->getSellsCount();
        
        // Original product-wise sales (kept for reference, if needed)
        $productSales = $this->AnalysisModel->getProductWiseSales();
        arsort($productSales);
        $data['product_names'] = json_encode(array_keys($productSales));
        $data['sales_values'] = json_encode(array_values($productSales));
        
        // New: Get month-wise sales data using the 'created_at' column
        $monthlySales = $this->AnalysisModel->getMonthlySales();
        $data['month_names'] = json_encode(array_keys($monthlySales));
        $data['month_sales'] = json_encode(array_values($monthlySales));
        
        // Get product stock stats
        $stockStats = $this->AnalysisModel->getProductStockStats();
        $data['product_stock_names'] = json_encode($stockStats['names']);
        $data['product_stock_quantities'] = json_encode($stockStats['quantities']);
        
        $this->load->view('Analysis', $data);
    }
}
?>
