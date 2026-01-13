<?php
require_once('BaseModel.php');

class Product extends BaseModel {
    protected $table = 'products';

    public function allJoined() {
        return join_product_table();
    }

    public function create($data) {
        $p_name  = remove_junk($data['name']);
        $p_cat   = (int)$data['categorie_id'];
        $p_qty   = remove_junk($data['quantity']);
        $p_buy   = remove_junk($data['buy_price']);
        $p_sale  = remove_junk($data['sale_price']);
        $media_id = (int)$data['media_id'];
        $date    = make_date();

        $sql  = "INSERT INTO " . $this->table . " (name, quantity, buy_price, sale_price, categorie_id, media_id, date) ";
        $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?) ";
        $sql .= "ON DUPLICATE KEY UPDATE name = ?";
        
        return $this->db->query_prepared($sql, [$p_name, $p_qty, $p_buy, $p_sale, $p_cat, $media_id, $date, $p_name]);
    }

    public function update($id, $data) {
        $p_name  = remove_junk($data['name']);
        $p_cat   = (int)$data['categorie_id'];
        $p_qty   = remove_junk($data['quantity']);
        $p_buy   = remove_junk($data['buy_price']);
        $p_sale  = remove_junk($data['sale_price']);
        $media_id = (int)$data['media_id'];
        $id = (int)$id;

        $sql   = "UPDATE " . $this->table . " SET name = ?, quantity = ?, buy_price = ?, sale_price = ?, categorie_id = ?, media_id = ? ";
        $sql  .= "WHERE id = ?";
        
        return $this->db->query_prepared($sql, [$p_name, $p_qty, $p_buy, $p_sale, $p_cat, $media_id, $id]);
    }
}
