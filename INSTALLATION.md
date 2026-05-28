# 📋 Chi Tiết Hướng Dẫn Cài Đặt

## 1️⃣ Clone Repository

```bash
git clone https://github.com/zyIxoria/floral_shop_php.git
cd floral_shop_php
```

## 2️⃣ Cài Đặt PHP Dependencies

```bash
composer install
```

## 3️⃣ Thiết Lập File .env

```bash
cp .env.example .env
```

Sau đó chỉnh sửa file `.env`:

```env
APP_NAME="Floral Shop"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=floral_shop
DB_USERNAME=root
DB_PASSWORD=
```

## 4️⃣ Tạo Application Key

```bash
php artisan key:generate
```

## 5️⃣ Tạo Database

### Cách 1: Dùng phpMyAdmin
1. Mở phpMyAdmin (http://localhost/phpmyadmin)
2. Tạo database mới với tên: `floral_shop`
3. Collation: `utf8mb4_unicode_ci`

### Cách 2: Dùng Command Line

```bash
mysql -u root -p -e "CREATE DATABASE floral_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## 6️⃣ Chạy Migrations

```bash
php artisan migrate
```

## 7️⃣ Chạy Seeders (Dữ Liệu Mẫu)

```bash
php artisan db:seed
```

Hoặc chỉ định seeder cụ thể:

```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

## 8️⃣ Tạo Storage Link

```bash
php artisan storage:link
```

Diều này tạo symbolic link từ `storage/app/public` đến `public/storage`.

## 9️⃣ Cài Đặt Frontend Dependencies

```bash
npm install
```

## 🔟 Build Frontend Assets

```bash
npm run build
```

Hoặc để development mode (auto reload):

```bash
npm run dev
```

## 1️⃣1️⃣ Khởi Động Development Server

### Terminal 1 - Laravel Server
```bash
php artisan serve
```

### Terminal 2 - Frontend Watcher (nếu sử dụng)
```bash
npm run dev
```

Access: http://localhost:8000

## 📝 Default Credentials

### Admin Account
```
Email: admin@gmail.com
Password: 12345678
```

### Customer Account
```
Email: customer@gmail.com
Password: 12345678
```

## ✅ Verification Checklist

- [ ] Repository cloned
- [ ] Composer dependencies installed
- [ ] .env file configured
- [ ] Database created
- [ ] Migrations ran
- [ ] Seeders executed
- [ ] Storage link created
- [ ] NPM dependencies installed
- [ ] Frontend assets built
- [ ] Laravel server running
- [ ] Can access http://localhost:8000
- [ ] Can login with admin credentials

## 🆘 Troubleshooting

### Permission Denied (storage/logs)
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Database Connection Error
```bash
# Verify database exists
mysql -u root -p -e "SHOW DATABASES;"

# Or reconfigure .env
php artisan config:clear
```

### Clear All Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

## 📚 Useful Artisan Commands

```bash
# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Create new migration
php artisan make:migration create_table_name

# Create new seeder
php artisan make:seeder SeederName

# Run all migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database
php artisan migrate:reset

# Refresh migrations (reset + migrate)
php artisan migrate:refresh

# Seed database
php artisan db:seed

# Cache clear
php artisan cache:clear

# Config cache
php artisan config:cache
```

## 🎉 Done!

Your Floral Shop is now ready to use! 🌸
