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

    public function findById($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Products WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro em findById: " . $e->getMessage());
            throw new Exception("Erro ao buscar produto");
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE Products SET 
                    title = ?, 
                    price = ?, 
                    description = ?
                    WHERE id = ?";
                    
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                $data['title'],
                $data['price'],
                $data['description'],
                $id
            ]);
            
        } catch (PDOException $e) {
            error_log("Erro no update: " . $e->getMessage());
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
}
}
