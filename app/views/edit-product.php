<div class="container">
    <div id="notification-area"></div>

    <form class="form-container" action="/update-product/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" id="productForm">
        <h2 class="form-title">Editar Produto <?php echo $product['title'] ?></h2>


        <div class="form-group">
            <label for="tile" class="form-label">Novo nome para <?php echo $product['title'] ?> *</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-input"
                placeholder="Digite o nome do produto"
                value="<?= htmlspecialchars($product['title']) ?>"
                required>
        </div>


        <div class="form-group">
            <label for="price" class="form-label">Preço *</label>
            <input
                type="number"
                id="price"
                name="price"
                class="form-input"
                placeholder="0,00"
                min="0"
                step="0.01"
                value="<?= htmlspecialchars($product['price']) ?>"
                required
                >
        </div>


        <div class="form-group">
            <label for="description" class="form-label">Descrição</label>
            <textarea
                id="description"
                name="description"
                class="form-textarea"
                placeholder="Descreva o produto..."
                rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>


        <div class="form-group">
            <label class="form-label">Imagem do Produto</label>

            <div class="image-upload-area" onclick="document.getElementById('image-input').click()">
                <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="upload-text">Clique para selecionar uma imagem</p>
                <p class="upload-subtext">PNG, JPG, GIF até 10MB</p>
            </div>

            <input
                type="file"
                id="image-input"
                name="image"
                accept="image/*"
                class="file-input hidden"
                onchange="previewImage(this)">

            <div id="image-preview" class="image-preview hidden">
                <img id="preview-img" class="preview-image" src="" alt="Preview">
                <button type="button" class="remove-image-btn" onclick="removeImage()">
                    <!-- Ícone X SVG -->
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="button-group">
            <a href="/" class="btn btn-secondary">Cancelar</a>
            <button href="/update-product/"<?= $product['id']?> id="submit_btn" type="submit" class="btn btn-primary">Atualizar Produto</button>
        </div>
    </form>
</div>

<!-- <script src="/app/public/js/edit-product.js"></script> -->