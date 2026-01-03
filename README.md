<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Giới thiệu dự án — Đặt lịch khám (Chi tiết) 🏥

**Mục tiêu:** Ứng dụng giúp bệnh nhân dễ dàng đặt lịch khám, cho phép Admin và Bác sĩ quản lý lịch, giảm thời gian chờ và lưu trữ lịch sử khám.

---

### 🔍 Tính năng chính

- Hệ thống đa vai trò: **Admin**, **Doctor**, **Patient**.
- Đặt lịch, xác nhận, hủy (với `cancel_reason`) và theo dõi trạng thái lịch (ví dụ: pending, confirmed, cancelled, completed).
- Quản lý **Bác sĩ**, **Chuyên khoa**, **Phòng khám (Room)** và số phòng (`room_number`).
- Hệ thống **Notification** với `title` và phân loại theo loại người dùng.
- Hỗ trợ upload **avatar** và lưu **phone** cho người dùng.
- Seeder để khởi tạo dữ liệu mẫu (users, doctors, rooms, ...).

---

### 🧭 Luồng chính (use-cases)

1. Bệnh nhân chọn chuyên khoa → chọn bác sĩ → chọn ngày/giờ và phòng → gửi yêu cầu đặt lịch.
2. Bác sĩ/Admin xác nhận hoặc từ chối; người dùng nhận thông báo.
3. Bệnh nhân có thể hủy lịch và ghi `cancel_reason`.
4. Admin quản lý dữ liệu (thêm/sửa/xóa bác sĩ, phòng, chuyên khoa).

---

### 📦 Mô hình dữ liệu (tóm tắt)

- **User** (role, name, email, phone, avatar, password)
- **Doctor** (user_id, specialty_id, thông tin khác)
- **Specialty** (name, description)
- **Room** (room_number, ...)
- **Appointment** (user_id, doctor_id, room_id, scheduled_at, status, cancel_reason)
- **Notification** (user_id, title, body?, user_type)

---

### 🛠️ Công nghệ & Thành phần

- Backend: **Laravel 12**, PHP 8.2
- Frontend: Blade + **Vite**, **Tailwind CSS**, **Axios**
- Queue: Laravel queue (dùng cho gửi thông báo/async jobs)
- DB: MySQL / PostgreSQL / SQLite
- Testing: PHPUnit / Laravel Test Suite

---

### ⚙️ Vận hành & Triển khai (tóm tắt)

- Thiết lập `.env` (DB, MAIL, QUEUE)
- Chạy migrations & seeder: `php artisan migrate --seed`
- Chạy queue worker: `php artisan queue:work`
- Xây assets: `npm install && npm run build`
- Dùng `composer run-script dev` để chạy server + queue + vite trong dev

> Lưu ý: Cấu hình mail/queue cần thiết để gửi thông báo thực tế.

---

### 🚀 Roadmap / Hướng mở rộng (gợi ý)

- Lịch calendar cho từng bác sĩ
- API cho mobile app
- Xác thực OAuth / Social login
- Báo cáo thống kê (số lịch theo ngày/chuyên khoa, tỉ lệ hủy)
- Nhắc lịch tự động (SMS/Email)

---

### ✅ Gợi ý cho README

- Thêm phần **Tài khoản demo** (nếu seed tạo user sẵn) — tôi có thể kiểm tra `database/seeders` và thêm vào.
- Thêm `.env.example` mẫu với các biến DB, MAIL, QUEUE nếu cần.


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
