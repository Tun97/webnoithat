const statusLabels = {
    pending: 'Chờ xử lý',
    shipping: 'Đang giao',
    completed: 'Hoàn tất',
    cancelled: 'Đã hủy',
};

export function initOrdersPages(page) {
    if (!page.startsWith('orders-')) {
        return;
    }

    if (page === 'orders-index') {
        const buttons = document.querySelectorAll('[data-status-filter]');
        const rows = document.querySelectorAll('[data-order-status]');

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const nextStatus = button.dataset.statusFilter ?? 'all';

                buttons.forEach((item) => item.classList.remove('is-active'));
                button.classList.add('is-active');

                rows.forEach((row) => {
                    row.dataset.statusVisible =
                        nextStatus === 'all' || row.dataset.orderStatus === nextStatus ? 'true' : 'false';
                });

                document.querySelector('[data-filter-input="orders"]')?.dispatchEvent(new Event('input'));
            });
        });
    }

    if (page === 'orders-show') {
        const select = document.querySelector('[data-status-select]');
        const display = document.querySelector('[data-status-display]');

        if (!select || !display) {
            return;
        }

        const sync = () => {
            display.textContent = statusLabels[select.value] ?? select.value;
            display.className = `badge status-${select.value}`;
        };

        select.addEventListener('change', sync);
        sync();
    }
}
