<?php
abstract class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function all() {
        $sql = "SELECT * FROM " . $this->table;
        return find_by_sql($sql);
    }

    public function find($id) {
        return find_by_id($this->table, $id);
    }

    public function delete($id) {
        return delete_by_id($this->table, $id);
    }

    public function count() {
        return count_by_id($this->table);
    }
}
