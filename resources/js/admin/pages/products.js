export function initProductPages(page) {
    if (!page.startsWith('products-')) {
        return;
    }

    if (page === 'products-index') {
        document.querySelectorAll('[data-stock-value]').forEach((row) => {
            const quantity = Number(row.dataset.stockValue ?? 0);

            if (!Number.isNaN(quantity) && quantity <= 5) {
                row.classList.add('is-low-stock');
            }
        });
    }

    if (page === 'products-create' || page === 'products-edit') {
        initProductImagePreview();
    }
}

function initProductImagePreview() {
    const input = document.querySelector('[data-product-images-input]');
    const preview = document.querySelector('[data-product-images-preview]');

    if (!input || !preview) {
        return;
    }

    const defaultMarkup = preview.innerHTML;
    let objectUrls = [];

    const clearObjectUrls = () => {
        objectUrls.forEach((url) => URL.revokeObjectURL(url));
        objectUrls = [];
    };

    const restoreDefault = () => {
        clearObjectUrls();
        preview.innerHTML = defaultMarkup;
    };

    input.addEventListener('change', () => {
        const files = Array.from(input.files ?? []);

        if (files.length === 0) {
            restoreDefault();
            return;
        }

        clearObjectUrls();
        preview.innerHTML = '';

        files.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            objectUrls.push(url);

            const card = document.createElement('article');
            card.className = 'product-image-preview-card';

            const image = document.createElement('img');
            image.src = url;
            image.alt = file.name;

            const badge = document.createElement('span');
            badge.textContent = index === 0 ? 'Ảnh đại diện' : `Ảnh ${index + 1}`;

            const name = document.createElement('small');
            name.textContent = file.name;

            card.append(image, badge, name);
            preview.appendChild(card);
        });
    });
}
