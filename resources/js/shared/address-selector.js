const ADDRESS_DATASET = {
    province: {
        search: '[data-address-search="province"]',
        select: '[data-address-province]',
        hiddenName: '[data-address-province-name]',
        labelKey: 'ProvinceName',
        valueKey: 'ProvinceID',
    },
    district: {
        search: '[data-address-search="district"]',
        select: '[data-address-district]',
        hiddenName: '[data-address-district-name]',
        labelKey: 'DistrictName',
        valueKey: 'DistrictID',
    },
    ward: {
        search: '[data-address-search="ward"]',
        select: '[data-address-ward]',
        hiddenName: '[data-address-ward-name]',
        labelKey: 'WardName',
        valueKey: 'WardCode',
    },
};

function renderOptions(select, items, valueKey, labelKey, placeholder, selectedValue = '') {
    const nextOptions = [`<option value="">${placeholder}</option>`];

    items.forEach((item) => {
        const value = String(item[valueKey] ?? '');
        const label = String(item[labelKey] ?? '');

        if (!value || !label) {
            return;
        }

        const selected = value === String(selectedValue) ? ' selected' : '';
        nextOptions.push(`<option value="${value}"${selected}>${label}</option>`);
    });

    select.innerHTML = nextOptions.join('');
}

function filterItems(items, labelKey, keyword) {
    const normalizedKeyword = keyword.trim().toLowerCase();

    if (normalizedKeyword === '') {
        return items;
    }

    return items.filter((item) => String(item[labelKey] ?? '').toLowerCase().includes(normalizedKeyword));
}

function setFeedback(container, message = '', isError = false) {
    const feedback = container.querySelector('[data-address-feedback]');

    if (!feedback) {
        return;
    }

    feedback.hidden = message === '';
    feedback.textContent = message;
    feedback.classList.toggle('is-error', isError);
}

async function fetchAddressList(url, params = {}) {
    const query = new URLSearchParams(params).toString();
    const requestUrl = query ? `${url}?${query}` : url;
    const response = await window.fetch(requestUrl, {
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    });

    let payload = null;

    try {
        payload = await response.json();
    } catch {
        payload = {
            message: 'Không thể đọc dữ liệu địa chỉ từ máy chủ.',
        };
    }

    if (!response.ok) {
        throw new Error(payload.message || 'Không thể tải dữ liệu địa chỉ.');
    }

    return Array.isArray(payload.data) ? payload.data : [];
}

function bindSearch(container, key, state, placeholder) {
    const config = ADDRESS_DATASET[key];
    const search = container.querySelector(config.search);
    const select = container.querySelector(config.select);

    if (!search || !select) {
        return;
    }

    search.addEventListener('input', () => {
        renderOptions(
            select,
            filterItems(state[key], config.labelKey, search.value),
            config.valueKey,
            config.labelKey,
            placeholder,
            select.value
        );
    });
}

function syncHiddenName(container, key) {
    const config = ADDRESS_DATASET[key];
    const select = container.querySelector(config.select);
    const hiddenName = container.querySelector(config.hiddenName);

    if (!select || !hiddenName) {
        return;
    }

    const selectedOption = select.options[select.selectedIndex];
    hiddenName.value = select.value && selectedOption ? selectedOption.text : '';
}

export function initAddressSelectors() {
    document.querySelectorAll('[data-address-selector]').forEach((container) => {
        const provinceSelect = container.querySelector(ADDRESS_DATASET.province.select);
        const districtSelect = container.querySelector(ADDRESS_DATASET.district.select);
        const wardSelect = container.querySelector(ADDRESS_DATASET.ward.select);

        if (!provinceSelect || !districtSelect || !wardSelect) {
            return;
        }

        const state = {
            province: [],
            district: [],
            ward: [],
        };

        const selectedProvince = container.dataset.selectedProvince || '';
        const selectedDistrict = container.dataset.selectedDistrict || '';
        const selectedWard = container.dataset.selectedWard || '';

        const setLoading = (select, message) => {
            select.disabled = true;
            select.innerHTML = `<option value="">${message}</option>`;
        };

        const loadDistricts = async (provinceId, districtId = '') => {
            state.district = [];
            state.ward = [];
            container.querySelector(ADDRESS_DATASET.district.search).value = '';
            container.querySelector(ADDRESS_DATASET.ward.search).value = '';
            renderOptions(wardSelect, [], 'WardCode', 'WardName', 'Chọn quận / huyện trước');
            wardSelect.disabled = true;
            syncHiddenName(container, 'ward');

            if (!provinceId) {
                renderOptions(districtSelect, [], 'DistrictID', 'DistrictName', 'Chọn tỉnh / thành trước');
                districtSelect.disabled = true;
                syncHiddenName(container, 'district');
                return;
            }

            setLoading(districtSelect, 'Đang tải quận / huyện...');

            state.district = await fetchAddressList(container.dataset.districtsUrl, {
                province_id: provinceId,
            });

            renderOptions(districtSelect, state.district, 'DistrictID', 'DistrictName', 'Chọn quận / huyện', districtId);
            districtSelect.disabled = false;
            syncHiddenName(container, 'district');
        };

        const loadWards = async (districtId, wardCode = '') => {
            state.ward = [];
            container.querySelector(ADDRESS_DATASET.ward.search).value = '';

            if (!districtId) {
                renderOptions(wardSelect, [], 'WardCode', 'WardName', 'Chọn quận / huyện trước');
                wardSelect.disabled = true;
                syncHiddenName(container, 'ward');
                return;
            }

            setLoading(wardSelect, 'Đang tải phường / xã...');

            state.ward = await fetchAddressList(container.dataset.wardsUrl, {
                district_id: districtId,
            });

            renderOptions(wardSelect, state.ward, 'WardCode', 'WardName', 'Chọn phường / xã', wardCode);
            wardSelect.disabled = false;
            syncHiddenName(container, 'ward');
        };

        provinceSelect.addEventListener('change', async () => {
            syncHiddenName(container, 'province');
            setFeedback(container);

            try {
                await loadDistricts(provinceSelect.value);
            } catch (error) {
                setFeedback(container, error.message, true);
            }
        });

        districtSelect.addEventListener('change', async () => {
            syncHiddenName(container, 'district');
            setFeedback(container);

            try {
                await loadWards(districtSelect.value);
            } catch (error) {
                setFeedback(container, error.message, true);
            }
        });

        wardSelect.addEventListener('change', () => {
            syncHiddenName(container, 'ward');
        });

        bindSearch(container, 'province', state, 'Chọn tỉnh / thành');
        bindSearch(container, 'district', state, 'Chọn quận / huyện');
        bindSearch(container, 'ward', state, 'Chọn phường / xã');

        (async () => {
            try {
                state.province = await fetchAddressList(container.dataset.provincesUrl);
                renderOptions(provinceSelect, state.province, 'ProvinceID', 'ProvinceName', 'Chọn tỉnh / thành', selectedProvince);
                provinceSelect.disabled = false;
                syncHiddenName(container, 'province');

                if (selectedProvince) {
                    await loadDistricts(selectedProvince, selectedDistrict);
                } else {
                    renderOptions(districtSelect, [], 'DistrictID', 'DistrictName', 'Chọn tỉnh / thành trước');
                    districtSelect.disabled = true;
                }

                if (selectedDistrict) {
                    await loadWards(selectedDistrict, selectedWard);
                } else {
                    renderOptions(wardSelect, [], 'WardCode', 'WardName', 'Chọn quận / huyện trước');
                    wardSelect.disabled = true;
                }
            } catch (error) {
                setFeedback(container, error.message, true);
                setLoading(provinceSelect, 'Không tải được dữ liệu GHN');
                setLoading(districtSelect, 'Không tải được dữ liệu');
                setLoading(wardSelect, 'Không tải được dữ liệu');
            }
        })();
    });
}
