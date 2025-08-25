<link rel="stylesheet" href="/app/public/css/Cards.css">
<section class="grid" aria-label="Lista de produtos">
  <?php foreach($title as $item){ ;?>
      <article class="card" tabindex="0">
        <div class="thumb" aria-hidden="true">Imagem do produto</div>
        <div class="content">
          <h2 class="name"><?php echo $item['title'];?></h2>
          <p class="description"><?php echo $item['description'];?></p>
          <div class="price">$ <?php echo number_format($item['price'], 2, ',', '.'); ?></div>
        </div>
        <div class="actions">
          <a href="#" class="btn btn--ghost" aria-label="Editar Camiseta Essential">
          <div class="icon edit-icon">
          <svg viewBox="0 0 24 24">
          <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
          </svg>
          </div>Editar</a>
          <a href="/product/<?= $item['id'] ?>" class="btn" aria-label="Ver detalhes de <?= htmlspecialchars($item['title']) ?>">
            <div class="icon details-icon">
            <svg viewBox="0 0 24 24">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
            </svg>
          </div>Detalhes</a>
          <a href="#" class="btn btn--danger" aria-label="Remover Camiseta Essential">
            <div class="icon remove-icon">
            <svg viewBox="0 0 24 24">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
            </svg>
          </div>Remover</a>
        </div>
      </article>
  <?php }?>