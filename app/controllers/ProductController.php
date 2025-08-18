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
