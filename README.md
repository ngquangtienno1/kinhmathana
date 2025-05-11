# Hana Eyewear E-commerce Admin Panel

A modern and feature-rich admin panel for Hana Eyewear e-commerce platform built with Laravel.

## Features

-   🛍️ Complete Product Management
-   📦 Order Processing System
-   👥 Customer Management
-   📊 Sales Analytics & Reports
-   🎯 Marketing Tools
-   📝 Content Management
-   👤 User & Role Management
-   ⚙️ Comprehensive Settings

## Requirements

-   PHP >= 8.1
-   Composer
-   Node.js >= 16.x
-   MySQL >= 8.0
-   Git

## Installation

1. Clone the repository:

```bash
git clone [repository-url]
cd website_kinh_mat_Hana
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Create environment file:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Configure your database in `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:

```bash
php artisan migrate
```

8. Seed the database (optional):

```bash
php artisan db:seed
```

9. Build assets:

```bash
npm run build
```

10. Start the development server:

```bash
php artisan serve
```

## Development

-   Run development server:

```bash
php artisan serve
```

-   Watch for asset changes:

```bash
npm run dev
```

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Application controllers
│   │   └── Middleware/     # Custom middleware
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic services
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── resources/
│   ├── js/               # JavaScript files
│   ├── css/              # CSS files
│   └── views/            # Blade templates
└── routes/
    └── web.php           # Web routes
```

## Contributing

1. Create a new branch for your feature:

```bash
git checkout -b feature/your-feature-name
```

2. Make your changes and commit them:

```bash
git add .
git commit -m "Add your feature description"
```

3. Push to your branch:

```bash
git push origin feature/your-feature-name
```

4. Create a Pull Request

## Coding Standards

-   Follow PSR-12 coding standards
-   Use meaningful variable and function names
-   Write comments for complex logic
-   Keep functions small and focused
-   Use type hints where possible

## Common Issues & Solutions

1. **Composer dependencies not installing**

    - Clear composer cache: `composer clear-cache`
    - Delete vendor folder and composer.lock
    - Run `composer install` again

2. **Node modules issues**

    - Delete node_modules folder and package-lock.json
    - Run `npm install` again

3. **Permission issues**
    - Ensure storage and bootstrap/cache directories are writable:
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

## Support

For any questions or issues, please contact the development team or create an issue in the repository.

## License

This project is proprietary software. All rights reserved.
