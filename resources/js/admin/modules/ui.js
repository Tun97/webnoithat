const slugify = (value) =>
    value
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

export function initSidebar() {
    const toggle = document.querySelector('[data-sidebar-toggle]');

    if (!toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isOpen = document.body.classList.toggle('sidebar-open');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });
}

export function initFlashMessages() {
    document.querySelectorAll('[data-flash-dismiss]').forEach((button) => {
        button.addEventListener('click', () => {
            button.closest('[data-flash-message]')?.remove();
        });
    });
}

export function initTableFilters() {
    document.querySelectorAll('[data-filter-input]').forEach((input) => {
        const key = input.getAttribute('data-filter-input');
        const body = document.querySelector(`[data-filter-body="${key}"]`);
        const count = document.querySelector(`[data-filter-count="${key}"]`);
        const empty = document.querySelector(`[data-filter-empty="${key}"]`);

        if (!body) {
            return;
        }

        const rows = Array.from(body.querySelectorAll('[data-filter-row]'));

        const refresh = () => {
            const query = input.value.trim().toLowerCase();
            const visibleRows = rows.filter((row) => row.style.display !== 'none');
            const matchedRows = query
                ? visibleRows.filter((row) => row.textContent.toLowerCase().includes(query))
                : visibleRows;

            rows.forEach((row) => {
                const matchesStatus = row.dataset.statusVisible !== 'false';
                const matchesQuery = !query || row.textContent.toLowerCase().includes(query);
                row.hidden = !(matchesStatus && matchesQuery);
            });

            const visibleCount = rows.filter((row) => !row.hidden).length;

            if (count) {
                count.textContent = String(visibleCount);
            }

            if (empty) {
                empty.hidden = visibleCount !== 0;
            }
        };

        input.addEventListener('input', refresh);
        refresh();
    });
}

export function initAutosizeTextareas() {
    document.querySelectorAll('[data-autosize]').forEach((textarea) => {
        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = `${textarea.scrollHeight}px`;
        };

        textarea.addEventListener('input', resize);
        resize();
    });
}

export function initSlugForms() {
    document.querySelectorAll('[data-slug-form]').forEach((form) => {
        const source = form.querySelector('[data-slug-source]');
        const target = form.querySelector('[data-slug-target]');
        const preview = document.querySelector('[data-slug-preview]');

        if (!source || !target) {
            return;
        }

        let manualEdit = target.value.trim().length > 0;

        const updatePreview = () => {
            if (preview) {
                preview.textContent = target.value.trim() || 'slug-du-kien';
            }
        };

        const syncSlug = () => {
            if (manualEdit) {
                updatePreview();
                return;
            }

            target.value = slugify(source.value);
            updatePreview();
        };

        source.addEventListener('input', syncSlug);
        target.addEventListener('input', () => {
            manualEdit = true;
            updatePreview();
        });

        syncSlug();
    });
}

export function initImagePreviews() {
    document.querySelectorAll('[data-image-preview-wrapper]').forEach((wrapper) => {
        const input = document.querySelector('[data-image-input]');
        const image = wrapper.querySelector('[data-image-preview]');
        const placeholder = wrapper.querySelector('[data-image-placeholder]');

        if (!input || !image) {
            return;
        }

        const fallbackSource = image.dataset.defaultSrc;

        const showDefault = () => {
            if (fallbackSource) {
                image.src = fallbackSource;
                image.hidden = false;
                if (placeholder) {
                    placeholder.hidden = true;
                }
            }
        };

        input.addEventListener('change', (event) => {
            const [file] = event.target.files ?? [];

            if (!file) {
                showDefault();
                return;
            }

            const reader = new FileReader();
            reader.onload = ({ target }) => {
                image.src = target?.result ?? '';
                image.hidden = false;

                if (placeholder) {
                    placeholder.hidden = true;
                }
            };
            reader.readAsDataURL(file);
        });

        showDefault();
    });
}
