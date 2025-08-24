function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                document.querySelector('.image-upload-area').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('image-input').value = '';
        document.getElementById('image-preview').classList.add('hidden');
        document.querySelector('.image-upload-area').style.display = 'block';
    }

     const form = document.querySelector('.form-container');
    const notificationArea = document.getElementById('notification-area');

    function showNotification(message, type = "success") {
        const div = document.createElement("div");
        div.className = type === "success" ? "success-message" : "error-message";
        div.textContent = message;
        notificationArea.innerHTML = "";
        notificationArea.appendChild(div);

        setTimeout(() => div.remove(), 3000);
    }

    async function handleSubmitProduct(e) {
        e.preventDefault();

        const title = document.getElementById('title').value.trim();
        const priceInput = document.getElementById('price').value.trim();
        const description = document.getElementById('description').value.trim();
        const image = document.getElementById('image-input').files[0];


        if (!title) {
            return showNotification("Nome do produto é obrigatório", "error");
        }


        const priceRegex = /^\d+(\.\d{1,2})?$/;
        if (!priceRegex.test(priceInput)) {
            return showNotification("Preço inválido. Use apenas números e ponto (ex: 19.90)", "error");
        }

        const price = parseFloat(priceInput);
        if (isNaN(price) || price <= 0) {
            return showNotification("Preço deve ser maior que zero", "error");
        }


        const formData = new FormData();
        formData.append('title', title);
        formData.append('price', price.toFixed(2)); 
        formData.append('description', description);
        if (image) formData.append('image', image);

        try {
            const res = await fetch('/update-product', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                showNotification("Produto cadastrado com sucesso!", "success");
                form.reset();
                removeImage();
            } else {
                showNotification(data.error || "Erro ao cadastrar produto", "error");
            }
        } catch (err) {
            showNotification("Falha na comunicação com o servidor", "error");
        }
    }

    form.addEventListener('submit', handleSubmitProduct);