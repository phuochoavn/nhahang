
# ROADMAP GIAI ĐOẠN 3: GIAO DIỆN KHÁCH HÀNG (Mobile First)
Mục tiêu: Khách quét QR -> Thấy giao diện đẹp, chạy mượt -> Bấm gọi món dễ dàng.

## 🎨 MODULE 1: UI SYSTEM & THEME
Mục tiêu: Thiết lập màu sắc thương hiệu Suối Đá Hòn Giao.

- [x] Cấu hình Tailwind CSS
    - [x] Thêm mã màu chủ đạo vào tailwind.config.js: `brand-green` (#15803d), `brand-brown` (#78350f).
    - [x] Cấu hình Font chữ: Google Font 'Quicksand'.

## 📱 MODULE 2: CÁC TRANG CHÍNH (Livewire Components)
Mục tiêu: Chuyển đổi các Wireframe thành code chạy được.

- [x] **Trang Check-in & Session Logic**
    - [x] Middleware: `CheckTableSession` (Verify logic).
    - [x] Route: `/?table={id}` -> Save session -> Redirect `/menu`.
    - [x] Trang thông báo "Vui lòng quét QR" (nếu thiếu session).

- [x] **Trang Menu (Guest\Menu)**
    - [x] Layout Mobile-first (Logo, Số bàn, Bottom Nav).
    - [x] Category Tabs (Sticky, Scrollable X).
    - [x] Product Grid (2 cột, Lazy loading ảnh).
    - [x] Modal chi tiết món (Popup from bottom).

## 🛒 MODULE 3: GIỎ HÀNG & CHECKOUT
Mục tiêu: Giúp khách chốt đơn nhanh.

- [x] **Cart Logic**
    - [x] Helper/Service quản lý giỏ hàng (Session based).
    - [x] Component `CartButton` (Fixed Bottom).
    - [x] Modal Giỏ hàng & Nút Gửi đơn.

## 📡 MODULE 4: TRẠNG THÁI ĐƠN HÀNG
- [ ] Màn hình "Theo dõi đơn" (Real-time update).
