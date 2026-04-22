@php
    $provinceId = old('province_id', $provinceId ?? '');
    $provinceName = old('province_name', $provinceName ?? '');
    $districtId = old('district_id', $districtId ?? '');
    $districtName = old('district_name', $districtName ?? '');
    $wardCode = old('ward_code', $wardCode ?? '');
    $wardName = old('ward_name', $wardName ?? '');
@endphp

<div
    class="address-selector"
    data-address-selector
    data-provinces-url="{{ route('client.address.provinces') }}"
    data-districts-url="{{ route('client.address.districts') }}"
    data-wards-url="{{ route('client.address.wards') }}"
    data-selected-province="{{ $provinceId }}"
    data-selected-district="{{ $districtId }}"
    data-selected-ward="{{ $wardCode }}"
>
    <input type="hidden" name="province_name" value="{{ $provinceName }}" data-address-province-name>
    <input type="hidden" name="district_name" value="{{ $districtName }}" data-address-district-name>
    <input type="hidden" name="ward_name" value="{{ $wardName }}" data-address-ward-name>

    <div class="address-selector__grid">
        <label class="address-selector__field">
            <span>Tỉnh / Thành phố</span>
            <input type="search" class="address-selector__search" data-address-search="province" placeholder="Tìm tỉnh / thành">
            <select name="province_id" data-address-province required>
                <option value="">Đang tải tỉnh / thành...</option>
            </select>
        </label>

        <label class="address-selector__field">
            <span>Quận / Huyện / Thành phố</span>
            <input type="search" class="address-selector__search" data-address-search="district" placeholder="Tìm quận / huyện">
            <select name="district_id" data-address-district required disabled>
                <option value="">Chọn tỉnh / thành trước</option>
            </select>
        </label>

        <label class="address-selector__field">
            <span>Phường / Xã</span>
            <input type="search" class="address-selector__search" data-address-search="ward" placeholder="Tìm phường / xã">
            <select name="ward_code" data-address-ward required disabled>
                <option value="">Chọn quận / huyện trước</option>
            </select>
        </label>
    </div>

    <p class="address-selector__feedback" data-address-feedback hidden></p>
</div>
