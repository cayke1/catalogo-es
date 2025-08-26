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
            $image_url = null;

            if (empty($title)) {
                echo json_encode(['success' => false, 'error' => 'Título é obrigatório']);
                exit;
            }

            if ($price <= 0) {
                echo json_encode(['success' => false, 'error' => 'Preço deve ser maior que zero']);
                exit;
            }

            // Handle image upload
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {

                $maxFileSize = 2 * 1024 * 1024;
                if ($_FILES["image"]["size"] > $maxFileSize) {
                    echo json_encode(["success" => false, "error" => "O arquivo de imagem é muito grande. O tamanho máximo permitido é 2MB."]);
                    exit;
                }

                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileMimeType = mime_content_type($_FILES["image"]["tmp_name"]); 

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
            $productId = $productModel->createProduct($title, $price, $description, $image_url);

            if ($productId) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao cadastrar produto']);
            }
            exit;
        }

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


    public function edit($id){


        try {
            if (!is_numeric($id)) {
                $_SESSION['error'] = "ID inválido";
                header('Location:/debug');
                exit;
            }
            
            $productModel = new ProductModel();
            $product = $productModel->findById($id);
            
            if (!$product) {
                $_SESSION['error'] = "Produto não encontrado";
                header('Location:/add-product');
                exit;
            }
            
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
        
        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = "Nome é obrigatório";
        } else {
            $product['title'] = trim($data['title']);
        }
        
        if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = "Preço deve ser um número maior que zero";
        } else {
            $product['price'] = floatval($data['price']);
        }
        
        $product['description'] = trim($data['description'] ?? '');
        
        return [
            'product' => $product,
            'errors' => $errors
        ];
    }

    public function update($id) {

        try {

            if (!is_numeric($id)) {
                $_SESSION['error'] = "ID inválido";
                header('Location: /idinvalido');
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /edit-product/' . $id);
                exit;
            }
            
            $productModel = new ProductModel();
            $currentProduct = $productModel->findById($id);

            if (!$currentProduct) {
                $_SESSION['error'] = "Produto não encontrado";
                header('Location: /notfound');
                exit;
            }
            

            $data  = $this->validateProductData($_POST);
            
            if (empty($data['errors'])) {

                $success = $productModel->update($id, $data['product']);
                
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
            header('Location: /error-exception/' . $e->getMessage());
        }

        exit;
    }


}
