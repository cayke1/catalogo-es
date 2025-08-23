<?php

class ProductController extends RenderView
{
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $title = $_POST['title'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';

            if (empty($title)) {
                echo json_encode(['success' => false, 'error' => 'Título é obrigatório']);
                exit;
            }

            if ($price <= 0) {
                echo json_encode(['success' => false, 'error' => 'Preço deve ser maior que zero']);
                exit;
            }

            //Lógica para adicionar upload de imagem
            if (isset($_FILES['image']) && $_FILES['image']["error"] === UPLOAD_ERR_OK) {
                $maxFileSize = 2 * 1024 *1024;
                if ($_FILES["image"]["size"] > $maxFileSize) {
                    echo json_encode(["success"=> false, "erro" => "Arquivo de imagem é muito grande. Tamanho máximo 2MB"]);
                    exit;
                }
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileMimeType = mime_content_type($_FILES['image']['tmp_name']);
                if (!in_array($fileMimeType, $allowedMimeTypes)) {
                    echo json_encode(["success" => false, "error" => "Tipo de arquivo inválido. Apenas imagens JPG, PNG e GIF são permitidas."]);
                    exit;
                }

                $uploadDir = __DIR__ . '/../../app/public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageFileName = uniqid() . '_' . basename($_FILES["image"]["name"]);
                $imagePath = $uploadDir . $imageFileName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                    $image_url = '/app/public/uploads/' . $imageFileName;
                } else {
                    echo json_encode(["success" => false, "error" => "Erro ao mover o arquivo de imagem."]);
                    exit;
                }
            }

            $productModel = new ProductModel();
            $productId = $productModel->createProduct($title, $price, $description);

            if ($productId) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao cadastrar produto']);
            }
            exit;
        }


        // Carregar a view apenas para GET
        $this->loadView('partials/header', ['title' => 'Add Product']);
        $this->loadView('add-product', []);
    }
    public function list()
    {
        $productModel = new ProductModel();
        $products = $productModel->listAll();

        // Carregar a view com os produtos
        $this->loadView('partials/header', ['title' => 'Lista de Produtos']);
        $this->loadView('partials/cards', ['title' => $products]);
    }
}
