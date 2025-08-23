<?php
class ProductModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function createProduct($title, $price, $description, $image_url = null)
    {
        $stmt = $this->pdo->prepare("INSERT INTO Products (title, price, description, image_url) VALUES (:title, :price, :description, :image_url)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $image_url);

        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateProductImage($productId, $image_url)
    {
        $stmt = $this->pdo->prepare("UPDATE Products SET image_url = :image_url WHERE id = :id");
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':id', $productId);
        return $stmt->execute();
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
}