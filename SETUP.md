# Hướng dẫn chạy dự án Laravel Kinhmathana

## 1. Cài đặt các package cần thiết

```bash
composer install
composer dump-autoload
composer require laravel/sanctum
composer require laravel/socialite
```

## 2. Tạo file cấu hình môi trường

-   Copy file `.env.example` thành `.env`:

```bash
cp .env.example .env
```

-   Cấu hình các biến môi trường trong file `.env` (DB, Google, Facebook...)

## 3. Tạo khóa ứng dụng

```bash
php artisan key:generate
```

## 4. Chạy migrate và seed dữ liệu mẫu

```bash
php artisan migrate:fresh --seed
```

## 5. Chạy server

```bash
php artisan serve
```

## 6. Đăng nhập Google/Facebook

-   Cấu hình các biến sau trong file `.env`:

```
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback

FACEBOOK_CLIENT_ID=your-facebook-client-id
FACEBOOK_CLIENT_SECRET=your-facebook-client-secret
FACEBOOK_REDIRECT_URI=http://127.0.0.1:8000/auth/facebook/callback
```

-   Đăng ký OAuth trên Google/Facebook Developers và lấy thông tin điền vào.

## 7. Truy cập trang chủ

-   Mở localhost: http://127.0.0.1:8000

---

**Lưu ý:**

-   Nếu cần thêm quyền cho user, chỉnh sửa trong seeder hoặc database.
