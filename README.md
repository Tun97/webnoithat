# TAT Interior / TAT Home

Website thương mại điện tử nội thất cao cấp được xây dựng bằng Laravel. Dự án gồm giao diện khách hàng để xem sản phẩm, đặt hàng, thanh toán và khu vực quản trị để vận hành danh mục, sản phẩm, đơn hàng, khách hàng và liên hệ.

## Công nghệ sử dụng

- PHP 8.2+
- Laravel 12
- SQLite mặc định, có thể đổi sang MySQL/MariaDB trong `.env`
- Vite 7
- Tailwind CSS 4
- Laravel session, cache và queue dùng database

## Chức năng chính

### Giao diện khách hàng

- Trang chủ hiển thị danh mục, banner/hero và các nhóm sản phẩm theo danh mục.
- Trang sản phẩm có tìm kiếm, lọc theo danh mục, phân trang, ảnh đại diện, thông tin chất liệu, màu sắc, tồn kho và giá.
- Trang chi tiết sản phẩm có gallery ảnh, mô tả, trạng thái tồn kho và sản phẩm liên quan.
- Đăng ký, đăng nhập, đăng xuất tài khoản khách hàng.
- Chọn địa chỉ giao hàng theo tỉnh/thành, quận/huyện, phường/xã qua API GHN.
- Giỏ hàng: thêm sản phẩm, cập nhật số lượng, xóa sản phẩm, kiểm tra tồn kho.
- Thanh toán và tạo đơn hàng với phí vận chuyển mặc định `30.000đ`.
- Hỗ trợ phương thức thanh toán:
  - COD.
  - Chuyển khoản ngân hàng, hiển thị VietQR nếu đã cấu hình tài khoản nhận tiền.
  - MoMo sandbox qua redirect, return URL và IPN callback.
- Khách hàng có thể xem lịch sử đơn hàng, chi tiết đơn hàng, trạng thái xử lý và lịch sử cập nhật.
- Khách hàng có thể tải bill chuyển khoản để xác nhận thanh toán.
- Trang liên hệ và form tư vấn nhanh ở footer.

### Khu vực quản trị

- Truy cập tại `/admin`, yêu cầu đăng nhập tài khoản có `role = admin`.
- Dashboard thống kê số danh mục, sản phẩm, khách hàng, đơn hàng, liên hệ, doanh thu, biểu đồ doanh thu, trạng thái đơn hàng và sản phẩm bán chạy.
- Quản lý danh mục: thêm, xem, sửa, xóa.
- Quản lý sản phẩm: thêm, xem, sửa, xóa, upload nhiều ảnh, quản lý giá, số lượng, chất liệu, màu sắc và mô tả.
- Quản lý đơn hàng: xem danh sách, xem chi tiết, cập nhật trạng thái `pending`, `shipping`, `completed`, `cancelled`.
- Quản lý liên hệ: xem danh sách, xem chi tiết, xóa liên hệ.
- Quản lý khách hàng: xem danh sách, xem chi tiết đơn hàng của khách, xóa tài khoản khách hàng.

## Cài đặt

Yêu cầu máy đã có PHP 8.2+, Composer, Node.js và npm.

```bash
composer install
npm install
```

Tạo file môi trường:

```bash
cp .env.example .env
php artisan key:generate
```

Trên Windows PowerShell có thể dùng:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Mặc định dự án dùng SQLite. Nếu file database chưa có, tạo file rỗng:

```bash
touch database/database.sqlite
```

Trên Windows PowerShell:

```powershell
New-Item -ItemType File database/database.sqlite -Force
```

Chạy migration và seed dữ liệu mẫu:

```bash
php artisan migrate --seed
```

Tạo symlink cho ảnh upload trong storage:

```bash
php artisan storage:link
```

Build asset production nếu cần:

```bash
npm run build
```

## Cấu hình môi trường

Các biến quan trọng trong `.env`:

```env
APP_NAME="TAT Home"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

GHN_TOKEN=
GHN_BASE_URL=https://online-gateway.ghn.vn/shiip/public-api

MOMO_PARTNER_CODE=
MOMO_ACCESS_KEY=
MOMO_SECRET_KEY=
MOMO_END_POINT=https://test-payment.momo.vn/v2/gateway/api/create
MOMO_COMPLETE_ON_RETURN=true

VIETQR_BANK=
VIETQR_ACCOUNT=
VIETQR_ACCOUNT_NAME=
VIETQR_TEMPLATE=compact2
VIETQR_ADD_INFO_PREFIX=ORDER
```

Ghi chú:

- `GHN_TOKEN` cần có nếu muốn tải danh sách tỉnh/huyện/xã khi đăng ký hoặc thanh toán.
- Các biến `MOMO_*` chỉ bắt buộc khi dùng thanh toán MoMo.
- Các biến `VIETQR_*` chỉ bắt buộc khi muốn hiển thị QR chuyển khoản ngân hàng.
- Nếu dùng MySQL/MariaDB, đổi `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` trong `.env`.

## Cách chạy dự án

Chạy toàn bộ môi trường dev bằng lệnh:

```bash
composer run dev
```

Lệnh này chạy đồng thời Laravel server, queue listener, log viewer và Vite dev server.

Hoặc chạy thủ công bằng các terminal riêng:

```bash
php artisan serve
npm run dev
php artisan queue:listen --tries=1 --timeout=0
```

Sau đó mở:

- Website khách hàng: `http://127.0.0.1:8000`
- Trang quản trị: `http://127.0.0.1:8000/admin`

## Tài khoản mẫu

Seeder hiện tạo tài khoản khách hàng:

```text
Email: test@example.com
Password: password
```

Để tạo nhanh tài khoản admin:

```bash
php artisan tinker --execute="App\Models\User::updateOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']);"
```

Sau đó đăng nhập:

```text
Email: admin@example.com
Password: password
```

Nên đổi mật khẩu admin khi triển khai thật.

## Kiểm thử

Chạy test:

```bash
php artisan test
```

Hoặc dùng script Composer:

```bash
composer test
```

## Cấu trúc thư mục đáng chú ý

```text
app/Http/Controllers/Client   Controller giao diện khách hàng
app/Http/Controllers/Admin    Controller khu vực quản trị
app/Models                    Model dữ liệu chính
app/Services                  Tích hợp MoMo và VietQR
database/migrations           Cấu trúc database
database/seeders              Dữ liệu mẫu
resources/views/client        Blade view giao diện khách hàng
resources/views/admin         Blade view quản trị
resources/js                  JavaScript cho client/admin
resources/css                 CSS cho client/admin
routes/web.php                Route khách hàng và auth
routes/admin.php              Route quản trị
```
