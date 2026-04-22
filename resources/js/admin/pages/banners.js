export function initBannerPages(page) {
    if (!page.startsWith('banners-')) {
        return;
    }

    const source = document.querySelector('[data-title-preview-source]');
    const target = document.querySelector('[data-title-preview]');

    if (!source || !target) {
        return;
    }

    const sync = () => {
        target.textContent = source.value.trim() || 'Tiêu đề banner';
    };

    source.addEventListener('input', sync);
    sync();
}
