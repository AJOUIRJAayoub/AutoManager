<?php
class Piece {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $sql = "SELECT p.*, c.nom AS categorie FROM pieces p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM pieces WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nom, $description, $prix, $stock, $category_id) {
        $stmt = $this->db->prepare("INSERT INTO pieces (nom, description, prix, stock, category_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $description, $prix, $stock, $category_id]);
    }

    public function update($id, $nom, $description, $prix, $stock, $category_id) {
        $stmt = $this->db->prepare("UPDATE pieces SET nom=?, description=?, prix=?, stock=?, category_id=? WHERE id=?");
        return $stmt->execute([$nom, $description, $prix, $stock, $category_id, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM pieces WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
