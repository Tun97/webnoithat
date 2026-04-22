-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 22, 2026 lúc 02:52 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-20 23:44:13', '2026-04-20 23:44:13'),
(2, 1, '2026-04-20 23:48:04', '2026-04-20 23:48:04'),
(3, 3, '2026-04-21 00:17:03', '2026-04-21 00:17:03'),
(4, 4, '2026-04-21 03:42:28', '2026-04-21 03:42:28'),
(5, 5, '2026-04-22 01:03:01', '2026-04-22 01:03:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Nội Thất Phòng Khách', 'noi-that-phong-khach', 'Trong tổng thể kiến trúc nhà ở thì phòng khách luôn là không gian nội thất quan trọng bậc nhất, vì thế mà việc thiết kế và hoàn thiện nội thất phòng khách như thế nào và ra sao rất được các gia chủ chú trọng. Theo đó để có thể cùng lúc đảm bảo về mặt tiện nghi lẫn thẩm mỹ thì đã có không ít gia chủ “mạnh tay” đầu tư cho những món đồ nội thất phòng khách nhập khẩu. Đây là điều hoàn toàn dễ hiểu khi mà từ trước đến nay các sản phẩm nội thất nhập khẩu nói chung luôn sở hữu những ưu điểm vượt trội hơn rất nhiều so với các sản phẩm được sản xuất nội địa. Và thật tự hào khi TAT Home đã và đang trở thành một địa chỉ đồng hành đầy tin cậy trong lĩnh vực này.', '2026-04-20 08:40:07', '2026-04-20 08:40:07'),
(2, 'Nội Thất Phòng Ăn', 'noi-that-phong-an', 'Trong tổng thể kiến trúc nhà ở thì phòng ăn là không gian giữ vai trò kết nối cảm xúc giữa các thành viên trong gia đình, vì thế việc thiết kế và hoàn thiện nội thất phòng ăn như thế nào luôn được các gia chủ đặc biệt quan tâm. Đây không chỉ đơn thuần là nơi dùng bữa mà còn là không gian sum họp, chia sẻ và tạo nên những khoảnh khắc đáng nhớ sau mỗi ngày dài.\r\n\r\nTheo đó, để đảm bảo sự hài hòa giữa công năng và tính thẩm mỹ, nhiều gia chủ ngày nay có xu hướng đầu tư kỹ lưỡng vào bàn ăn, ghế ngồi, hệ tủ lưu trữ hay đèn trang trí. Từ phong cách hiện đại tối giản cho đến tân cổ điển sang trọng, mỗi lựa chọn đều góp phần thể hiện gu thẩm mỹ và cá tính riêng của gia chủ. Đặc biệt, những sản phẩm nội thất chất lượng cao, thiết kế tinh tế không chỉ nâng tầm không gian mà còn mang lại trải nghiệm sử dụng thoải mái và bền vững theo thời gian.\r\n\r\nChính vì vậy, việc lựa chọn một đơn vị cung cấp nội thất uy tín đóng vai trò rất quan trọng, giúp gia chủ hiện thực hóa không gian phòng ăn lý tưởng – nơi hội tụ đầy đủ sự ấm cúng, tiện nghi và đẳng cấp trong từng chi tiết.', '2026-04-20 08:42:06', '2026-04-20 08:42:06'),
(3, 'Nội Thất Phòng Ngủ', 'noi-that-phong-ngu', 'Trong tổng thể kiến trúc nhà ở thì phòng ngủ là không gian nội thất mang tính riêng tư và thư giãn bậc nhất, vì thế việc thiết kế và hoàn thiện nội thất phòng ngủ như thế nào luôn được các gia chủ đặc biệt chú trọng. Đây không chỉ là nơi nghỉ ngơi sau một ngày dài mà còn là không gian tái tạo năng lượng, cân bằng cảm xúc và nâng cao chất lượng sống.\r\n\r\nTheo đó, để đảm bảo sự hài hòa giữa công năng và yếu tố thẩm mỹ, nhiều gia chủ ngày nay sẵn sàng đầu tư chỉn chu vào giường ngủ, tủ quần áo, tab đầu giường hay hệ thống ánh sáng. Tùy theo sở thích và phong cách cá nhân, không gian phòng ngủ có thể được thiết kế theo hướng hiện đại tinh gọn, ấm cúng tối giản hoặc sang trọng tinh tế. Những món đồ nội thất chất lượng cao với thiết kế đồng bộ không chỉ giúp tối ưu trải nghiệm sử dụng mà còn tạo nên một không gian nghỉ ngơi lý tưởng, dễ chịu và bền vững theo thời gian.\r\n\r\nChính vì vậy, việc lựa chọn đơn vị cung cấp và thiết kế nội thất uy tín là yếu tố quan trọng, giúp gia chủ hiện thực hóa một phòng ngủ hoàn hảo – nơi hội tụ đầy đủ sự tiện nghi, thoải mái và dấu ấn cá nhân trong từng chi tiết.', '2026-04-20 08:43:05', '2026-04-20 08:43:05'),
(4, 'Nội Thất Phòng Làm Việc', 'noi-that-phong-lam-viec', 'Trong tổng thể kiến trúc nhà ở hiện đại thì phòng làm việc là không gian nội thất đóng vai trò quan trọng trong việc nâng cao hiệu suất và chất lượng công việc, vì thế việc thiết kế và hoàn thiện nội thất phòng làm việc như thế nào ngày càng được các gia chủ quan tâm. Đây không chỉ là nơi xử lý công việc mà còn là không gian thể hiện sự tập trung, tư duy sáng tạo và phong cách sống chuyên nghiệp.\r\n\r\nTheo đó, để đảm bảo sự cân bằng giữa công năng và tính thẩm mỹ, nhiều gia chủ có xu hướng đầu tư bài bản vào bàn làm việc, ghế ngồi công thái học, hệ tủ tài liệu cũng như ánh sáng và cách âm. Tùy theo tính chất công việc và sở thích cá nhân, không gian có thể được thiết kế theo phong cách tối giản, hiện đại hoặc mang hơi hướng sáng tạo, truyền cảm hứng. Những món đồ nội thất chất lượng cao, bố trí khoa học không chỉ giúp tối ưu hiệu quả làm việc mà còn tạo cảm giác thoải mái, giảm căng thẳng trong quá trình sử dụng.\r\n\r\nChính vì vậy, việc lựa chọn giải pháp nội thất phù hợp và đơn vị cung cấp uy tín sẽ giúp gia chủ kiến tạo nên một phòng làm việc lý tưởng – nơi hội tụ đầy đủ sự tiện nghi, tính thẩm mỹ và nguồn cảm hứng tích cực trong từng chi tiết.', '2026-04-20 08:44:33', '2026-04-20 08:44:33'),
(5, 'Nội Thất Hoàng Gia', 'noi-that-hoang-gia', 'Trong tổng thể kiến trúc nội thất cao cấp thì phong cách nội thất hoàng gia luôn được xem là biểu tượng của sự xa hoa, quyền quý và đẳng cấp vượt thời gian, vì thế việc thiết kế và hoàn thiện không gian theo phong cách này luôn được các gia chủ đặc biệt chú trọng. Không chỉ đơn thuần là nơi sinh hoạt, đây còn là cách thể hiện vị thế, gu thẩm mỹ tinh tế và sự đầu tư mạnh mẽ vào chất lượng sống.\r\n\r\nTheo đó, để tái hiện trọn vẹn vẻ đẹp hoàng gia, nhiều gia chủ sẵn sàng đầu tư vào các món đồ nội thất được chế tác công phu với đường nét chạm khắc tinh xảo, sử dụng chất liệu cao cấp như gỗ tự nhiên, da thật, đá marble hay kim loại mạ vàng. Gam màu chủ đạo thường xoay quanh các tông màu sang trọng như vàng, kem, trắng hoặc nâu trầm, kết hợp cùng hệ thống đèn chùm lộng lẫy và các chi tiết trang trí cầu kỳ nhằm tạo nên một không gian đậm chất nghệ thuật và quyền lực.\r\n\r\nĐặc biệt, các sản phẩm nội thất hoàng gia thường mang giá trị không chỉ ở công năng mà còn ở tính thẩm mỹ và độ bền vượt trội theo thời gian. Mỗi chi tiết đều được chăm chút kỹ lưỡng để đảm bảo sự đồng bộ và hoàn hảo trong tổng thể không gian.\r\n\r\nChính vì vậy, việc lựa chọn một đơn vị thiết kế và cung cấp nội thất uy tín là yếu tố then chốt, giúp gia chủ kiến tạo nên không gian sống mang đậm dấu ấn hoàng gia – nơi hội tụ đầy đủ sự sang trọng, tinh tế và đẳng cấp khác biệt trong từng chi tiết.', '2026-04-20 08:44:49', '2026-04-20 08:44:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Tăng Anh Tuấn', '', '0977665556', 'Cần tư Vấn Viên', '2026-04-21 01:48:33', '2026-04-21 01:48:33'),
(2, 'Khách cần tư vấn', '', '0977665556', 'Khách để lại số điện thoại tại footer để được tư vấn miễn phí.', '2026-04-21 02:07:12', '2026-04-21 02:07:12'),
(3, 'Tăng Anh Tuấn', '', '0977665556', 'cần tư vấn sản phẩm', '2026-04-21 03:43:02', '2026-04-21 03:43:02'),
(4, 'Khách cần tư vấn', '', '0977665556', 'Khách để lại số điện thoại tại footer để được tư vấn miễn phí.', '2026-04-21 03:43:31', '2026-04-21 03:43:31'),
(5, 'Khách cần tư vấn', '', '0988887788', 'Khách để lại số điện thoại tại footer để được tư vấn miễn phí.', '2026-04-22 01:06:03', '2026-04-22 01:06:03'),
(6, 'Đặng Đức Trí', '', '0988777665', 'Cần Tư Vấn Viên Hỗ Trợ Mua Hàng', '2026-04-22 01:08:01', '2026-04-22 01:08:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_20_142146_add_role_phone_address_to_users_table', 1),
(5, '2026_04_20_142217_create_categories_table', 1),
(6, '2026_04_20_142222_create_products_table', 1),
(7, '2026_04_20_142228_create_product_images_table', 1),
(8, '2026_04_20_142234_create_carts_table', 1),
(9, '2026_04_20_142239_create_cart_items_table', 1),
(10, '2026_04_20_142244_create_orders_table', 1),
(11, '2026_04_20_142250_create_order_items_table', 1),
(12, '2026_04_20_142255_create_banners_table', 1),
(13, '2026_04_20_142300_create_contacts_table', 1),
(14, '2026_04_21_120000_add_shipping_fields_to_users_and_orders_tables', 2),
(15, '2026_04_21_130000_create_order_status_histories_table', 3),
(16, '2026_04_21_140000_add_momo_payment_fields_to_orders_table', 4),
(17, '2026_04_21_150000_add_bank_transfer_receipt_fields_to_orders_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `address_line` text DEFAULT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL,
  `province_name` varchar(255) DEFAULT NULL,
  `district_id` int(10) UNSIGNED DEFAULT NULL,
  `district_name` varchar(255) DEFAULT NULL,
  `ward_code` varchar(32) DEFAULT NULL,
  `ward_name` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `momo_order_id` varchar(255) DEFAULT NULL,
  `momo_request_id` varchar(255) DEFAULT NULL,
  `momo_trans_id` varchar(255) DEFAULT NULL,
  `momo_pay_url` text DEFAULT NULL,
  `momo_qr_code` text DEFAULT NULL,
  `momo_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`momo_response`)),
  `bank_transfer_receipt_path` varchar(255) DEFAULT NULL,
  `bank_transfer_receipt_original_name` varchar(255) DEFAULT NULL,
  `bank_transfer_receipt_uploaded_at` timestamp NULL DEFAULT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `phone`, `address`, `address_line`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_code`, `ward_name`, `note`, `total_amount`, `payment_method`, `payment_status`, `paid_at`, `momo_order_id`, `momo_request_id`, `momo_trans_id`, `momo_pay_url`, `momo_qr_code`, `momo_response`, `bank_transfer_receipt_path`, `bank_transfer_receipt_original_name`, `bank_transfer_receipt_uploaded_at`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao Giờ Hành Chính', 320330000.00, 'cod', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', '2026-04-21 00:20:23', '2026-04-21 00:28:04'),
(2, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao vào ngày 30/4 1/5', 320330000.00, 'cod', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cancelled', '2026-04-21 00:28:53', '2026-04-21 00:31:06'),
(3, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao Nhanh 24h', 203030900.00, 'momo', 'failed', NULL, 'ORDER3T20260421075339', 'MOMO3T20260421075339', NULL, NULL, NULL, '{\"create_error\":\"MoMo tr\\u1ea3 v\\u1ec1 l\\u1ed7i HTTP 400.\"}', NULL, NULL, NULL, 'cancelled', '2026-04-21 00:53:39', '2026-04-21 00:54:36'),
(4, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao Luôn Trong Ngày', 203030900.00, 'momo', 'failed', NULL, 'ORDER4T20260421075941', 'MOMO4T20260421075941', NULL, NULL, NULL, '{\"create_error\":\"MoMo tr\\u1ea3 v\\u1ec1 l\\u1ed7i HTTP 400.\"}', NULL, NULL, NULL, 'cancelled', '2026-04-21 00:55:03', '2026-04-21 01:00:35'),
(5, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao Thứ 7/ Chủ Nhật', 203030900.00, 'momo', 'paid', '2026-04-21 01:01:24', 'ORDER5T20260421080108', 'MOMO5T20260421080108', '1776758480675', 'https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjVUMjAyNjA0MjEwODAxMDg&s=0574da9586aa3920d65ee6bb39af5ae4d372bfb3aec14297762e98064c3fb476', '00020101021226110007vn.momo38620010A00000072701320006970454011899MM26111O000000870208QRIBFTTA53037045405100005802VN62490515MMTM3bfdsPXQ0QR070100821Thanh toan don hang 56304d8ec', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER5T20260421080108\",\"requestId\":\"MOMO5T20260421080108\",\"amount\":10000,\"responseTime\":1776758470188,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjVUMjAyNjA0MjEwODAxMDg&s=0574da9586aa3920d65ee6bb39af5ae4d372bfb3aec14297762e98064c3fb476\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjVUMjAyNjA0MjEwODAxMDg&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM26111O000000870208QRIBFTTA53037045405100005802VN62490515MMTM3bfdsPXQ0QR070100821Thanh toan don hang 56304d8ec\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjVUMjAyNjA0MjEwODAxMDg&v=3.0&deeplinkCallback=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D5&callBackUrl=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D5\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjVUMjAyNjA0MjEwODAxMDg&v=3.0\",\"signature\":\"eea9aeca0a95d7a5d0ec130660bbd53719a28926af9228b9dd71b75961835aa7\",\"momo_order_id\":\"ORDER5T20260421080108\",\"momo_request_id\":\"MOMO5T20260421080108\",\"request_payload\":{\"partnerCode\":\"MOMOBKUN20180529\",\"requestType\":\"captureWallet\",\"ipnUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/ipn\",\"redirectUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/return?order_id=5\",\"orderId\":\"ORDER5T20260421080108\",\"amount\":\"10000\",\"orderInfo\":\"Thanh toan don hang #5\",\"requestId\":\"MOMO5T20260421080108\",\"extraData\":\"eyJvcmRlcl9pZCI6NX0=\",\"autoCapture\":true,\"lang\":\"vi\",\"signature\":\"b1cfe53b05b30c1d2664573032029901db95aa9fc483269ad9744e6bcb41a7a3\"},\"return_payload\":{\"order_id\":\"5\",\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER5T20260421080108\",\"requestId\":\"MOMO5T20260421080108\",\"amount\":\"10000\",\"orderInfo\":\"Thanh toan don hang #5\",\"orderType\":\"momo_wallet\",\"transId\":\"1776758480675\",\"resultCode\":\"1006\",\"message\":\"Giao d\\u1ecbch b\\u1ecb t\\u1eeb ch\\u1ed1i b\\u1edfi ng\\u01b0\\u1eddi d\\u00f9ng.\",\"payType\":null,\"responseTime\":\"1776758480808\",\"extraData\":\"eyJvcmRlcl9pZCI6NX0=\",\"signature\":\"fa964f7aeb92632c8f999eb8f7579ec464adaf2d18526e3ba7c788b42744a127\"}}', NULL, NULL, NULL, 'completed', '2026-04-21 01:01:08', '2026-04-21 01:04:42'),
(6, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Giao giờ hành chính', 300030000.00, 'momo', 'paid', '2026-04-21 01:08:27', 'ORDER6T20260421080803', 'MOMO6T20260421080803', '1776758903223', 'https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjZUMjAyNjA0MjEwODA4MDM&s=37cfc6c5c3a4bd2c57d6c88fb11a5ab61ae388263790cedfcff3b74847b2008f', '00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000450208QRIBFTTA53037045405100005802VN62490515MMTnF9SOfHT05QR070100821Thanh toan don hang 663045f22', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER6T20260421080803\",\"requestId\":\"MOMO6T20260421080803\",\"amount\":10000,\"responseTime\":1776758883286,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjZUMjAyNjA0MjEwODA4MDM&s=37cfc6c5c3a4bd2c57d6c88fb11a5ab61ae388263790cedfcff3b74847b2008f\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjZUMjAyNjA0MjEwODA4MDM&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000450208QRIBFTTA53037045405100005802VN62490515MMTnF9SOfHT05QR070100821Thanh toan don hang 663045f22\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjZUMjAyNjA0MjEwODA4MDM&v=3.0&deeplinkCallback=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D6&callBackUrl=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D6\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjZUMjAyNjA0MjEwODA4MDM&v=3.0\",\"signature\":\"ee5e53f0ea6388c2cebb35b55fbe031da8ae409d590f9b6211518c997a541d2f\",\"momo_order_id\":\"ORDER6T20260421080803\",\"momo_request_id\":\"MOMO6T20260421080803\",\"request_payload\":{\"partnerCode\":\"MOMOBKUN20180529\",\"requestType\":\"captureWallet\",\"ipnUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/ipn\",\"redirectUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/return?order_id=6\",\"orderId\":\"ORDER6T20260421080803\",\"amount\":\"10000\",\"orderInfo\":\"Thanh toan don hang #6\",\"requestId\":\"MOMO6T20260421080803\",\"extraData\":\"eyJvcmRlcl9pZCI6Nn0=\",\"autoCapture\":true,\"lang\":\"vi\",\"signature\":\"240038f0b254090b849cc849811d2cabaa633cda1308a63e226fa2b786db95a6\"},\"return_payload\":{\"order_id\":\"6\",\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER6T20260421080803\",\"requestId\":\"MOMO6T20260421080803\",\"amount\":\"10000\",\"orderInfo\":\"Thanh toan don hang #6\",\"orderType\":\"momo_wallet\",\"transId\":\"1776758903223\",\"resultCode\":\"1006\",\"message\":\"Giao d\\u1ecbch b\\u1ecb t\\u1eeb ch\\u1ed1i b\\u1edfi ng\\u01b0\\u1eddi d\\u00f9ng.\",\"payType\":null,\"responseTime\":\"1776758903260\",\"extraData\":\"eyJvcmRlcl9pZCI6Nn0=\",\"signature\":\"867c6001b96d64619ca0a43071592c6e410ec1771c855cdaa3cb84a75ccea911\"}}', NULL, NULL, NULL, 'completed', '2026-04-21 01:05:56', '2026-04-21 01:08:57'),
(7, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'Gọi trước khi giao', 320330000.00, 'bank_transfer', 'paid', '2026-04-21 01:25:29', NULL, NULL, NULL, NULL, NULL, NULL, 'bank-transfer-bills/Xq98rSzLyuT4tVSWppA6Yh85yS1q89UcDMN4XPuV.jpg', 's1.jpg', '2026-04-21 01:25:29', 'shipping', '2026-04-21 01:16:52', '2026-04-21 01:25:29'),
(8, 3, 'Tăng Anh Tuấn', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', 'giao nhanh 24h', 730000.00, 'momo', 'paid', '2026-04-21 03:16:15', 'ORDER8T20260421101605', 'MOMO8T20260421101605', '1776766571775', 'https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjhUMjAyNjA0MjExMDE2MDU&s=a7c763dfb3d95550a5f843e38ce4d2796969e0e87994885f136322a8685e9cf4', '00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000610208QRIBFTTA530370454067300005802VN62490515MMTuMLDjMfQ38QR070100821Thanh toan don hang 86304473e', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER8T20260421101605\",\"requestId\":\"MOMO8T20260421101605\",\"amount\":730000,\"responseTime\":1776766565414,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjhUMjAyNjA0MjExMDE2MDU&s=a7c763dfb3d95550a5f843e38ce4d2796969e0e87994885f136322a8685e9cf4\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjhUMjAyNjA0MjExMDE2MDU&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000610208QRIBFTTA530370454067300005802VN62490515MMTuMLDjMfQ38QR070100821Thanh toan don hang 86304473e\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjhUMjAyNjA0MjExMDE2MDU&v=3.0&deeplinkCallback=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D8&callBackUrl=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D8\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjhUMjAyNjA0MjExMDE2MDU&v=3.0\",\"signature\":\"2d20752fb4ffe4c7f343338ccfdafa0f75e655cf5e8b811776866e46490a8bb4\",\"momo_order_id\":\"ORDER8T20260421101605\",\"momo_request_id\":\"MOMO8T20260421101605\",\"request_payload\":{\"partnerCode\":\"MOMOBKUN20180529\",\"requestType\":\"captureWallet\",\"ipnUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/ipn\",\"redirectUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/return?order_id=8\",\"orderId\":\"ORDER8T20260421101605\",\"amount\":\"730000\",\"orderInfo\":\"Thanh toan don hang #8\",\"requestId\":\"MOMO8T20260421101605\",\"extraData\":\"eyJvcmRlcl9pZCI6OH0=\",\"autoCapture\":true,\"lang\":\"vi\",\"signature\":\"b284d84d1d6494da19dcc2e93ebe97f86283d7366b8e44d5a2ca79ad3d12a0fb\"},\"return_payload\":{\"order_id\":\"8\",\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER8T20260421101605\",\"requestId\":\"MOMO8T20260421101605\",\"amount\":\"730000\",\"orderInfo\":\"Thanh toan don hang #8\",\"orderType\":\"momo_wallet\",\"transId\":\"1776766571775\",\"resultCode\":\"1006\",\"message\":\"Giao d\\u1ecbch b\\u1ecb t\\u1eeb ch\\u1ed1i b\\u1edfi ng\\u01b0\\u1eddi d\\u00f9ng.\",\"payType\":null,\"responseTime\":\"1776766571834\",\"extraData\":\"eyJvcmRlcl9pZCI6OH0=\",\"signature\":\"675b1689b261ffca8ab8a8974bea643a7137da7131cf2ce11ba9d254ebd9b439\"}}', NULL, NULL, NULL, 'completed', '2026-04-21 03:16:05', '2026-04-21 03:16:32'),
(9, 4, 'Nguyễn Quang Linh', '0987638383', '200- phường tiền ninh tê, Phường Tiền Ninh Vệ, Thành phố Bắc Ninh, Bắc Ninh', '200- phường tiền ninh tê', 249, 'Bắc Ninh', 1644, 'Thành phố Bắc Ninh', '910074', 'Phường Tiền Ninh Vệ', NULL, 15030000.00, 'momo', 'paid', '2026-04-21 03:44:47', 'ORDER9T20260421104356', 'MOMO9T20260421104356', NULL, 'https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjlUMjAyNjA0MjExMDQzNTY&s=3b3474dc59d524e99194ab60c68a582059643848d3191bf0d499f0809d8b6cc4', '00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000660208QRIBFTTA53037045408150300005802VN62490515MMTfLW654lGX0QR070100821Thanh toan don hang 963045d76', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER9T20260421104356\",\"requestId\":\"MOMO9T20260421104356\",\"amount\":15030000,\"responseTime\":1776768256556,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjlUMjAyNjA0MjExMDQzNTY&s=3b3474dc59d524e99194ab60c68a582059643848d3191bf0d499f0809d8b6cc4\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjlUMjAyNjA0MjExMDQzNTY&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38630010A000000727013300069710250119PMC26111000000000660208QRIBFTTA53037045408150300005802VN62490515MMTfLW654lGX0QR070100821Thanh toan don hang 963045d76\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjlUMjAyNjA0MjExMDQzNTY&v=3.0&deeplinkCallback=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D9&callBackUrl=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D9\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjlUMjAyNjA0MjExMDQzNTY&v=3.0\",\"signature\":\"b6088ca3c7b73a39c93d73af6ace396a922706a373773858412a4f2f12b2baf9\",\"momo_order_id\":\"ORDER9T20260421104356\",\"momo_request_id\":\"MOMO9T20260421104356\",\"request_payload\":{\"partnerCode\":\"MOMOBKUN20180529\",\"requestType\":\"captureWallet\",\"ipnUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/ipn\",\"redirectUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/return?order_id=9\",\"orderId\":\"ORDER9T20260421104356\",\"amount\":\"15030000\",\"orderInfo\":\"Thanh toan don hang #9\",\"requestId\":\"MOMO9T20260421104356\",\"extraData\":\"eyJvcmRlcl9pZCI6OX0=\",\"autoCapture\":true,\"lang\":\"vi\",\"signature\":\"fe2bb4f05f25c602121798c5a10017bf3071e8e06c7cb083385e374e9e155f7a\"},\"return_payload\":{\"order_id\":\"9\",\"from\":\"browser_back\"}}', NULL, NULL, NULL, 'completed', '2026-04-21 03:43:56', '2026-04-21 03:45:08'),
(10, 5, 'Đặng Đức Trí', '0975758943', 'Xóm 55, Xã Đông Phong, Huyện Tiền Hải, Thái Bình', 'Xóm 55', 226, 'Thái Bình', 3281, 'Huyện Tiền Hải', '260710', 'Xã Đông Phong', 'Giao Vào Chủ Nhật', 1622000.00, 'momo', 'paid', '2026-04-22 01:04:28', 'ORDER10T20260422080347', 'MOMO10T20260422080347', '1776845065057', 'https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjEwVDIwMjYwNDIyMDgwMzQ3&s=43b6970a4f232a09b9cea93cb5d739a741911119cead4317fb348295b7a274e6', '00020101021226110007vn.momo38620010A00000072701320006970454011899MM26112O000000490208QRIBFTTA5303704540716220005802VN62500515MMTbZ41wKxENSQR070100822Thanh toan don hang 10630442fc', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER10T20260422080347\",\"requestId\":\"MOMO10T20260422080347\",\"amount\":1622000,\"responseTime\":1776845027740,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjEwVDIwMjYwNDIyMDgwMzQ3&s=43b6970a4f232a09b9cea93cb5d739a741911119cead4317fb348295b7a274e6\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjEwVDIwMjYwNDIyMDgwMzQ3&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM26112O000000490208QRIBFTTA5303704540716220005802VN62500515MMTbZ41wKxENSQR070100822Thanh toan don hang 10630442fc\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&scanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjEwVDIwMjYwNDIyMDgwMzQ3&v=3.0&deeplinkCallback=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D10&callBackUrl=http%3A%2F%2F127.0.0.1%3A8000%2Fthanh-toan%2Fmomo%2Freturn%3Forder_id%3D10\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&scanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxPUkRFUjEwVDIwMjYwNDIyMDgwMzQ3&v=3.0\",\"signature\":\"9d509750febe009a3915f6c350fd1f8208ef0a2884777f4829ed0ed262e5e805\",\"momo_order_id\":\"ORDER10T20260422080347\",\"momo_request_id\":\"MOMO10T20260422080347\",\"request_payload\":{\"partnerCode\":\"MOMOBKUN20180529\",\"requestType\":\"captureWallet\",\"ipnUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/ipn\",\"redirectUrl\":\"http:\\/\\/127.0.0.1:8000\\/thanh-toan\\/momo\\/return?order_id=10\",\"orderId\":\"ORDER10T20260422080347\",\"amount\":\"1622000\",\"orderInfo\":\"Thanh toan don hang #10\",\"requestId\":\"MOMO10T20260422080347\",\"extraData\":\"eyJvcmRlcl9pZCI6MTB9\",\"autoCapture\":true,\"lang\":\"vi\",\"signature\":\"d0c8b8945bbde0bc9b8c290b85774e3d27c6e0088d9465722aff31747cdf30cd\"},\"return_payload\":{\"order_id\":\"10\",\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"ORDER10T20260422080347\",\"requestId\":\"MOMO10T20260422080347\",\"amount\":\"1622000\",\"orderInfo\":\"Thanh toan don hang #10\",\"orderType\":\"momo_wallet\",\"transId\":\"1776845065057\",\"resultCode\":\"1006\",\"message\":\"Giao d\\u1ecbch b\\u1ecb t\\u1eeb ch\\u1ed1i b\\u1edfi ng\\u01b0\\u1eddi d\\u00f9ng.\",\"payType\":null,\"responseTime\":\"1776845065199\",\"extraData\":\"eyJvcmRlcl9pZCI6MTB9\",\"signature\":\"274e420432492413dab7140049691ccdb77caae870a3d7669f63b690b745d4cd\"}}', NULL, NULL, NULL, 'completed', '2026-04-22 01:03:47', '2026-04-22 01:05:26'),
(11, 5, 'Đặng Đức Trí', '0975758943', 'Xóm 55, Xã Đông Phong, Huyện Tiền Hải, Thái Bình', 'Xóm 55', 226, 'Thái Bình', 3281, 'Huyện Tiền Hải', '260710', 'Xã Đông Phong', 'Giao hỏa tốc', 3330000.00, 'bank_transfer', 'paid', '2026-04-22 01:07:17', NULL, NULL, NULL, NULL, NULL, NULL, 'bank-transfer-bills/7RUeuETRcHbDM8wZW4jq858ScnVJD8T1CfTbhluO.png', 'About-us.png', '2026-04-22 01:07:17', 'completed', '2026-04-22 01:06:49', '2026-04-22 01:07:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Bộ bàn ghế ăn mun phong cách tân cổ điển đơn giản sang trọng', 320300000.00, 1, 320300000.00, '2026-04-21 00:20:23', '2026-04-21 00:20:23'),
(2, 2, 4, 'Bộ bàn ghế ăn mun phong cách tân cổ điển đơn giản sang trọng', 320300000.00, 1, 320300000.00, '2026-04-21 00:28:53', '2026-04-21 00:28:53'),
(3, 3, 2, 'Bộ sofa phòng khách nhập khẩu da bò tót', 203000900.00, 1, 203000900.00, '2026-04-21 00:53:39', '2026-04-21 00:53:39'),
(4, 4, 2, 'Bộ sofa phòng khách nhập khẩu da bò tót', 203000900.00, 1, 203000900.00, '2026-04-21 00:55:03', '2026-04-21 00:55:03'),
(5, 5, 2, 'Bộ sofa phòng khách nhập khẩu da bò tót', 203000900.00, 1, 203000900.00, '2026-04-21 01:01:08', '2026-04-21 01:01:08'),
(6, 6, 1, '✨ SOFA NỈ CAO CẤP TÂN CỔ ĐIỂN – SANG TRỌNG NGAY TỪ ÁNH NHÌN ĐẦU TIÊN ✨', 300000000.00, 1, 300000000.00, '2026-04-21 01:05:56', '2026-04-21 01:05:56'),
(7, 7, 4, 'Bộ bàn ghế ăn mun phong cách tân cổ điển đơn giản sang trọng', 320300000.00, 1, 320300000.00, '2026-04-21 01:16:52', '2026-04-21 01:16:52'),
(8, 8, 9, 'HỘP ĐỂ NỮ TRANG TÂN CỔ ĐIỂN HỌA TIẾT AI CẬP CỔ ĐẠI HNT2-A', 700000.00, 1, 700000.00, '2026-04-21 03:16:05', '2026-04-21 03:16:05'),
(9, 9, 7, 'GHẾ RÙA THƯ GIÃN TÔNG TRẮNG - GH-RUA-TRANG', 15000000.00, 1, 15000000.00, '2026-04-21 03:43:56', '2026-04-21 03:43:56'),
(10, 10, 10, 'Giá treo quần áo cao cấp', 1592000.00, 1, 1592000.00, '2026-04-22 01:03:47', '2026-04-22 01:03:47'),
(11, 11, 18, 'Đĩa quả tân cổ điển nhập khẩu DQ-102', 3300000.00, 1, 3300000.00, '2026-04-22 01:06:49', '2026-04-22 01:06:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status_histories`
--

CREATE TABLE `order_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status_histories`
--

INSERT INTO `order_status_histories` (`id`, `order_id`, `status`, `label`, `note`, `changed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-21 00:28:04', '2026-04-21 00:28:04'),
(2, 2, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 00:28:53', '2026-04-21 00:28:53'),
(3, 2, 'cancelled', 'Đã hủy', 'Đơn hàng đã bị hủy.', 1, '2026-04-21 00:31:06', '2026-04-21 00:31:06'),
(4, 3, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 00:53:39', '2026-04-21 00:53:39'),
(5, 3, 'cancelled', 'Đã hủy', 'Đơn hàng đã bị hủy.', 1, '2026-04-21 00:54:36', '2026-04-21 00:54:36'),
(6, 4, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 00:55:03', '2026-04-21 00:55:03'),
(7, 4, 'cancelled', 'Đã hủy', 'Đơn hàng đã bị hủy.', 1, '2026-04-21 01:00:35', '2026-04-21 01:00:35'),
(8, 5, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 01:01:08', '2026-04-21 01:01:08'),
(9, 5, 'payment_paid', 'Đã thanh toán MoMo', 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.', 3, '2026-04-21 01:01:24', '2026-04-21 01:01:24'),
(10, 5, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-21 01:04:42', '2026-04-21 01:04:42'),
(11, 6, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 01:05:56', '2026-04-21 01:05:56'),
(12, 6, 'payment_paid', 'Đã thanh toán MoMo', 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.', 3, '2026-04-21 01:08:27', '2026-04-21 01:08:27'),
(13, 6, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-21 01:08:57', '2026-04-21 01:08:57'),
(14, 7, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 01:16:52', '2026-04-21 01:16:52'),
(15, 7, 'payment_paid', 'Đã thanh toán chuyển khoản', 'Khách hàng đã xác nhận chuyển khoản và tải lên bill thanh toán.', 3, '2026-04-21 01:25:29', '2026-04-21 01:25:29'),
(16, 7, 'shipping', 'Đang giao', 'Đơn hàng đã có bill chuyển khoản và được chuyển sang trạng thái đang giao.', 3, '2026-04-21 01:25:29', '2026-04-21 01:25:29'),
(17, 8, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 3, '2026-04-21 03:16:05', '2026-04-21 03:16:05'),
(18, 8, 'payment_paid', 'Đã thanh toán MoMo', 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.', 3, '2026-04-21 03:16:15', '2026-04-21 03:16:15'),
(19, 8, 'shipping', 'Đang giao', 'Đơn hàng đã thanh toán MoMo thành công và được chuyển sang trạng thái đang giao.', 3, '2026-04-21 03:16:15', '2026-04-21 03:16:15'),
(20, 8, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-21 03:16:32', '2026-04-21 03:16:32'),
(21, 9, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 4, '2026-04-21 03:43:56', '2026-04-21 03:43:56'),
(22, 9, 'payment_paid', 'Đã thanh toán MoMo', 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.', 4, '2026-04-21 03:44:47', '2026-04-21 03:44:47'),
(23, 9, 'shipping', 'Đang giao', 'Đơn hàng đã thanh toán MoMo thành công và được chuyển sang trạng thái đang giao.', 4, '2026-04-21 03:44:47', '2026-04-21 03:44:47'),
(24, 9, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-21 03:45:08', '2026-04-21 03:45:08'),
(25, 10, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 5, '2026-04-22 01:03:47', '2026-04-22 01:03:47'),
(26, 10, 'payment_paid', 'Đã thanh toán MoMo', 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.', 5, '2026-04-22 01:04:29', '2026-04-22 01:04:29'),
(27, 10, 'shipping', 'Đang giao', 'Đơn hàng đã thanh toán MoMo thành công và được chuyển sang trạng thái đang giao.', 5, '2026-04-22 01:04:29', '2026-04-22 01:04:29'),
(28, 10, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-22 01:05:26', '2026-04-22 01:05:26'),
(29, 11, 'pending', 'Chờ xử lý', 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.', 5, '2026-04-22 01:06:49', '2026-04-22 01:06:49'),
(30, 11, 'payment_paid', 'Đã thanh toán chuyển khoản', 'Khách hàng đã xác nhận chuyển khoản và tải lên bill thanh toán.', 5, '2026-04-22 01:07:17', '2026-04-22 01:07:17'),
(31, 11, 'shipping', 'Đang giao', 'Đơn hàng đã có bill chuyển khoản và được chuyển sang trạng thái đang giao.', 5, '2026-04-22 01:07:17', '2026-04-22 01:07:17'),
(32, 11, 'completed', 'Hoàn tất', 'Đơn hàng đã giao thành công cho khách hàng.', 1, '2026-04-22 01:07:31', '2026-04-22 01:07:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `price`, `quantity`, `material`, `color`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '✨ SOFA NỈ CAO CẤP TÂN CỔ ĐIỂN – SANG TRỌNG NGAY TỪ ÁNH NHÌN ĐẦU TIÊN ✨', 'sofa-ni-cao-cap-tan-co-ien-sang-trong-ngay-tu-anh-nhin-au-tien', 300000000.00, 2, 'Nỉ Cao Cấp', 'Trắng Xám', 'Mã sản phẩm:✨ SOFA NỈ CAO CẤP TÂN CỔ ĐIỂN – SANG TRỌNG NGAY TỪ ÁNH NHÌN ĐẦU TIÊN ✨\r\nXuất xứ / Nhập khẩu: Châu Âu\r\nBảo hành: 24 tháng\r\nPhong cách: Tân cổ điển\r\nKích thước các ghế:\r\nG1:142x102x103 cm\r\nG2:225x102x103cm\r\nG3: 260x102x103cm', 'products/uVmHRqPfCDFzFRHKwRp8DvHcsBYbrH6B2KnkbYt1.jpg', '2026-04-20 08:49:39', '2026-04-21 01:05:56'),
(2, 1, 'Bộ sofa phòng khách nhập khẩu da bò tót', 'bo-sofa-phong-khach-nhap-khau-da-bo-tot', 203000900.00, 2, 'Da bò tót', 'Nâu Gỗ Sồi', 'Mã sản phẩm: SF-W032B-H866\r\nXuất xứ: Tây Ban Nha\r\nChất liệu: Gỗ sồi, Da bò Ý\r\nPhong cách: Tân Cổ Điển', 'products/9rD5lZ91dNAtQQumRiWW0vV8JifaYErdeJ2TwUg9.jpg', '2026-04-20 08:52:31', '2026-04-21 01:01:08'),
(3, 1, 'Sofa Mun VOI Hàng VIP', 'sofa-mun-voi-hang-vip', 500000000.00, 2, 'Đá tự nhiên, Gỗ Mun Nam Phi, Da Bò Tót', 'Xanh Mun', 'SƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\n\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nKÍCH THƯỚC:\r\nBăng 1: 110*90*130CM\r\nBăng 2:195*110*130CM\r\nBăng 4: 290*110*130CM\r\n\r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.\r\n\r\nPhần da: Da ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Lớp da bò tót dày gần 4mm, được lấy từ da bụng của bò tót đực, đảm bảo độ rộng và tính chất mềm mại cho sản phẩm.\r\n\r\nBẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\n\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/CPtmgRGohDfBvti0ovNe0Cj3zaluRa8jREQ6xLr8.jpg', '2026-04-20 08:54:51', '2026-04-20 08:54:51'),
(4, 2, 'Bộ bàn ghế ăn mun phong cách tân cổ điển đơn giản sang trọng', 'bo-ban-ghe-an-mun-phong-cach-tan-co-ien-on-gian-sang-trong', 320300000.00, 0, 'Gỗ mun Nam Phi,', 'Kem', 'Bàn ăn mun tân cổ điển nhập khẩu \r\n1. Thông số kỹ thuật \r\nTên sản phẩm: Bàn ăn mun tân cổ điển nhập khẩu              \r\n\r\nMã sản phẩm: BA-MUN\r\n\r\nMàu sắc: Kem \r\nPhong cách: Tân Cổ Điển\r\nKích thước\r\nBàn ăn: 160x80x75cm\r\nBàn ăn: 180x90x75cm\r\nGhế ăn có tay: 53*62*103cm \r\nGhế ăn k tay: 53*62*103cm\r\n\r\nChất liệu: Gỗ mun Nam Phi, Da bò tót thay đỏi màu da theo yêu cấu, Bàn ăn mặt đá nhân tạo\r\n\r\nXuất xứ: ThaiLan\r\nBảo hành: 24 tháng\r\nBảo trì: Trọn đời sản phẩm\r\n\r\nBàn ăn mun tân cổ điển nhập khẩu BA-MUN là một trong những sản phẩm bàn mặt đá nhận được nhiều quan tâm của khách hàng. Với tính chất nổi bật, dễ vệ sinh, sang trọng, không chỉ giúp tiết kiệm thời gian lau chùi, mà còn tạo không gian quây quần cho gia đình, hoặc làm không gian tiếp khách, bàn ăn mặt đá đang dần thay thế những bàn ăn mặt gỗ truyền thống.\r\n\r\n2. MÔ TẢ SẢN PHẨM\r\n- Phần Gỗ: sofa được làm 100% từ gỗ mun hoa tự nhiên,được tẩm sấy theo công  nghệ Châu âu hiện đại với thời gian sấy khô lên tới 45 ngày , vì thế nó có thể chống lại mọi điều kiện thời tiết khắc nhiệt nhất mà không bị mối mọt cong vênh, nhất là đối với thời tiết ẩm và khô hanh tại Việt Nam.\r\n- Phần Da: Được lựa chọn những mẫu da bò tót tốt nhất đanh dày và bền, được chọn lọc từ những chú bò khỏe mạnh nhất. phần da dùng để bọc đệm sofa được chọn tại phần bụng của Da bò, đây là phần Da có tính đàn hồi tốt, dày, và rộng nhất trên cơ thể Bò đủ điều kiện tốt nhất để làm nên một bộ Sofa mang đẳng cấp  chất lượng Châu âu.\r\n- Nước Sơn: Phần sơn của sản phẩm chúng tôi áp dụng công nghệ sơn oto 7 lớp, tạo nên một lớp sơn có độ dày lên tới 2mm, có tác dụng bảo vể phần gỗ không bị trực tiếp tiếp xúc với môi trường bên ngoài, bảo vệ phần khung gỗ tốt nhất và bền nhất theo thời gian.', 'products/EnITzggmwsYygGXni7dYbBPNfolG4wJAhOp2NbGx.jpg', '2026-04-20 08:58:58', '2026-04-21 01:16:52'),
(5, 2, 'Bàn ăn Hiện đại nhập khẩu sang trọng', 'ban-an-hien-ai-nhap-khau-sang-trong', 80000000.00, 1, 'Gỗ Mun Nam Phi, Da bò Ý', 'Xanh dương', 'Tên sản phẩm: Bộ Bàn Ghế Ăn Phong Cách Bắc Âu Tinh Tế Sang Trọng                                                \r\n\r\nMàu sắc: Xanh dương\r\nPhong cách: Tân cổ điển\r\nChất liệu: Khung gỗ mun, Da bò tót\r\nXuất xứ: Hong Kong\r\nBảo hành: 1 năm\r\nBảo trì: Bảo trì suốt quãng đời sản phẩm \r\n\r\n\r\nSƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.\r\nPhần da:\r\n\r\nDa ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng.\r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\n\r\nBẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/DrzdwmXLQc4M81JNmHU3m8r6CrXKmuchr8kRYOi7.jpg', '2026-04-21 02:21:21', '2026-04-21 02:21:21'),
(6, 3, 'HỘP ĐỰNG TRANG SỨC VÀNG PHONG CÁCH TÂN CỔ ĐIỂN SANG TRỌNG HNT4', 'hop-ung-trang-suc-vang-phong-cach-tan-co-ien-sang-trong-hnt4', 1500000.00, 7, 'Đồng mạ vàng 24K', 'Vàng', 'HỘP ĐỰNG TRANG SỨC VÀNG PHONG CÁCH TÂN CỔ ĐIỂN SANG TRỌNG HNT4\r\n\r\n* THÔNG SỐ KĨ THUẬT\r\n- Tên sản phẩm: HỘP ĐỰNG TRANG SỨC VÀNG PHONG CÁCH TÂN CỔ ĐIỂN SANG TRỌNG HNT4\r\n- Mã SP: HNT4\r\n- Chất liệu: hợp kim mạ vàng cao cấp\r\n- Màu sắc: VÀng\r\n- Kích thước:  16*11*10cm\r\n- Xuất xứ: Nhập khẩu nguyên chiếc tại Hong Kong\r\n------------------------------------\r\n\r\n* MÔ TẢ SẢN PHẨM:\r\n\r\n- Hộp_đựng_nữ trang vàng sang trọng mang đậm trong mình phong cách thiết kế châu Âu cổ điển đương đại. Cùng chất liệu #hợp kim_cao_cấp, họa tiết hoa văn vàng - đính ngọc bắt mắt tạo điểm nhấn nổi bật ở bất cứ bàn trang điểm nào.\r\n\r\n- Với hộp đựng nữ trang đính ngọc cao cấp  không chỉ đơn thuần là đồ vật để đựng nữ trang mà còn là #đồ decor_trang_trí mà hơn hết sản phẩm còn là tác phẩm nghệ thuật được tạo nên bằng sự dày công tỉ mỉ tận tâm của nghệ nhân với thiết kế đậm chất cổ điển đương đại của phương tây\r\n\r\n- Với phong cách riêng mang đậm chất riêng #hộp_nữ trang  là sự lựa chọn không thể tuyệt vời hơn để bày biện trên bàn phấn của nhà mình.\r\n\r\n- Sản phẩm thích hợp để bạn làm quà tặng cho người thân, bạn bè... rất sang trọng\r\n\r\n------------------------------------\r\n* CAM KẾT của nhà Bán\r\n+ Sản phẩm đúng với mô tả.\r\n+ Sản phẩm được kiểm tra kỹ trước khi giao tới khách hàng.\r\n+ Sản phẩm được bảo hành 1 năm.\r\n=> 1 đổi 1 trong vòng 3 ngày, miễn phí đổi trả nếu có lỗi từ nhà sản xuất hoặc vận chuyển.\r\n------------------------------------\r\n* CHÍNH SÁCH BẢO HÀNH\r\nQúy khách vui lòng liên hệ trực tiếp với Shop nếu xảy ra bất cứ vấn đề gì\r\nNhận hàng quý khách vui lòng quay video bóc sản phẩm để được bảo hành từ nhà bán hàng.\r\nĐổi trả 1/1 nếu sản phẩm bị lỗi do nhà sản xuất, vỡ trong quá trình vận chuyển\r\nMọi thắc mắc về sản phẩm, phương thức đặt hàng , bảo hành sản phẩm vui lòng liên hệ trực tiếp với Shop để được hỗ trợ tốt nhất.\r\n------------------------------------\r\n* Đóng gói sản phẩm\r\nMỗi một sản phẩm gửi đi đều được test và chọn lựa kĩ càng.\r\nSản phẩm đều được bọc nhiều lớp xốp và bọc chống vỡ, va đập trong quá trình vận chuyển.', 'products/OT0Jtee8tXCdQvEgi2WL6TlDN0LSecJisQJGXFgB.jpg', '2026-04-21 02:24:54', '2026-04-21 02:24:54'),
(7, 3, 'GHẾ RÙA THƯ GIÃN TÔNG TRẮNG - GH-RUA-TRANG', 'ghe-rua-thu-gian-tong-trang-gh-rua-trang', 15000000.00, 2, 'Gỗ sồi, Da bò Italia', 'Nâu', 'GHẾ RÙA THƯ GIÃN TÔNG TRẮNG - GH-RUA-TRANG\r\n\r\n* THÔNG SỐ KĨ THUẬT\r\n - Tên sản phẩm: GHẾ RÙA THƯ GIÃN TÔNG TRẮNG - GH-RUA-TRANG\r\n - Mã SP: GH-RUA-TRANG\r\n - Chất liệu: Gỗ sồi, da dò italia\r\n - Màu sắc: Nâu\r\n - Kích thước: 1000*650*300\r\n - Xuất xứ: Nhập khẩu nguyên chiếc tại Hong Kong\r\n------------------------------------\r\n* MÔ TẢ SẢN PHẨM\r\n\r\n- Ghế rùa được điêu khắc tỉ mẩn, từng chi tiết tinh xảo, da bò mềm mại ngồi thư giãn.\r\n\r\n- Rùa được biết đến là một trong tứ linh thần thú trấn giữ bốn phương. Tứ linh đó là Long, Lân, Quy, Phụng trấn giữ các hướng đông, tây, bắc, nam. Rùa là loài vật linh thiêng mang lại điềm lành, tài lộc cho gia chủ. ... Do vậy mà biểu tượng Rùa trong phong thủy tượng trưng cho công thành danh toại.\r\n\r\n- Ghế có thế phối hợp với các bộ sofa phòng khách, hoặc bàn ngồi bệt cực đẹp và đáng yêu.\r\n\r\n------------------------------------\r\n* CAM KẾT của nhà Bán\r\n- Sản phẩm đúng với mô tả.\r\n\r\n- Sản phẩm được kiểm tra kỹ trước khi giao tới khách hàng.\r\n\r\n- Sản phẩm được bảo hành 1 năm.\r\n- 1 đổi 1 trong vòng 3 ngày, miễn phí đổi trả nếu có lỗi từ nhà sản xuất hoặc vận chuyển.', 'products/LlVaYccaREp72NUshW1es5zJ3FDUfNXvh74fo4ts.jpg', '2026-04-21 02:34:12', '2026-04-21 03:43:56'),
(8, 3, 'Tủ Nữ Trang Phủ Nhung Tân Cổ Điển Cao Cấp TNT01', 'tu-nu-trang-phu-nhung-tan-co-ien-cao-cap-tnt01', 2000000.00, 2, 'Gỗ sồi, Hợp kim mạ vàng', 'Nâu', '1. Chi tiết sản phẩm\r\n\r\nTên sản phẩm: \r\nTủ Nữ Trang Phủ Nhung Tân Cổ Điển Cao Cấp TNT01\r\n------------------------------------ \r\n THÔNG SỐ KĨ THUẬT:\r\n Mã SP: TNT01\r\n\r\n Chất liệu: Gỗ sồi cao cấp, hợp kim \r\n Kích thước:20 x 19 x 29cm\r\n Xuất xứ: Nhập khẩu nguyên chiếc tại Hong Kong\r\n------------------------------------ \r\n MÔ TẢ SẢN PHẨM: \r\n\r\nTủ đựng trang sức kết hợp giữa phong cách cổ điển và hiện đại tuy chỉ là chi tiết nhỏ nhưng cũng điểm tô cho không gian phòng thêm đẳng cấp, thời thượng thể hiện gout thẩm mỹ của gia chủ. \r\n\r\nSản phẩm được thiết kế nhiều ngăn bằng chất liệu gỗ sồi bền bỉ, có thể đựng các trang sức như vòng tay, vòng cổ, hoa tai, nhẫn... Bên trong tủ đựng trang sức được lót lớp nhung mềm, giúp giữ nữ trang luôn sáng bóng, tránh xước, đặc biệt với các loại đá quý hay ngọc trai. Tay kéo sản phẩm bằng hợp kim chắc chắn, dùng lâu không bị lung lay.\r\nNếu đã sở hữu không gian tân cổ điển sang trọng như biệt thự, chung cư cao cấp, lâu đài,.. bạn không thể bỏ qua món đồ tinh tế này.\r\n\r\n\r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\n\r\n \r\n\r\n- BẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\n- VẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng', 'products/xy8koiG3MgjYwydht3byARCNDZD9yVcQuCfubzRc.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(9, 3, 'HỘP ĐỂ NỮ TRANG TÂN CỔ ĐIỂN HỌA TIẾT AI CẬP CỔ ĐẠI HNT2-A', 'hop-e-nu-trang-tan-co-ien-hoa-tiet-ai-cap-co-ai-hnt2-a', 700000.00, 11, 'Đồng thau', 'Đồng', '1. Chi tiết sản phẩm\r\n\r\nTên sản phẩm: \r\nHỘP ĐỂ NỮ TRANG TÂN CỔ ĐIỂN HỌA TIẾT AI CẬP CỔ ĐẠI HNT2-A\r\n------------------------------------ \r\n THÔNG SỐ KĨ THUẬT:\r\n Mã SP: HNT2-A\r\n\r\n Chất liệu: đồng thau với lớp lót nhung bên trong chống xây xước trang sức\r\n Kích thước: 13x8x7cm\r\n Xuất xứ: Nhập khẩu nguyên chiếc tại Hong Kong\r\n------------------------------------ \r\n MÔ TẢ SẢN PHẨM: \r\n\r\nTrang sức để ở ngoài môi trường, tiếp xúc trực tiếp với không khí và những mức nhiệt độ khác nhau sẽ dễ xảy ra tình trạng han rỉ, bay màu. Hay đơn giản trang sức là những phụ kiện với kích thước nhỏ thường hay bị thất lạc, rơi vỡ. Vậy nên hộp đựng trang sức là một món đồ nên có ở bàn trang điểm của các chị/em\r\n\r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\n\r\n \r\n\r\n- BẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\n- VẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng', 'products/ID3BESDJS3ZsDLgncfvntr1uimNH8WdFHkmdR8qV.jpg', '2026-04-21 02:38:02', '2026-04-21 03:16:05'),
(10, 3, 'Giá treo quần áo cao cấp', 'gia-treo-quan-ao-cao-cap', 1592000.00, 2, 'Hợp kim mạ vàng', 'Vàng', '1. Giới thiệu sản phẩm\r\n\r\nTên sản phẩm:   Giá treo quần áo cao cấp \r\n\r\n------------------------------------ \r\n THÔNG SỐ KĨ THUẬT\r\n Mã SP: \r\n Chất liệu: Hợp kim mạ vàng \r\n Kích thước: 31x180cm \r\n\r\n Xuất xứ: Nhập khẩu nguyên chiếc tại Hong Kong\r\n \r\n------------------------------------ \r\n MÔ TẢ SẢN PHẨM\r\n- Các giá treo được sử dụng nhằm làm cho tủ quần áo trở nên gọn gàng hơn, ngăn nắp hơn. Sự sắp xếp khoa học các bộ quần áo trên giá treo đảm bảo không gian căn phòng chuyên nghiệp hơn. Đồng thời nó còn góp phần làm thông thoáng không gian.\r\n\r\n \r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\n\r\n- BẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\n- VẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng', 'products/6KN3aijJKpywtEs5WgrggsJL3JvT2T2sE6jJ3mq7.jpg', '2026-04-21 02:39:59', '2026-04-22 01:03:47'),
(11, 3, 'Giường liền tap mun voi khủng bọc da bò tót nhập khẩu', 'giuong-lien-tap-mun-voi-khung-boc-da-bo-tot-nhap-khau', 200000000.00, 2, 'Gỗ Mun Nam Phi', 'Tân cổ điển', 'GIƯỜNG NGỦ MUN VOI LIỀN TÁP BỌC  DA BÒ TÓT TÂN CỔ ĐIỂN NHẬP KHẨU \r\n\r\n1.Chi tiết sản phẩm\r\n\r\nThông số kỹ thuật:\r\nTên sản phẩm: GIƯỜNG NGỦ MUN VOI KHỦNG QUYỀN QUÝ      \r\nMàu sắc : Cam đất, nhận thay đổi màu da theo yêu cầu      \r\nPhong cách : Tân cổ điển   \r\nChất liệu :   Khung gỗ mun, Da bò tót\r\nXuất xứ : Hong Kong\r\nBảo hành :  24 tháng, bảo trì trọn đời\r\nKích Thước : 375*265*180cm \r\n- XUẤT XỨ: Sản phẩm được nhập khẩu nguyên kiện chính hãng 100%.\r\n- CHẤT LIỆU: Gỗ mun Nam Phi, đạt chuẩn FAS, được tẩm sấy theo công nghệ Châu Âu hiện đại với thời gian sấy khô lên tới 45 ngày, có thể chống lại mọi điều kiện thời tiết khắc nghiệt nhất mà không bị mối mọt cong vênh. Với chất gỗ cứng, khả năng tạo hình tốt, gỗ mun Nam Phi là một trong những lựa chọn hàng đầu cho sản phẩm gường ngủ \r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng. \r\n\r\nPhần da: Da đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò tót dày bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng.\r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\nBẢO HÀNH: 24 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/zPtJngMMcheeWy72ZV2j8VcutCJAgYd35cGwMVJh.jpg', '2026-04-21 02:45:13', '2026-04-21 02:45:13'),
(12, 3, 'Giường ngủ hoàng gia tân cổ điển', 'giuong-ngu-hoang-gia-tan-co-ien', 7920000.00, 10, 'Gỗ sồi, Da bò Italia', 'Kem', 'Phong cách :  Tân cổ điển\r\nKích thước :  2mx2m2\r\nChất liệu :  Gỗ Sồi, da bò Italy\r\nXuất xứ :  Nhập khẩu Hong Kong\r\nBảo hành :  18 tháng\r\nBảo trì :  Trọn đời sản phẩm\r\nSƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nPhần gỗ: Sản phẩm được làm 100% từ gỗ Oak tự nhiên, đạt chuẩn FAS, được tẩm sấy theo công nghệ Châu Âu hiện đại với thời gian sấy khô lên tới 45 ngày, có thể chống lại mọi điều kiện thời tiết khắc nghiệt nhất mà không bị mối mọt cong vênh. Với chất gỗ cứng, khả năng tạo hình tốt, gỗ sồi trắng là một trong những lựa chọn hàng đầu cho sản phẩm gường.\r\n\r\nPhần da: Da đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng.\r\n\r\n2.Chính sách bảo hành và giao hàng liên tỉnh \r\nBẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/vmELUyNxyByb8nwetVHGnPIJelrWlx3y5QMvcA6U.jpg', '2026-04-21 02:49:04', '2026-04-21 02:49:04'),
(13, 3, 'Giường Tân cổ điển sang trọng đẳng cấp HCBC', 'giuong-tan-co-ien-sang-trong-ang-cap-hcbc', 96000000.00, 100, 'Gỗ Mun Nam Phi, Da bò Ý', 'Nâu', 'Mã sản phẩm : BED-MUN-1803\r\n Xuất xứ : Nhập khẩu\r\n Chất liệu : Gỗ Mun Nam Phi, Da Bò Tót\r\n Bảo hành : 18 tháng\r\n Phong cách : Tân cổ điển \r\nXUẤT XỨ: Sản phẩm được nhập khẩu nguyên thùng, nguyên kiện chính hãng 100%.\r\nCHẤT LIỆU: Gỗ sồi trắng nhập khẩu kết hợp Da bò Ý nguyên miếng.\r\nSƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\nPhần gỗ: Sản phẩm được làm 100% từ gỗ Oak tự nhiên, đạt chuẩn FAS, được tẩm sấy theo công nghệ Châu Âu hiện đại với thời gian sấy khô lên tới 45 ngày, có thể chống lại mọi điều kiện thời tiết khắc nghiệt nhất mà không bị mối mọt cong vênh. Với chất gỗ cứng, khả năng tạo hình tốt, gỗ sồi trắng là một trong những lựa chọn hàng đầu cho sản phẩm gường ngủ', 'products/tuj3vahFMzbFtxy2Z0NOwXIUZHIsSNOjUDi50nov.jpg', '2026-04-21 02:53:04', '2026-04-21 02:53:04'),
(14, 2, 'Bộ bàn ghế ăn Alexander cao cấp BA-NU-064 and GHA-NU-710B', 'bo-ban-ghe-an-alexander-cao-cap-ba-nu-064-and-gha-nu-710b', 400000400.00, 100, 'Khung gỗ thịt, bọc da bò Italia và nỉ', 'Nâu bò và đỏ đô', 'Mã sản phẩm : BA-NU-064 and GHA-NU-710B\r\nMàu sắc :  Nâu bò và đỏ đô\r\nPhong cách :  Tân cổ điển\r\nKích thước : BA-NU-064: 210*105*78cm\r\nChất liệu :  Khung gỗ thịt, bọc da bò Italia và nỉ\r\nXuất xứ :  Hong Kong\r\nBảo hành :  24 tháng \r\nBảo trì :  Bảo trì suốt quãng đời sản phẩm', 'products/6mgJrLk82wtuvNXBVGgycT82kyylHCVt9O9h7Eod.jpg', '2026-04-21 03:00:37', '2026-04-21 03:00:37'),
(15, 2, 'Bộ Bàn Ăn Da Bò Cao Cấp Tân Cổ Điển', 'bo-ban-an-da-bo-cao-cap-tan-co-ien', 1000000000.00, 20, 'Gỗ sồi, Da bò Italia', 'Trắng', 'Tên sản phẩm : Bộ Bàn Ăn Da Bò Cao Cấp Tân Cổ Điển                                                \r\nMàu sắc : Trắng\r\nPhong cách :  Tân cổ điển\r\nChất liệu :  Khung gỗ sồi, Da bò Italia\r\nXuất xứ :  Hong Kong\r\nBảo hành :  1 năm \r\nBảo trì :  Bảo trì suốt quãng đời sản phẩm  \r\n- Mô tả sản phẩm \r\n\r\nPhần gỗ: Sản phẩm được làm 100% từ gỗ Oak tự nhiên, đạt chuẩn FAS, được tẩm sấy theo công nghệ Châu  u hiện đại với thời gian sấy khô lên tới 45 ngày, có thể chống lại mọi điều kiện thời tiết khắc nghiệt nhất mà không bị mối mọt cong vênh. Với chất gỗ cứng, khả năng tạo hình tốt, gỗ sồi trắng là một trong những lựa chọn hàng đầu cho sản phẩm ghế xoay làm việc.\r\n\r\nPhần da: Da ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng. \r\n\r\nVới thiết kế đệm da ở phần ngồi và phần lưng tựa của ghế, người dùng sẽ cảm thấy dễ chịu, thoải mái mà không ảnh hưởng đến sức khỏe. Các chi tiết hoa văn xung quanh ghế cũng góp phần tô điểm thêm cho không gian làm việc tinh tế hơn. Nhờ đó, bạn sẽ có hứng thú làm việc hiệu quả hơn', 'products/oTPGR5wSKeaFqQq8mffcxGWe2qbxYq2nb9sPZRHH.jpg', '2026-04-21 03:03:56', '2026-04-21 03:05:21'),
(16, 2, 'Bàn ghế ăn sang trọng cho Lâu đài', 'ban-ghe-an-sang-trong-cho-lau-ai', 300000000.00, 30, 'Gỗ sồi, Da bò Italia', 'Trắng', 'Tên sản phẩm : Bàn ghế ăn sang trọng cho Lâu đài                               \r\nMàu sắc :  Trắng\r\nPhong cách : Tân Cổ Điển\r\nChất liệu : Gỗ sồi\r\nXuất xứ : Nhập khẩu \r\nBảo hành : 18 tháng\r\nBảo trì : Trọn đời sản phẩm\r\n- Mô tả sản phẩm\r\n\r\nPhần gỗ: Sản phẩm được làm 100% từ gỗ Oak tự nhiên, đạt chuẩn FAS, được tẩm sấy theo công nghệ Châu  u hiện đại với thời gian sấy khô lên tới 45 ngày, có thể chống lại mọi điều kiện thời tiết khắc nghiệt nhất mà không bị mối mọt cong vênh. Với chất gỗ cứng, khả năng tạo hình tốt, gỗ sồi trắng là một trong những lựa chọn hàng đầu cho sản phẩm bộ bàn ghế gỗ phòng khách.\r\nPhần da: Da ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng.', 'products/MVYoday4NYKKeyoynOTgnEG6nNynWM1blpmuQJ7K.jpg', '2026-04-21 03:08:56', '2026-04-21 03:08:56'),
(17, 2, 'Bàn ăn Gỗ Mun cao cấp nhập khẩu', 'ban-an-go-mun-cao-cap-nhap-khau', 95000000.00, 100, 'Da bò Italia, Gỗ Mun Nam Phi', 'Xanh dương', 'Tên sản phẩm : Bộ Bàn Ghế Ăn Phong Cách Bắc Âu Tinh Tế Sang Trọng                                                \r\nMàu sắc :  Xanh dương\r\nPhong cách :  Tân cổ điển\r\nChất liệu :  Khung gỗ mun, Da bò Tót \r\nXuất xứ :  Hong Kong \r\nBảo hành :  1 năm\r\nBảo trì :  Bảo trì suốt quãng đời sản phẩm  \r\nSƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.\r\nDa ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử dụng.', 'products/4Z6RIZBqjbcF5uJoHc10gBm62C6MRywttIARfguH.jpg', '2026-04-21 03:13:16', '2026-04-21 03:13:16'),
(18, 2, 'Đĩa quả tân cổ điển nhập khẩu DQ-102', 'ia-qua-tan-co-ien-nhap-khau-dq-102', 3300000.00, 49, 'Composite, Sứ Trắng', 'Vàng', 'MÔ TẢ SẢN PHẨM:\r\n\r\n- Đây là một chiếc khay trang trí cao cấp với thiết kế hoàng gia:\r\n\r\nChất liệu: Gốm sứ cao cấp kết hợp với composite mạ vàng sang trọng.\r\n\r\nThiết kế: Hoa văn hoa lá tinh xảo, tay cầm uốn lượn mạ vàng, chân đế chạm khắc cầu kỳ.\r\n\r\nMàu sắc: Bên ngoài họa tiết hoa vintage, bên trong tráng men đỏ nổi bật.\r\n\r\nCông dụng: Dùng để đựng hoa quả, bánh kẹo hoặc làm vật trang trí, tạo điểm nhấn quý phái cho không gian.\r\n\r\n• Đĩa quả phong cách tân cổ điển là món đồ sang trọng và tinh tế không thể thiếu trong mỗi không gian sang trọng trong các Căn Biệt thự, Dinh thự, Nhà Hàng và Khách sạn 5*, Chung cư cao cấp, … Nó vừa là đồ dùng trên bàn tiệc, vừa là đồ trang trí đẹp. \r\n• Đĩa quả càng sang trọng tinh tế càng là điểm nhấn trong không gian: phòng khách, trên bàn tiệc, phòng bếp, …Ngoài ra đây còn là quà biếu tặng hoàn hảo và ý nghĩa dành cho người thân, bạn bè, khách hàng, đối tác, sếp, tân gia, khai trương, cưới hỏi, … \r\n* CAM KẾT TỪ NHÀ BÁN HÀNG:\r\n\r\n+ Sản phẩm đúng với mô tả.\r\n\r\n+ Sản phẩm được kiểm tra kỹ trước khi giao tới khách hàng.\r\n\r\n=> 1 đổi 1 trong vòng 3 ngày, miễn phí đổi trả nếu có lỗi từ nhà sản xuất hoặc vận chuyển.', 'products/Z2fmzFKfmd8OO793zSr0ynuTSNypoY4Lp0yyDwkO.jpg', '2026-04-21 03:19:41', '2026-04-22 01:06:49'),
(19, 2, 'Bàn ăn hiện đại gỗ Mun Nam Phi', 'ban-an-hien-ai-go-mun-nam-phi', 67000444.00, 10, 'Gỗ Mun Nam Phi, Da bò Ý', 'Trắng kem', 'Tên sản phẩm  : Bộ Bàn Ghế Ăn Phong Cách Bắc Âu Tinh Tế Sang Trọng                 \r\nMàu sắc :  Trắng kem \r\nPhong cách :  Tân cổ điển\r\nChất liệu :  Khung gỗ mun, Da bò Tót\r\nXuất xứ :  Hong Kong\r\nBảo hành :  1 năm \r\nBảo trì :  Bảo trì suốt quãng đời sản phẩm  \r\nSƠN PHỦ: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMÀU SẮC SƠN PHỦ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMÀU SẮC DA: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.   \r\nDa ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Các sản phẩm từ da bò Italy đều bền bỉ, không bị phai màu theo thời gian, dễ dàng vệ sinh và làm sạch. Đặc biệt, các sản phẩm da bò Italy càng sử dụng thì bề mặt da sẽ càng mềm, sáng bóng và dễ chịu cho người sử d', 'products/iXlOOZasMTnEqdZMjEzYh7mab3UkBtOlbSkFjZEK.jpg', '2026-04-21 03:23:11', '2026-04-21 03:23:11'),
(20, 1, 'sofa tân cổ điển nhập khẩu cao cấp', 'sofa-tan-co-ien-nhap-khau-cao-cap', 100000000.00, 10, 'Gỗ tự nhiên', 'Vàng', 'Mã sản phẩm : sofa tân cổ điển nhập khẩu cao cấp\r\n  Xuất xứ : Nhập khẩu\r\n Chất liệu : Gỗ tự nhiên\r\n  Bảo hành : 24 tháng\r\n  Phong cách : Tân cổ điển\r\nSOFA ĐẲNG CẤP HOÀNG GIA DÁT VÀNG 24K – BIỂU TƯỢNG QUYỀN QUÝ & SANG TRỌNG\r\nSofa hoàng gia dát vàng 24K là tuyệt tác nội thất dành cho không gian thượng lưu. Thiết kế tân cổ điển tinh xảo, chạm khắc thủ công sắc nét, phủ lớp vàng 24K cao cấp tạo nên vẻ đẹp lộng lẫy, bền bỉ theo thời gian.\r\nKhung gỗ tự nhiên tuyển chọn chắc chắn, đệm mút cao cấp đàn hồi êm ái, bọc da/nỉ nhập khẩu sang trọng. Mỗi bộ sofa không chỉ là nơi tiếp khách mà còn là tuyên ngôn đẳng cấp của gia chủ.', 'products/0iAB5iXqMAKWt74lDikPnPQbXlPIeI9l8ITAyJ8i.jpg', '2026-04-21 03:28:35', '2026-04-21 03:28:45'),
(21, 1, 'Sofa mun đính ngọc tân cổ điển nhập khẩu', 'sofa-mun-inh-ngoc-tan-co-ien-nhap-khau', 250000000.00, 34, 'Gỗ Mun Nam Phi, Da Bò Tót', 'Cam đất', 'Tên sản phẩm :  SOFA MUN VƯƠNG MIỆN KHỦNG QUYỀN QUÝ          \r\nMàu sắc : Cam đất, nhận thay đổi màu da theo yêu cầu     \r\nPhong cách : Tân cổ điển \r\nChất liệu :  Khung gỗ mun, Da bò tót \r\nXuất xứ :  Hong Kong \r\nBảo hành :  24 tháng, bảo trì trọn đời \r\nKích Thước : 	\r\nGhế 1: 166*105*128cm\r\nGhế 2 : 210*105*128cm\r\nGhế 4: 291*105*128cm \r\n1.Chi tiết sản phẩm\r\n\r\nXuất xứ: Sản phẩm được nhập khẩu nguyên thùng, nguyên kiện chính hãng 100%.\r\nChất liệu: Gỗ mun Nam Phi kết hợp Da bò tót Italia.\r\nSơn phu: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\nMàu sắc sơn phủ: Có thể thay đổi theo yêu cầu của khách hàng.\r\nMàu sắc da: Có thể thay đổi theo yêu cầu của khách hàng.     \r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.\r\n\r\nPhần da: Da ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Lớp da bò tót dày gần 4mm, được lấy từ da bụng của bò tót đực, đảm bảo độ rộng và tính chất mềm mại cho sản phẩm.', 'products/mXKIhOUJqFcGdKTBCoWPawB7A7r9LhLowrv6B1aI.jpg', '2026-04-21 03:33:07', '2026-04-21 03:33:07'),
(22, 1, 'Sofa mun phong cách đơn giản', 'sofa-mun-phong-cach-on-gian', 1000000.00, 10, 'Gỗ Mun Nam Phi', 'Xanh Lục', 'Xuất xứ : Nhập khẩu\r\n Chất liệu : Gỗ Mun Nam Phi\r\n  Bảo hành : 24 tháng\r\n Phong cách : Tân cổ điển\r\n SOFA GỖ MUN DA BÒ TÓT NHẬP KHẨU\r\n\r\nSofa êm mượt thoải mái và sang trọng luôn là đích đến của gia chủ, ở HCBC chúng tôi có những mẫu sofa có đầy đủ các đặc tính này, mời quý khách cùng tham quan và mua sắm.\r\n1.Chi tiết sản phẩm\r\n\r\nXuất xứ: Sản phẩm được nhập khẩu nguyên thùng, nguyên kiện chính hãng 100%.\r\n\r\nChất liệu: Gỗ mun Nam Phi kết hợp Da bò tót Italia.\r\n\r\nSơn phu: sơn tĩnh điện 7 lớp thân thiện với môi trường.\r\n\r\nMàu sắc sơn phủ: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nMàu sắc da: Có thể thay đổi theo yêu cầu của khách hàng.\r\n\r\nPhần gỗ: Gỗ mun là loại gỗ cao cấp, không bị mối mọt, rất bền, không mục, càng sử dụng lâu năm gỗ càng bóng đẹp, ít cong vênh, khó xước. Có rất ít loại gỗ tự nhiên thuộc dạng quý hiếm mà tốt như gỗ mun.\r\n\r\nPhần da: Da ghế đạt chuẩn NAPPA – loại da tốt, mịn, thoáng khí, đặc biệt mềm mại, dẻo xốp, có độ đàn hồi cao. Lớp da bò tót dày gần 4mm, được lấy từ da bụng của bò tót đực, đảm bảo độ rộng và tính chất mềm mại cho sản phẩm.', 'products/EXse1Ta6MMQ0SsBX4NqtZ0AEMgMAR3ZpOE3BDufz.jpg', '2026-04-21 03:35:51', '2026-04-21 03:35:51'),
(23, 1, 'Sofa Quý Tộc Phong Cách Tân Cổ Điển', 'sofa-quy-toc-phong-cach-tan-co-ien', 1000000000.00, 1, 'Gỗ sồi, Nỉ, Da bò Italia', 'Nâu', 'Xuất xứ : Nhập khẩu\r\n  Chất liệu : Gỗ sồi, Nỉ, Da bò Italia\r\n  Bảo hành : 12 tháng\r\n  Phong cách :  Tân cổ điển\r\n  Sofa Kiểu Dáng Tân Cổ Điển, Sang Trọng\r\nSofa êm mượt thoải mái và sang trọng luôn là đích đến của gia chủ, ở HCBC chúng tôi có những mẫu sofa có đầy đủ các đặc tính này, mời quý khách cùng tham quan và mua sắm.\r\nBẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/5aajsFtH2AJj0lABW9UUtgSqLcOh9M8zsdho5vRS.jpg', '2026-04-21 03:38:22', '2026-04-21 03:38:22'),
(24, 1, 'SOFA TÂN CỔ ĐIỂN NHẬP KHẨU SF-8805S-H866', 'sofa-tan-co-ien-nhap-khau-sf-8805s-h866', 197000000.00, 3, 'Gỗ Mun Nam Phi', 'Nâu', 'Mã sản phẩm : SF-8805S-H866\r\n  Xuất xứ : Nhập khẩu\r\n  Chất liệu : Gỗ Mun Nam Phi\r\n  Bảo hành : 18 tháng\r\n  Phong cách : Tân cổ điển\r\n \r\n1.Chính sách bảo hành và giao hàng liên tỉnh \r\nBẢO HÀNH: 18 tháng, sản phẩm được đổi mới trong vòng 07 ngày nếu sản phẩm bị lỗi do nhà sản xuất, hỗ trợ bảo trì sửa chữa trọn đời sản phẩm.\r\nVẬN CHUYỂN: Sản phẩm được kiểm tra kỹ càng và đóng gói nguyên thùng, nguyên kiện, có lớp xốp chống sốc bảo vệ sản phẩm một cách tốt nhất khi vận chuyển đến tay khách hàng.', 'products/XXZErxS2YQOiWIB7emqwVzNTWIJI3VUsKdCRVJZE.jpg', '2026-04-21 03:40:33', '2026-04-21 03:40:33'),
(25, 5, 'BỘ GHẾ GỖ PHÒNG KHÁCH - ĐẲNG CẤP CHO KHÔNG GIAN SỐNG', 'bo-ghe-go-phong-khach-ang-cap-cho-khong-gian-song', 29000000.00, 1, 'Gỗ sồi, Da bò Italia', 'Nâu', 'Mã sản phẩm: GM-02\r\nXuất xứ: Nhập khẩu\r\nPhong cách: Tân cổ điển', 'products/CN9evX6cxpTyR6e2Y4I70RaLkEnSTi6NoBhbCEZg.jpg', '2026-04-21 03:51:41', '2026-04-21 03:51:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 5, 'products/DrzdwmXLQc4M81JNmHU3m8r6CrXKmuchr8kRYOi7.jpg', '2026-04-21 02:21:21', '2026-04-21 02:21:21'),
(2, 5, 'products/NTwbqU5C3ELQcco1IQoWGoHzEizZRmQF2v0iTXdw.jpg', '2026-04-21 02:21:21', '2026-04-21 02:21:21'),
(3, 6, 'products/OT0Jtee8tXCdQvEgi2WL6TlDN0LSecJisQJGXFgB.jpg', '2026-04-21 02:24:54', '2026-04-21 02:24:54'),
(4, 6, 'products/3lZKltkeR2dn0rEcPEX8h1QvbmFrWLzy2Onh0C3y.jpg', '2026-04-21 02:24:54', '2026-04-21 02:24:54'),
(5, 6, 'products/sU8rJDitqLnbrEGgzP7f52f4Z2bZ0HMGfZVTEZHl.jpg', '2026-04-21 02:24:54', '2026-04-21 02:24:54'),
(6, 7, 'products/LlVaYccaREp72NUshW1es5zJ3FDUfNXvh74fo4ts.jpg', '2026-04-21 02:34:12', '2026-04-21 02:34:12'),
(7, 7, 'products/5dlW6qnOWkSZeErXiUIhqCx9V3YkpP8kdM0wkOV1.jpg', '2026-04-21 02:34:12', '2026-04-21 02:34:12'),
(8, 7, 'products/hh6pljpDgC7BkNMfXFowgSrBVLY5MuR75mGPGDmd.jpg', '2026-04-21 02:34:12', '2026-04-21 02:34:12'),
(9, 7, 'products/3rc2ljeGsU2CzhgBno3pKwG7JxT45a6UY62QBz6S.jpg', '2026-04-21 02:34:12', '2026-04-21 02:34:12'),
(10, 8, 'products/xy8koiG3MgjYwydht3byARCNDZD9yVcQuCfubzRc.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(11, 8, 'products/VcZejluhmZSorp9UGmFP0s25EJzYoqlE1qw3KRGe.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(12, 8, 'products/spX1ZeqpewBEknbpNVBox9kRQ6d555HPjUsUqWba.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(13, 8, 'products/TKeNT7AII10m7MfjTDCKkLxvrqrtbR07KdlyySRe.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(14, 8, 'products/skHzCDf2U1O3DJ7WkRaZbK7JwcZsXGbuhBeQl8yX.jpg', '2026-04-21 02:36:21', '2026-04-21 02:36:21'),
(15, 9, 'products/ID3BESDJS3ZsDLgncfvntr1uimNH8WdFHkmdR8qV.jpg', '2026-04-21 02:38:02', '2026-04-21 02:38:02'),
(16, 9, 'products/7rmxXgc70PVyvibIjn3LpDJeVNmybF00FYiZJyxK.jpg', '2026-04-21 02:38:02', '2026-04-21 02:38:02'),
(17, 9, 'products/XrheiJnL5JNEMcqpiobtsWFvMp6SZ7wfGOk9nuiY.jpg', '2026-04-21 02:38:02', '2026-04-21 02:38:02'),
(18, 9, 'products/xlgupanRzTmv1U9TBV7ikjZxmupNnevYmDpsNqm5.jpg', '2026-04-21 02:38:02', '2026-04-21 02:38:02'),
(19, 9, 'products/3wyHUxMGmtBYvgF8MI9vXHZuzbf6Lw82Wp3xAjNL.jpg', '2026-04-21 02:38:02', '2026-04-21 02:38:02'),
(20, 10, 'products/6KN3aijJKpywtEs5WgrggsJL3JvT2T2sE6jJ3mq7.jpg', '2026-04-21 02:39:59', '2026-04-21 02:39:59'),
(21, 10, 'products/eJy3Up9XYLCLwEdKu6QnRnDjx0lFimhXcvWHuzoe.jpg', '2026-04-21 02:39:59', '2026-04-21 02:39:59'),
(22, 10, 'products/UpMeyLlPsRbwBGH6raixtm3ctarg9uA6yAKL5dFC.jpg', '2026-04-21 02:39:59', '2026-04-21 02:39:59'),
(23, 11, 'products/zPtJngMMcheeWy72ZV2j8VcutCJAgYd35cGwMVJh.jpg', '2026-04-21 02:45:13', '2026-04-21 02:45:13'),
(24, 12, 'products/vmELUyNxyByb8nwetVHGnPIJelrWlx3y5QMvcA6U.jpg', '2026-04-21 02:49:04', '2026-04-21 02:49:04'),
(25, 13, 'products/tuj3vahFMzbFtxy2Z0NOwXIUZHIsSNOjUDi50nov.jpg', '2026-04-21 02:53:04', '2026-04-21 02:53:04'),
(26, 14, 'products/6mgJrLk82wtuvNXBVGgycT82kyylHCVt9O9h7Eod.jpg', '2026-04-21 03:00:37', '2026-04-21 03:00:37'),
(27, 15, 'products/oTPGR5wSKeaFqQq8mffcxGWe2qbxYq2nb9sPZRHH.jpg', '2026-04-21 03:05:21', '2026-04-21 03:05:21'),
(28, 16, 'products/MVYoday4NYKKeyoynOTgnEG6nNynWM1blpmuQJ7K.jpg', '2026-04-21 03:08:56', '2026-04-21 03:08:56'),
(29, 17, 'products/4Z6RIZBqjbcF5uJoHc10gBm62C6MRywttIARfguH.jpg', '2026-04-21 03:13:16', '2026-04-21 03:13:16'),
(30, 18, 'products/Z2fmzFKfmd8OO793zSr0ynuTSNypoY4Lp0yyDwkO.jpg', '2026-04-21 03:19:41', '2026-04-21 03:19:41'),
(31, 19, 'products/iXlOOZasMTnEqdZMjEzYh7mab3UkBtOlbSkFjZEK.jpg', '2026-04-21 03:23:11', '2026-04-21 03:23:11'),
(32, 20, 'products/0iAB5iXqMAKWt74lDikPnPQbXlPIeI9l8ITAyJ8i.jpg', '2026-04-21 03:28:35', '2026-04-21 03:28:35'),
(33, 20, 'products/6euSGNMsZgyAtl9kjoh6s3dpNlDsRbNFYF9BnfA3.jpg', '2026-04-21 03:28:35', '2026-04-21 03:28:35'),
(34, 20, 'products/tmTwKtJJQAnXh48AKkmx0sr8z7KCkM5zloBRN6SG.jpg', '2026-04-21 03:28:35', '2026-04-21 03:28:35'),
(35, 20, 'products/R4pEr6AstIRe6hKHOnHo3eT6wNruMku6qoqszU3O.jpg', '2026-04-21 03:28:35', '2026-04-21 03:28:35'),
(36, 21, 'products/mXKIhOUJqFcGdKTBCoWPawB7A7r9LhLowrv6B1aI.jpg', '2026-04-21 03:33:07', '2026-04-21 03:33:07'),
(37, 21, 'products/XFyIpM6KOw0FmpG47EwKQh1V9WsdV1zvZjysQxPm.jpg', '2026-04-21 03:33:07', '2026-04-21 03:33:07'),
(38, 21, 'products/Mlzw0zTcvgykw8McF4wGVSh6dyKLyyWnS0TXgXa3.jpg', '2026-04-21 03:33:07', '2026-04-21 03:33:07'),
(39, 21, 'products/OvNuSSenSEWRRkcId7NVvNNnZnGR6yqKJu5wdRQ4.jpg', '2026-04-21 03:33:07', '2026-04-21 03:33:07'),
(40, 22, 'products/EXse1Ta6MMQ0SsBX4NqtZ0AEMgMAR3ZpOE3BDufz.jpg', '2026-04-21 03:35:51', '2026-04-21 03:35:51'),
(41, 23, 'products/5aajsFtH2AJj0lABW9UUtgSqLcOh9M8zsdho5vRS.jpg', '2026-04-21 03:38:22', '2026-04-21 03:38:22'),
(42, 24, 'products/XXZErxS2YQOiWIB7emqwVzNTWIJI3VUsKdCRVJZE.jpg', '2026-04-21 03:40:33', '2026-04-21 03:40:33'),
(43, 25, 'products/CN9evX6cxpTyR6e2Y4I70RaLkEnSTi6NoBhbCEZg.jpg', '2026-04-21 03:51:41', '2026-04-21 03:51:41'),
(44, 25, 'products/DDuBpqCNl9pLKKSQt0L9nagJiuYswTrtcSSvDpqO.jpg', '2026-04-21 03:51:41', '2026-04-21 03:51:41'),
(45, 25, 'products/V2m4rP0J09Et3kIhfXuTkNJkvqO8w6o4YSuDCGeN.jpg', '2026-04-21 03:51:41', '2026-04-21 03:51:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0BNJ4bfIp3TfK7hS1CgtSsGG6LksvcmSf5ec7dBS', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWdkbHdZUnVvQTJ0Vm5waUk0WDIwSVZLMHZEbTdTSDE1RTdIN3A1eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMToiY2xpZW50LmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1776845407),
('VWYWRdZ1eMgODykLxPDnTCeNduRbMtfcNvdkYDYT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia2ZSdG5hT2lpdDFrMUxITEFLb3hmZVZXeWdBb3JmZEFVMFFNOXNJSiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vY3VzdG9tZXJzIjtzOjU6InJvdXRlIjtzOjIxOiJhZG1pbi5jdXN0b21lcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776845429);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address_line` text DEFAULT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL,
  `province_name` varchar(255) DEFAULT NULL,
  `district_id` int(10) UNSIGNED DEFAULT NULL,
  `district_name` varchar(255) DEFAULT NULL,
  `ward_code` varchar(32) DEFAULT NULL,
  `ward_name` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `address_line`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_code`, `ward_name`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '0968498556', 'Hà Nội', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$VjKZFbMM0LDq4uemG.IyR.lNs0MFNCm/R2AyvnJJoh9l0WTiKgf7i', 'admin', '6hNl49toMRybYSi8xEgGPSpuWRgLP8Vnj420bYUy2txTglRbGO6DKPI9FUC0', '2026-04-20 08:12:34', '2026-04-20 08:12:34'),
(2, 'Khổng Lan Hương', 'test@gmail.com', '096848556', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$QxwEzrK/jAupHC5mEoiF7egh3O/5DBYEjkiT8FOQa/uUEIsLZreia', 'customer', NULL, '2026-04-20 23:44:13', '2026-04-20 23:44:13'),
(3, 'Tăng Anh Tuấn', 'lanhuong@gmail.com', '0977665556', '191 - TDP Văn Giàng, Xã Tân Tiến, Thành phố Bắc Giang, Bắc Giang', '191 - TDP Văn Giàng', 248, 'Bắc Giang', 1643, 'Thành phố Bắc Giang', '180116', 'Xã Tân Tiến', NULL, '$2y$12$aYFy9t9uGUScKUhXzMutoeJRv5fsueBdOwg1XjSj49WSkMTdFA6r.', 'customer', 'oYReKbN5wZAYV1CT6I4dXpskZEeUWDXki1KZdH1GOeJr0p6c7VqebNgfnKWm', '2026-04-21 00:17:03', '2026-04-21 00:17:03'),
(4, 'Nguyễn Quang Linh', 'quanglinh2@gmail.com', '0987638383', '200- phường tiền ninh tê, Phường Tiền Ninh Vệ, Thành phố Bắc Ninh, Bắc Ninh', '200- phường tiền ninh tê', 249, 'Bắc Ninh', 1644, 'Thành phố Bắc Ninh', '910074', 'Phường Tiền Ninh Vệ', NULL, '$2y$12$lzC57jSAhqi0E97pptDkwua.68HcdQ.GWkS9EBSQyK1ZesCAjJBrS', 'customer', NULL, '2026-04-21 03:42:28', '2026-04-21 03:42:28'),
(5, 'Đặng Đức Trí', 'tridaumoi@gmail.com', '0975758943', 'Xóm 55, Xã Đông Phong, Huyện Tiền Hải, Thái Bình', 'Xóm 55', 226, 'Thái Bình', 3281, 'Huyện Tiền Hải', '260710', 'Xã Đông Phong', NULL, '$2y$12$Uxdh/dCdbagjGhYr.ZiKfe/JwVe6AmtvOXI1hy4RcuHFsZbcpMDeG', 'customer', NULL, '2026-04-22 01:03:01', '2026-04-22 01:03:01');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_momo_order_id_unique` (`momo_order_id`),
  ADD UNIQUE KEY `orders_momo_request_id_unique` (`momo_request_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_histories_order_id_foreign` (`order_id`),
  ADD KEY `order_status_histories_changed_by_foreign` (`changed_by`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD CONSTRAINT `order_status_histories_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
