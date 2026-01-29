# Thông Tin Dự Án

## Trạng Thái Hệ Thống (Cập nhật ngày 29/01/2026)

### Tài Nguyên Hệ Thống
- **Dung lượng đĩa**: ~20% đã sử dụng (còn trống 78G trên phân vùng gốc).
- **Bộ nhớ (RAM)**: Đang dùng 4.3Gi / Tổng 7.8Gi (khả dụng 3.4Gi).

### Các Dịch Vụ Đang Chạy (Docker)
| Tên Container | Hình Ảnh (Image) | Trạng Thái | Cổng (Ports) |
| :--- | :--- | :--- | :--- |
| `traefik` | `traefik:v3.6` | Đang chạy | 80, 443 |
| `quanly_db` | `mysql:8.0` | Đang chạy | 3306, 33060 |
| `mysql` | `mysql:8.0` | Đang chạy (Healthy) | 3306, 33060 |
| `redis` | `redis:7.4-alpine` | Đang chạy (Healthy) | 6379 |
| `adminer` | `adminer:4-standalone` | Đang chạy | 8080 |

### Cấu Trúc Dự Án
- **Thư mục Gốc**: `/opt/nhahang`
- **Thư mục Roadmap**: `/opt/nhahang/roadmap`

## Kiến Trúc & Hạ Tầng (Infrastructure & Architecture)

### 1. Reverse Proxy (Gateway)
- **Service**: Traefik (v3.6)
- **Ports**: 80 (HTTP), 443 (HTTPS)
- **Network**: `traefik-public`
- **Cấu hình**: Nằm tại `/opt/traefik` (bao gồm certificates, config động, và traefik.yml).

### 2. Dịch Vụ Dữ Liệu (Shared Data Services)
Các dịch vụ nền tảng nằm tại `/opt/database`:
- **MySQL (Shared)**:
  - Container: `mysql`
  - Dữ liệu: Docker Volume `mysql_data` (An toàn, không phụ thuộc thư mục host).
  - Config: `/opt/database/mysql/conf/my.cnf`
- **Redis (Shared)**:
  - Container: `redis`
  - Dữ liệu: Docker Volume `redis_data`
  - Config: `/opt/database/redis/redis.conf`

### 3. Hệ Thống Mạng (Networking)
- **traefik-public**: Mạng công cộng kết nối Traefik với các container ứng dụng (Web).
- **Các mạng nội bộ**: `quanlyhoadigital_internal` (App kết nối DB riêng), `docker_internal`.

### 4. Lưu Trữ (Persistence Strategy)
- **Source Code & Configs**: Sử dụng **Bind Mounts** từ Host (`/opt/...`) để dễ dàng chỉnh sửa và quản lý.
- **Database Data**: Sử dụng **Docker Volumes** (`mysql_data`, `redis_data`, `quanlyhoadigital_db_data`) để tối ưu hiệu suất và quản lý backup độc lập.

## ROADMAP: HỆ THỐNG QR ORDER - SUỐI ĐÁ HÒN GIAO
**Cập nhật:** 29/01/2026
**Core:** Laravel 12 - PHP 8.4 - Livewire - Filament.
**Hạ tầng:** Docker Shared Services (MySQL/Redis).

---

### 🎯 GIAI ĐOẠN 1: SETUP & FOUNDATION (Laravel 12)
*Mục tiêu: Môi trường chạy mượt mà trên PHP 8.4 và kết nối hạ tầng có sẵn.*

- [x] **Khởi tạo Project**
    - [x] Build Docker Image: Sử dụng base image `php:8.4-fpm-alpine`.
    - [x] Cài đặt Extensions: `pdo_mysql`, `bcmath`, `redis`, `pcntl` (cho Reverb).
    - [x] Install Laravel 12: `composer create-project laravel/laravel:^12.0 .`

- [x] **Docker Network Integration**
    - [x] Config `docker-compose.yml`:
        - [x] Service `app`: PHP 8.4.
        - [x] Service `web`: Nginx (hoặc FrankenPHP nếu muốn hiệu năng cao).
        - [x] Network: Join `traefik-public` (external).
    - [x] Verify Connection: Test kết nối từ container App sang `mysql` và `redis`.

- [x] **Laravel Reverb Setup (WebSocket)**
    - [x] Install: `php artisan install:broadcasting` (Chọn Reverb).
    - [x] Config Traefik: Route traffic cổng 8080/443 (WSS) về service Reverb.

---

### 🛠 GIAI ĐOẠN 2: DATABASE & ADMIN (Filament)
*Mục tiêu: Quản lý món ăn và in mã QR.*

- [x] **Database Schema (Laravel 12 Migrations)**
    - [x] Rút gọn migration (dùng tính năng gộp file của Laravel mới nếu có).
    - [x] Tables: `tables`, `categories`, `products`, `orders`, `order_items`.

- [x] **Admin Features**
    - [x] Cài đặt Filament Panel.
        - **Admin Login**: `https://nhahang.hoadigital.com/admin` (Đã kiểm tra hoạt động)
        - **Account**: `admin@suoida.com` / `password`
        - *Fixes Applied*:
            - Cấp quyền `chmod 775` cho thư mục `storage` & `bootstrap/cache`.
            - Bật route `->login()` trong `AdminPanelProvider`.
            - Tạo thủ công các Model (`Table`, `Category`, `Product`...) do lệnh generate bị thiếu.
    - [x] **Product Management**: Upload ảnh tối ưu (WebP format).
    - [ ] **QR Builder**:
        - [ ] Generate URL: `https://nhahang.hoadigital.com/?table={id}`.
        - [ ] Action: "Download QR" trên trang danh sách bàn.

---

### 📱 GIAI ĐOẠN 3: MOBILE ORDERING (Client)
*Mục tiêu: Trải nghiệm người dùng "nhanh như gió".*

- [x] **Logic "Session-based"**
    - [x] Middleware `CheckTableSession`: Đảm bảo khách phải quét QR mới vào được.
    - [x] UI Mobile: Sử dụng Tailwind CSS v3.4.
    - [x] Animation: Dùng `Alpine.js` cho hiệu ứng bay món vào giỏ hàng.
- [x] **Việt hóa (Localization)**: Admin & Client full Tiếng Việt.

---

### ⚡ GIAI ĐOẠN 4: REAL-TIME KITCHEN (Trái tim hệ thống)
*Mục tiêu: Độ trễ đơn hàng < 500ms.*

- [x] **Broadcasting**
    - [x] Channel: `kitchen` (Public Channel for simplicity).
    - [x] Event: `OrderCreated`.
    - [x] Queue: Cấu hình Redis Queue để xử lý event bất đồng bộ.

- [x] **Kitchen Dashboard**
    - [x] Layout: Grid View (Trực quan).
    - [x] Sound Alert: Âm thanh "Ding" khi có đơn mới.
    - [x] Tính năng: Cập nhật trạng thái đơn (Processing -> Completed).

---

### 🚀 GIAI ĐOẠN 5: DEPLOY & OPTIMIZE
*Mục tiêu: Vận hành ổn định.*

- [x] **Production Tuning**
    - [x] Production Mode: `APP_ENV=production`, `APP_DEBUG=false`.
    - [x] Optimization: Caching (Config, Route, View).
    - [x] Queue Worker: Container `worker` chạy ngầm.
    - [x] Permissions: Chuẩn hóa quyền `www-data`.
