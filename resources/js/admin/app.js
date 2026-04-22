import '../bootstrap';

import {
    initAutosizeTextareas,
    initFlashMessages,
    initImagePreviews,
    initSidebar,
    initSlugForms,
    initTableFilters,
} from './modules/ui';
import { initCategoriesPages } from './pages/categories';
import { initCustomersPages } from './pages/customers';
import { initDashboardPage } from './pages/dashboard';
import { initOrdersPages } from './pages/orders';
import { initProductPages } from './pages/products';

document.addEventListener('DOMContentLoaded', () => {
    const page = document.body.dataset.adminPage ?? '';

    initSidebar();
    initFlashMessages();
    initTableFilters();
    initAutosizeTextareas();
    initSlugForms();
    initImagePreviews();

    initDashboardPage(page);
    initCategoriesPages(page);
    initProductPages(page);
    initOrdersPages(page);
    initCustomersPages(page);
});
