const formatValue = (value, kind) => {
    if (kind === 'currency') {
        return `${new Intl.NumberFormat('vi-VN').format(value)} đ`;
    }

    return new Intl.NumberFormat('vi-VN').format(value);
};

export function initDashboardPage(page) {
    if (page !== 'dashboard-index') {
        return;
    }

    document.querySelectorAll('[data-stat-card]').forEach((card) => {
        const strong = card.querySelector('strong');
        const value = Number(card.dataset.statValue ?? 0);
        const kind = card.dataset.statKind ?? 'number';

        if (!strong || Number.isNaN(value)) {
            return;
        }

        let current = 0;
        const increment = Math.max(1, Math.ceil(value / 28));

        const tick = () => {
            current = Math.min(value, current + increment);
            strong.textContent = formatValue(current, kind);

            if (current < value) {
                window.requestAnimationFrame(tick);
            }
        };

        tick();
    });
}
