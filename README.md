# Clone Project

git clone https://github.com/your-username/laravel-ecommerce.git
cd laravel-ecommerce

# Install Dependencies

composer install
npm install && npm run build

# Key Generation

php artisan key:generate

# Seeding the database

php artisan migrate --seed

# start the server

php artisan serve

# Credentials

Email: admin@admin.com
Password: 123456

# Database Schema

https://drawsql.app/teams/tij/diagrams/simple-ecommerce

# Features

User authentication (Laravel Breeze)

Admin panel (manage products & orders)

Customers can browse products, add to cart, and checkout

Order management

ImageKit integration for product images

TailwindCSS styling

# Extending

For extending i think we can stay the with same user experience to make it easy to buy but instead we build a table for our customers for future use maybe in email campaigns or we make specific sales for customers to generate retention
