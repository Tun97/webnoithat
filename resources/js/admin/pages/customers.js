export function initCustomersPages(page) {
    if (!page.startsWith('customers-')) {
        return;
    }

    const search = document.querySelector('[data-filter-input="customers"]');

    if (page === 'customers-index' && search) {
        search.focus({ preventScroll: true });
    }
}
