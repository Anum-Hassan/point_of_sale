<?php
class SaleItemModel extends CI_Model {
    public function get_all_sales() {
        return $this->db->select('sales_items.*, products.name as product_name')
            ->from('sales_items')
            ->join('products', 'sales_items.product_id = products.id')
            ->get()
            ->result();
    }

    public function insert_sale($data) {
        $this->db->insert('sales_items', $data);
        $this->db->set('qty', 'qty - ' . (int)$data['quantity'], FALSE)
            ->where('id', $data['product_id'])
            ->update('products');
    }

    public function update_sale($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sales_items', $data);
    }
}
