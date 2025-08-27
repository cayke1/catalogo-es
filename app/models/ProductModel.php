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

    private function deleteImageFile($image_url) {
        if (!empty($image_url)) {
            $imagePath = __DIR__ . '/../../' . ltrim($image_url, '/');
            
            if (file_exists($imagePath)) {
                return unlink($imagePath);
            }
        }
        return true; 
    }

    public function update($id, $data) {
        try {
            if (isset($data['image_url'])) {
                $currentProduct = $this->findById($id);
                if ($currentProduct && !empty($currentProduct['image_url'])) {
                    $this->deleteImageFile($currentProduct['image_url']);
                }
                
                // Atualiza com a nova imagem
                $sql = "UPDATE Products SET 
                        title = ?, 
                        price = ?, 
                        description = ?,
                        image_url = ?
                        WHERE id = ?";
                        
                $stmt = $this->pdo->prepare($sql);
                
                return $stmt->execute([
                    $data['title'],
                    $data['price'],
                    $data['description'],
                    $data['image_url'],
                    $id
                ]);
            } else {
                // Atualiza sem modificar a imagem
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
            }
            
        } catch (PDOException $e) {
            error_log("Erro no update: " . $e->getMessage());
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $product = $this->findById($id);
            
            if ($product) {
                if (!empty($product['image_url'])) {
                    $this->deleteImageFile($product['image_url']);
                }
                
                $stmt = $this->pdo->prepare("DELETE FROM Products WHERE id = ?");
                return $stmt->execute([$id]);
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Erro no delete: " . $e->getMessage());
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }
}