export function initCategoriesPages(page) {
    if (!page.startsWith('categories-')) {
        return;
    }

    const search = document.querySelector('[data-filter-input="categories"]');

    if (page === 'categories-index' && search) {
        search.focus({ preventScroll: true });
    }
}
