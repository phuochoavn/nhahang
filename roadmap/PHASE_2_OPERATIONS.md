# ROADMAP GIAI ĐOẠN 2: HOÀN THIỆN & VẬN HÀNH
**Dự án:** Web Order Suối Đá Hòn Giao
**Trạng thái:** Post-MVP (Sau khi đã có tính năng cơ bản)

Giai đoạn này tập trung vào các tính năng "cơm áo gạo tiền" mà chủ nhà hàng sẽ yêu cầu sau khi hệ thống chạy được vài ngày: Báo cáo doanh thu, Bảo mật, In ấn QR và Sao lưu dữ liệu.

---

## 🛠 MODULE 1: QUẢN LÝ IN ẤN & QR (Hoàn tất phần thiếu)
*Mục tiêu: Chủ quán tự in được mã QR đẹp để dán lên bàn.*

- [x] **QR Code Generator nâng cao**
    - [x] Thêm thư viện `simplesoftwareio/simple-qrcode`.
    - [x] Tạo Action "Download QR" trong `TableResource` (Filament Admin).
- [x] **Template in ấn**:
    - [x] Thiết kế View HTML khổ A5/A6.
    - [x] Nội dung: Logo Suối Đá Hòn Giao, QR Code lớn, Hướng dẫn "Quét để gọi món", Tên bàn, Wifi.
    - [x] Nút "Print" gọi lệnh in trình duyệt.

---

## 📊 MODULE 2: BÁO CÁO & THỐNG KÊ (Reporting)
*Mục tiêu: Chủ quán biết ngày hôm nay bán được bao nhiêu tiền, món nào chạy nhất.*

- [x] **Dashboard Widgets (Filament)**
    - [x] Widget Thống kê tổng quan: Doanh thu hôm nay, Số đơn hàng hôm nay.
    - [x] Widget Biểu đồ doanh thu: Chart line hiển thị doanh thu 7 ngày gần nhất.
    - [x] Widget Top món bán chạy: Bảng danh sách 5 món được order nhiều nhất tháng.
- [x] **Development Helpers (Seeding)**
    - [x] Tạo Seeder: 10 Danh mục, 50 Món, 20 Bàn.
    - [x] Tạo Seeder: 100 Đơn hàng mẫu (7 ngày qua) để test biểu đồ.
    - [x] Tạo Seeder: 20 Feedback mẫu.
- [x] **Export Data**
    - [x] Tính năng xuất Excel danh sách đơn hàng theo ngày (Sử dụng `maatwebsite/excel`).

---

## 🛡 MODULE 3: BẢO MẬT & ỔN ĐỊNH (Hardening)
*Mục tiêu: Tránh nhân viên nghịch ngợm hoặc mất dữ liệu.*

- [x] **Bảo vệ màn hình Bếp (Kitchen Guard)**
    - [x] Hiện tại `/kitchen` đang public -> Thêm Middleware `KitchenAuth`.
    - [x] Cơ chế: Yêu cầu nhập mã PIN (VD: 8888) lần đầu truy cập. Lưu vào Cookie 30 ngày.
- [x] **Sao lưu dữ liệu tự động (Auto Backup)**
    - [x] Cài đặt package `spatie/laravel-backup`.
    - [x] Cấu hình backup Database + Ảnh món ăn (Storage).
    - [x] Setup Cronjob trên Docker để chạy lệnh backup lúc 2:00 sáng hàng ngày.
    - [ ] (Tùy chọn) Gửi file backup lên Google Drive hoặc Email admin.

---

## 💬 MODULE 4: PHẢN HỒI KHÁCH HÀNG (Feedback - Optional)
*Mục tiêu: Lắng nghe ý kiến khách.*

- [x] **Trang Cảm ơn & Đánh giá**
    - [x] Sau khi Bếp bấm "Hoàn thành đơn" -> Giao diện khách hiện Popup "Cảm ơn".
    - [x] Form đánh giá: 1-5 sao và ô nhập góp ý.
    - [x] Lưu vào bảng `feedbacks` và hiển thị trong Admin.

  