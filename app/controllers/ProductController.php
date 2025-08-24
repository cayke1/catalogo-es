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

    public function debug(){
        $this->loadView('debug', []);
    }

    // private function getIdFromUri($prefix = '/edit-product/'){

    //     $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    //     $id = str_replace($prefix, '', $uri);

    //     return (int)$id; // força ser int
    // }


    public function edit($id){

        // $id = $this->getIdFromUri('/edit-product/');

        try {
        // Validar se ID é numérico
            if (!is_numeric($id)) {
                $_SESSION['error'] = "ID inválido";
                header('Location:/debug');
                exit;
            }
            
            // Buscar produto no banco
            $productModel = new ProductModel();
            $product = $productModel->findById($id);
            
            // Verificar se produto existe
            if (!$product) {
                $_SESSION['error'] = "Produto não encontrado";
                header('Location:/add-product');
                exit;
            }
            
            // Carregar view com dados do produto
            $this->loadView('partials/header', ['title' => 'edit Product']);
            $this->loadView('edit-product', ['product' => $product]);
        
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao buscar produto: " . $e->getMessage();
            header('Location:/sa');
            exit;
        }
    }

    private function validateProductData($data) {
        $errors = [];
        $product = [];
        
        // Validar nome
        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = "Nome é obrigatório";
        } else {
            $product['title'] = trim($data['title']);
        }
        
        // Validar preço
        if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = "Preço deve ser um número maior que zero";
        } else {
            $product['price'] = floatval($data['price']);
        }
        
        // Validar descrição (se houver)
        $product['description'] = trim($data['description'] ?? '');
        
        return [
            'product' => $product,
            'errors' => $errors
        ];
    }

    public function update($id) {

        // $id = $this->getIdFromUri('/edit-product/');
        try {

            if (!is_numeric($id)) {
                $_SESSION['error'] = "ID inválido";
                header('Location: /idinvalido');
                exit;
            }
            
            // Verificar se é POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /edit-product/' . $id);
                exit;
            }
            
            // Buscar produto atual
            $productModel = new ProductModel();
            $currentProduct = $productModel->findById($id);

            if (!$currentProduct) {
                $_SESSION['error'] = "Produto não encontrado";
                header('Location: /notfound');
                exit;
            }
            
            // Validar dados do formulário
            $data  = $this->validateProductData($_POST);
            
            if (empty($data['errors'])) {

                // Atualizar produto
                $success = $productModel->update($id, $data['Products']);
                
                if ($success) {
                    $_SESSION['success'] = "Produto atualizado com sucesso!";
                    header('Location: /');
                } else {
                    $_SESSION['error'] = "Erro ao atualizar produto";
                    header('Location: /edit-product/' . $id);
                }
            } else {
                $_SESSION['errors'] = $data['errors'];
                $_SESSION['old_input'] = $_POST;
                header('Location: /edit/' . $id);
            }
        
        } catch (Exception $e) {
            $_SESSION['error'] = "Erro ao atualizar produto: " . $e->getMessage();
            header('Location: /erro-exception/' . $id);
        }

        exit;
    }


}
