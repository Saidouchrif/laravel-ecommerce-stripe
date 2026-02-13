# 🛒 OUCHRIF E-Commerce

A full-featured e-commerce application built with Laravel and Stripe integration. This platform specializes in selling premium gaming controllers (PS5 Master Copier replicas) with a seamless shopping experience.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Stripe](https://img.shields.io/badge/Stripe-Payments-008CDD?style=flat-square&logo=stripe)](https://stripe.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

![E-Commerce Dashboard](public/images/dashboard-preview.png)

## ✨ Features

### 🛍️ Customer Features
- **User Authentication** - Registration, login, and password reset with email verification
- **Social Login** - Google OAuth integration for quick sign-in
- **Product Catalog** - Browse products with filtering by category and price range
- **Product Details** - View detailed product information with image galleries
- **Shopping Cart** - Add products to cart and proceed to checkout
- **Multiple Payment Options** - Cash on Delivery (COD) or secure online payment via Stripe
- **Order Tracking** - View order history and payment status
- **Multilingual Support** - Full support for French and Arabic (RTL)
- **Responsive Design** - Mobile-first design with Tailwind CSS

### 👨‍💼 Admin Features
- **Dashboard** - Overview with sales statistics and recent orders
- **Product Management** - CRUD operations with image uploads and color variants
- **Category Management** - Organize products into categories
- **Order Management** - View, filter, search, and manage customer orders
- **Invoice Generation** - Download PDF invoices using DomPDF
- **Email Notifications** - Send order confirmations and invoices to customers
- **Order Status Updates** - Mark orders as delivered and notify customers

### 💳 Payment Integration
- **Stripe Checkout** - Secure hosted payment pages
- **Webhook Handling** - Automatic payment confirmation via Stripe webhooks
- **Multiple Currencies** - Supports MAD (Moroccan Dirham) and other currencies
- **Payment Status Tracking** - Real-time payment status updates

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **Laravel 12.x** | PHP Web Framework |
| **PHP 8.2+** | Server-side Language |
| **MySQL** | Database |
| **Blade** | Templating Engine |
| **Tailwind CSS** | CSS Framework |
| **Alpine.js** | JavaScript Framework |
| **Stripe API** | Payment Processing |
| **Laravel Socialite** | OAuth Authentication |
| **DomPDF** | PDF Generation |

## 🚀 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL or MariaDB
- Node.js & NPM (optional, for asset compilation)

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/laravel-ecommerce-stripe.git
   cd laravel-ecommerce-stripe
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - Run migrations:
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to see the application.

## 🔑 Admin Access

To access the admin panel:
1. Register a new account with email: `saidouchrif16@gmail.com`
2. Login and navigate to `/admin`
3. **Note:** Admin access is restricted to this specific email address

## 💳 Stripe Configuration

### 1. Create a Stripe Account
- Sign up at [stripe.com](https://stripe.com)
- Get your API keys from the Dashboard

### 2. Configure Environment Variables
Add the following to your `.env` file:

```env
# Stripe Configuration
STRIPE_KEY=pk_test_your_publishable_key
STRIPE_SECRET=sk_test_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
CASHIER_CURRENCY=mad
CASHIER_LOGGER=stack
```

### 3. Set Up Stripe Webhook

For local development, use Stripe CLI:

```bash
# Install Stripe CLI (https://stripe.com/docs/stripe-cli)

# Login to Stripe
stripe login

# Forward webhooks to your local server
stripe listen --forward-to localhost:8000/webhook/stripe
```

Copy the webhook signing secret and add it to your `.env` file as `STRIPE_WEBHOOK_SECRET`.

For production:
1. Go to Stripe Dashboard → Developers → Webhooks
2. Add endpoint: `https://yourdomain.com/webhook/stripe`
3. Select events: `checkout.session.completed`
4. Copy the webhook secret to your `.env`

## 🔧 Environment Variables

Here's a complete example of the `.env` file:

```env
APP_NAME="OUCHRIF E-Commerce"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=root
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail Configuration (for order notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Admin Email (receives order notifications)
ADMIN_EMAIL=your-admin-email@gmail.com

# Google OAuth (optional)
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Stripe Configuration
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=mad
CASHIER_LOGGER=stack
```

## 📁 Project Structure

```
laravel-ecommerce-stripe/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Authentication logic
│   │   │   ├── AdminController.php         # Admin panel
│   │   │   ├── OrderController.php         # Order & Stripe handling
│   │   │   ├── StripeWebhookController.php # Webhook processing
│   │   │   └── ProduitController.php       # Product management
│   │   └── Middleware/
│   │       └── SetLocale.php               # Language switching
│   ├── Models/
│   │   ├── User.php
│   │   ├── Produit.php
│   │   ├── Categorie.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Mail/                               # Mailable classes
├── config/
│   └── services.php                        # Stripe & OAuth config
├── database/
│   └── migrations/                         # Database schema
├── lang/
│   ├── ar/                                 # Arabic translations
│   └── fr/                                 # French translations
├── public/
│   └── images/                             # Product images
├── resources/
│   └── views/
│       ├── auth/                           # Login, Register
│       ├── admin/                          # Admin panel views
│       ├── home/                           # Frontend views
│       ├── emails/                         # Email templates
│       └── layouts/                        # Blade layouts
├── routes/
│   └── web.php                             # Application routes
└── storage/
    └── app/public/images/                  # Uploaded images
```

## 🎯 Key Features Explained

### Payment Flow
1. Customer adds products to cart and proceeds to checkout
2. Chooses payment method (Cash on Delivery or Online)
3. For online payments:
   - Stripe Checkout Session is created
   - Customer is redirected to Stripe's secure payment page
   - After payment, customer returns to success page
   - Webhook confirms payment and updates order status
   - Confirmation emails sent to customer and admin

### Multilingual Support
- Switch between French and Arabic
- RTL (Right-to-Left) support for Arabic
- All content translated including emails

### Image Management
- Multiple images per product
- Automatic image resizing and optimization
- Color variants with image association

### Email Notifications
- Welcome email on registration
- Order confirmation to customer
- New order notification to admin
- Invoice emails with PDF attachment
- Order status update notifications

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Test Stripe Payments
Use Stripe's test card numbers:
- **Success:** `4242 4242 4242 4242`
- **Decline:** `4000 0000 0000 0002`
- **3D Secure:** `4000 0025 0000 3155`

For any test card:
- Expiry: Any future date (e.g., 12/25)
- CVC: Any 3 digits (e.g., 123)

## 🚢 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up production Stripe keys
- [ ] Configure SSL certificate
- [ ] Set up proper mail driver (Postmark, SES, etc.)
- [ ] Configure Stripe webhooks for production URL
- [ ] Run `php artisan optimize`
- [ ] Set up queue worker for emails (optional)

### Laravel Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🛣️ Future Improvements

- [ ] **Inventory Management** - Stock tracking with low stock alerts
- [ ] **Coupons & Discounts** - Promotional code system
- [ ] **Product Reviews** - Customer rating and review system
- [ ] **Wishlist** - Save favorite products for later
- [ ] **Multi-vendor Support** - Allow multiple sellers
- [ ] **Advanced Analytics** - Sales reports and charts
- [ ] **Shipping Integration** - Integration with shipping providers
- [ ] **Mobile App** - React Native or Flutter application
- [ ] **API Endpoints** - RESTful API for mobile apps
- [ ] **Real-time Notifications** - WebSocket notifications

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

**OUCHRIF** - [Your GitHub Profile](https://github.com/Saidouchrif)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Stripe](https://stripe.com) - Payment Processing
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Alpine.js](https://alpinejs.dev) - JavaScript Framework

---

<p align="center">Made with ❤️ using Laravel & Stripe</p>
