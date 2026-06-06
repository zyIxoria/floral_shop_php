# Floral Shop PHP

Website bán hoa xây bằng Laravel 11, Blade, Bootstrap 5 và MySQL.

## Yêu cầu môi trường

- PHP 8.2 trở lên
- Composer
- MySQL hoặc MariaDB
- Git
- Node.js/NPM: không bắt buộc để chạy bản hiện tại, vì CSS/JS đang dùng file tĩnh trong `public/css` và `public/js`

Nếu dùng Laragon trên Windows, PHP thường nằm ở dạng:

```powershell
C:\laragon\bin\php\php-8.x.x-Win32-vs16-x64\php.exe
```

Bạn nên thêm thư mục PHP đó vào `PATH` để dùng được lệnh `php` trực tiếp.

## Cài đặt lần đầu

1. Clone project:

```bash
git clone https://github.com/zyIxoria/floral_shop_php.git
cd floral_shop_php
```

2. Cài thư viện PHP:

```bash
composer install
```

3. Tạo file môi trường và application key:

Windows PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Git Bash/macOS/Linux:

```bash
cp .env.example .env
php artisan key:generate
```

4. Tạo database MySQL tên `floralshop`.

Ví dụ với MySQL CLI:

```bash
mysql -u root -p -e "CREATE DATABASE floralshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

5. Cập nhật `.env` cho đúng database:

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=floralshop
DB_USERNAME=root
DB_PASSWORD=
```

6. Chạy migration, seed dữ liệu mẫu và tạo storage link:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Nếu database đã có dữ liệu test cũ và bạn muốn reset sạch:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

7. Chạy server Laravel:

```bash
php artisan serve
```

Mở trình duyệt tại:

```text
http://localhost:8000
```

## Tài khoản mẫu

Admin:

```text
Email: admin@gmail.com
Password: 12345678
```

Customer:

```text
Email: customer@gmail.com
Password: 12345678
```

## Thanh toán chuyển khoản giả lập

Checkout có thêm phương thức `Chuyển Khoản Giả Lập`.

Ảnh QR được load từ:

```text
public/assets/payment/qrcode.png
```

Nếu muốn đổi QR, thay file PNG ở đúng đường dẫn trên. Trang checkout sẽ tự hiển thị tổng tiền cần thanh toán theo giỏ hàng.

## Frontend assets

Project hiện đang dùng asset tĩnh:

```text
public/css/custom.css
public/css/responsive.css
public/js/app.js
public/js/cart.js
public/js/checkout.js
```

Vì chưa có `vite.config.js`, bạn không cần chạy `npm install` hoặc `npm run build` để mở website. Chỉ cần các file trong `public` tồn tại là giao diện chạy được.

Nếu sau này muốn chuyển sang Vite, cần bổ sung `vite.config.js` và đổi layout sang `@vite(...)`.

## Kiểm tra sau cài đặt

Chạy các lệnh sau:

```bash
php artisan about --only=environment
php artisan route:list
```

Bạn nên thấy Laravel boot được và danh sách route hiển thị bình thường.

## Lỗi thường gặp

Không nhận lệnh `php`:

- Kiểm tra PHP đã được thêm vào `PATH`.
- Với Laragon, mở Terminal từ Laragon hoặc thêm thư mục `C:\laragon\bin\php\...\` vào `PATH`.

Không kết nối được database:

```bash
php artisan config:clear
```

Sau đó kiểm tra lại `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` trong `.env`.

Muốn xóa cache Laravel:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Cấu trúc chính

```text
app/
database/
public/
resources/
routes/
storage/
```

Trong đó:

- `app/Http/Controllers`: controllers
- `app/Models`: models
- `database/migrations`: cấu trúc database
- `database/seeders`: dữ liệu mẫu
- `resources/views`: Blade views
- `public`: entrypoint, CSS/JS tĩnh, ảnh QR thanh toán
- `routes/web.php`: routes chính của website
