# Ghi chú các lệnh quan trọng trong Laravel

## 1. Cài đặt Laravel

```sh
composer create-project laravel/laravel ten_du_an
```

## 2. Migrate Database

```sh
php artisan migrate  # Chạy migration để tạo bảng trong database
php artisan make:migration create_tên_table  # Tạo file migration mới
php artisan make:migration add_category_id_to_products_table  # Tạo file migration để liên kết bảng categories với bảng products
php artisan migrate:rollback  # Rollback lại thao tác cuối cùng của migration
php artisan migrate:rollback --step=5  # Rollback lại 5 lần trước đó
php artisan migrate:rollback --batch=5  # Rollback lại bước số 5
php artisan migrate:reset  # Rollback tất cả các thao tác migration
php artisan migrate:refresh  # Reset và chạy lại migration

#Chạy lại 1 Migration cụ thể
php artisan migrate:status #Xem tất cả các migration để lấy tên file migration
php artisan migrate:rollback --path=database/migrations/tên_file_magration #Rollback lại 1 Migration
php artisan migrate --path=database/migrations/tên_file_magration #chạy lại Migration


```

## 3. Seed Database

```sh
php artisan make:seeder tenfileSeeder  # Tạo file seeder mới VD:php artisan make:seeder DepartmentsSeeder
php artisan db:seed  # Chạy toàn bộ seeder
php artisan db:seed --class=UserSeeder  # Chạy một class seeder cụ thể
php artisan migrate:fresh --seed  # Reset database, chạy lại migration và seed dữ liệu

```

## 4. TẠO

```sh
php artisan make:model TênModel  # Tạo một model mới
php artisan make:controller TenController  # Tạo một controller mới
php artisan make:factory TenFactory  # Tạo một factory mới
php artisan make:middleware tenMiddleware  # Tạo một middleware mới
php artisan make:controller Api/TenController --api # Tạo một controller API
php artisan make:model tên_model -mfc # Tạo một model, factory, controller, migration, seed
php artisan make:controller Api/ProductController --api # Tạo một controller API
php artisan make:migration add_role_to_users_table --table=users # Tạo một migration addUserRole
php artisan make:middleware AdminMiddleware # Tạo một middleware AdminMiddleware
```

## 5. Chạy Laravel Server

```sh
php artisan serve  # Chạy Laravel với built-in server
```

## 6. Chạy Ảnh

```sh
php artisan storage:link # Tạo liên kết các file để hiển thị ra người dùng
php artisan make:migration add_deleted_at_to_ten_table --table=ten_table
```

## 7. Xoá mềm

```sh
php artisan make:migration add_deleted_at_to_ten_table --table=ten_table # Tạo một migration deleted_at
#VD: php artisan make:migration add_deleted_at_to_employees_table --table=employees
```

## 8. API/API Sanctum

```sh
Bước 1: php artisan make:controller Api/ProductController --api # Tạo một controllerAPI
Bước 2: php artisan make:resource ProductResource   # Tạo một resource
Bước 4: Tạo route api
Bước 5: composer require laravel/sanctum # Cài đặt Sanctum
Bước 6: php artisan vendor:publish --tag=sanctum-config # Cấu hình Sanctum
Bước 7: php artisan vendor:publish --tag=sanctum-migrations  # Tạo một migration Sanctum
Bước 8: php artisan migrate
Bước 9: php artisan make:controller Api/AuthController #Tạo controller Auth
Bước 10: Thêm HasApiTokens vào Model User
Bước 11: Thêm route trong bootstrap/app.php và k cần thêm middleware


#Nếu đề bài yêu cầu xoá mềm
Bước 11: php artisan make:migration add_deleted_at_to_ten_table --table=ten_table #Tạo một migration deleted_at
Bước 12: php artisan migrate
Bước 13: Thêm SoftDeletes vào Model Product
```

## 9. Middleware

```sh
Bước 1: php artisan make:migration add_role_to_users_table --table=users # Tạo một migration addUserRole
Bước 2: sửa migration để thêm cột role vào bảng users
Bước 3 : Chạy Migration
Bước 4: php artisan make:middleware AdminMiddleware # Tạo một middleware AdminMiddleware
Bước 5: vào bootstrap/app.php để định nghĩa middleware
Bước 6 : Vào AdminMiddleware để check đăng nhập
Bước 7: php artisan make:controller AuthController #Tạo controller Auth

```

## 10. Middleware RestrictOldBrands

```sh
Bước 1: php artisan make:middleware RestrictOldBrands # Tạo một middleware RestrictOldBrands
Bước 2: Cập nhật nội dung app/Http/Middleware/RestrictOldBrands.php
Bước 3 : Áp dụng Middleware cho routes/web.php
Bước 4: Đăng ký Middleware trong bootstrap/app.php # Tạo một middleware RestrictOldBrands
```
