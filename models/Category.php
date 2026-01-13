<?php
require_once('BaseModel.php');

class Category extends BaseModel {
    protected $table = 'categories';

    public function create($name) {
        $name = remove_junk($name);
        $sql  = "INSERT INTO " . $this->table . " (name) VALUES (?)";
        return $this->db->query_prepared($sql, [$name]);
    }

    public function update($id, $name) {
        $name = remove_junk($name);
        $id = (int)$id;
        $sql = "UPDATE " . $this->table . " SET name = ? WHERE id = ?";
        return $this->db->query_prepared($sql, [$name, $id]);
    }
}
