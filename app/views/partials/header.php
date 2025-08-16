<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    <?php echo $title; ?>
  </title>
  <link rel="stylesheet" href="/app/public/css/globals.css">
    
</head>

<?php
$current_page = $_SERVER['REQUEST_URI'];
$base_url = '/';

function isActive($path, $current) {
    return $current === $path ? 'active' : '';
} 
?>

<header class="header">
        <div class="header-content">
            <a href="<?php echo $base_url; ?>" class="logo-section">
                <svg class="logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"></path>
                </svg>
                <h1 class="logo-text">Catálogo</h1>
            </a>
        
            <nav class="nav-desktop">
                <a href="<?php echo $base_url; ?>list-products" class="nav-link <?php echo isActive('/list-products', $current_page); ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>Produtos</span>
                </a>
                <a href="<?php echo $base_url; ?>add-product" class="nav-link <?php echo isActive('/add-product', $current_page); ?>">
                    <!-- Ícone Plus (SVG) -->
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Adicionar</span>
                </a>
            </nav>
            <div class="nav-mobile">
                <a href="<?php echo $base_url; ?>list-products" class="nav-mobile-link <?php echo isActive('/list-products', $current_page); ?>">
                    <svg class="nav-mobile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </a>
                <a href="<?php echo $base_url; ?>add-product" class="nav-mobile-link <?php echo isActive('/add-product', $current_page); ?>">
                    <svg class="nav-mobile-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
        </div>
</header>