<?php
class ProductModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function createProduct($title, $price, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO Products (title, price, description) VALUES (:title, :price, :description)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        
        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }
    }
    public function listAll()
    {
        $query = $this->pdo->query("SELECT * FROM Products ORDER BY id DESC");
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}
