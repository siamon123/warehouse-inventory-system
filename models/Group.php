<?php
require_once('BaseModel.php');

class Group extends BaseModel {
    protected $table = 'user_groups';

    public function findByName($name) {
        $sql = "SELECT group_name FROM {$this->table} WHERE group_name = ? LIMIT 1";
        $stmt = $this->db->query_prepared($sql, [$name]);
        return $this->db->fetch_assoc($stmt);
    }

    public function findByLevel($level) {
        $sql = "SELECT group_level FROM {$this->table} WHERE group_level = ? LIMIT 1";
        $stmt = $this->db->query_prepared($sql, [$level]);
        return $this->db->fetch_assoc($stmt);
    }

    public function create($name, $level, $status) {
        $name = remove_junk($name);
        $level = (int)$level;
        $status = (int)$status;
        $sql  = "INSERT INTO " . $this->table . " (group_name, group_level, group_status) VALUES (?, ?, ?)";
        return $this->db->query_prepared($sql, [$name, $level, $status]);
    }

    public function update($id, $name, $level, $status) {
        $name = remove_junk($name);
        $level = (int)$level;
        $status = (int)$status;
        $id = (int)$id;
        $sql = "UPDATE " . $this->table . " SET group_name = ?, group_level = ?, group_status = ? WHERE id = ?";
        return $this->db->query_prepared($sql, [$name, $level, $status, $id]);
    }
}
