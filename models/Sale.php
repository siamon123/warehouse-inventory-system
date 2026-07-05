<?php
require_once('BaseModel.php');

class Sale extends BaseModel {
    protected $table = 'sales';

    public function allJoined() {
        return find_all_sale();
    }

    public function create($data) {
        $p_id    = (int)$data['product_id'];
        $s_qty   = (int)$data['qty'];
        $s_total = $data['price'];
        $s_date  = $data['date'];

        $sql  = "INSERT INTO " . $this->table . " (product_id, qty, price, date) VALUES (?, ?, ?, ?)";

        if ($this->db->query_prepared($sql, [$p_id, $s_qty, $s_total, $s_date])) {
            update_product_qty($s_qty, $p_id);
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $p_id    = (int)$data['product_id'];
        $s_qty   = (int)$data['qty'];
        $s_total = $data['price'];
        $s_date  = $data['date'];
        $id      = (int)$id;

        $sql  = "UPDATE " . $this->table . " SET product_id = ?, qty = ?, price = ?, date = ? WHERE id = ?";

        if ($this->db->query_prepared($sql, [$p_id, $s_qty, $s_total, $s_date, $id])) {
            update_product_qty($s_qty, $p_id);
            return true;
        }
        return false;
    }

    public function daily($year, $month) {
        return dailySales($year, $month);
    }

    public function monthly($year) {
        return monthlySales($year);
    }
}
