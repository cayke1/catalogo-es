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
}
