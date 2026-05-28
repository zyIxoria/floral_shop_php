# 🌸 Floral Shop - Laravel 11 E-commerce Website

A modern, production-ready e-commerce website for selling fresh flowers built with Laravel 11, Bootstrap 5, and MySQL.

## 🎨 Features

### 👤 User Management
- User registration and authentication (Laravel Breeze)
- Role-based access control (Admin & Customer)
- User profile management
- Password reset and change password functionality
- User blocking/unblocking (Admin)

### 🛍️ Product Management
- Product catalog with categories
- Multiple product images gallery
- Product search and filtering
- Product sorting (newest, price asc/desc)
- Product ratings and reviews
- Stock management
- Sale prices and discounts

### 🛒 Shopping Features
- Shopping cart with add/remove/update quantity
- Wishlist functionality
- Product reviews and ratings
- Coupon/discount system
- Multiple coupon types (percentage & fixed)

### 📦 Order Management
- Checkout process
- Order history
- Multiple payment methods (COD, VNPay)
- Order status tracking
- Order confirmation

### 🎯 Admin Dashboard
- Dashboard with key metrics
- Product management (CRUD)
- Category management (CRUD)
- Order management with status updates
- User management
- Coupon management
- Revenue tracking

### 🎨 UI/UX Design
- Responsive design (mobile-first)
- Modern minimalist design
- Color scheme: White, Pastel Pink, Light Green
- Bootstrap 5 framework
- Smooth animations and transitions
- Sticky navbar
- Professional footer

## 🛠️ Technology Stack

### Backend
- **Laravel 11** - Web framework
- **PHP 8+** - Programming language
- **MySQL** - Database
- **Eloquent ORM** - Database abstraction
- **Laravel Breeze** - Authentication scaffolding

### Frontend
- **Blade Template Engine** - Server-side templating
- **Bootstrap 5** - CSS framework
- **Bootstrap Icons** - Icon library
- **JavaScript/Axios** - Client-side functionality
- **AJAX** - Dynamic interactions

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Artisan CLI** - Laravel command-line interface

## 📋 Installation Guide

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher
- Git

### Step 1: Clone Repository
```bash
git clone https://github.com/zyIxoria/floral_shop_php.git
cd floral_shop_php
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_DATABASE=floral_shop
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### Step 6: Install Frontend Dependencies
```bash
npm install
npm run build
```

### Step 7: Start Development Server
```bash
php artisan serve
```

Access the application at `http://localhost:8000`

## 👤 Default Credentials

### Admin Account
- **Email**: admin@gmail.com
- **Password**: 12345678
- **Role**: Admin

### Sample Customer
- **Email**: customer@gmail.com
- **Password**: 12345678
- **Role**: Customer

## 📂 Project Structure

```
floral-shop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   └── ...
│   │   └── Middleware/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── admin/
│   │   ├── products/
│   │   ├── cart/
│   │   ├── checkout/
│   │   └── profile/
│   └── css/
├── routes/
│   └── web.php
├── public/
│   ├── css/
│   └── images/
└── storage/
    └── app/public/
```

## 🔐 Security Features

- CSRF protection on all forms
- SQL injection prevention (Eloquent ORM)
- Password hashing (Bcrypt)
- Authentication middleware
- Authorization checks (admin/customer)
- File upload validation
- Input validation on all forms

## 📦 Database Schema

### Tables
- `users` - User accounts and profiles
- `categories` - Product categories
- `products` - Product information
- `product_images` - Product gallery images
- `carts` - Shopping carts
- `cart_items` - Cart items
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment information
- `reviews` - Product reviews and ratings
- `wishlists` - User wishlists
- `coupons` - Discount coupons
- `coupon_usages` - Coupon usage tracking
- `contacts` - Contact messages

## 🚀 Features in Development

- [ ] Email notifications for orders
- [ ] Advanced analytics dashboard
- [ ] Inventory alerts
- [ ] Customer loyalty program
- [ ] AI-powered product recommendations
- [ ] Social sharing features
- [ ] Live chat support

## 📄 License

This project is open source and available under the MIT License.

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

For support, email support@floralshop.com or open an issue on GitHub.

## 👨‍💻 Author

**zyIxoria**
- GitHub: [@zyIxoria](https://github.com/zyIxoria)

---

**Made with ❤️ for flower lovers**
