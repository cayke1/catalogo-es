<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['title'] ?> - Catálogo ES</title>
    <link rel="stylesheet" href="/css/globals.css">
    <style>
        .product-details {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .back-link:hover {
            background: #0056b3;
        }

        .product-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        .product-image {
            width: 100%;
            height: 400px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #6c757d;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .product-price {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
            margin: 0;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }

        .product-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: #888;
        }

        @media (max-width: 768px) {
            .product-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .product-title {
                font-size: 2rem;
            }

            .product-price {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="product-details">
        <div class="product-header">
            <h1>Detalhes do Produto</h1>
            <a href="/" class="back-link">
                ← Voltar à listagem
            </a>
        </div>

        <div class="product-content">
            <div class="product-image">
                📦
            </div>

            <div class="product-info">
                <h2 class="product-title"><?= htmlspecialchars($product['title']) ?></h2>

                <p class="product-price">
                    R$ <?= number_format($product['price'], 2, ',', '.') ?>
                </p>

                <div class="product-description">
                    <?= htmlspecialchars($product['description']) ?>
                </div>

                <div class="product-meta">
                    <span>ID: <?= $product['id'] ?></span>
                    <span>•</span>
                    <span>Criado em: <?= date('d/m/Y H:i', strtotime($product['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>