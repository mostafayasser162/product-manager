# Product Manager Task – Laravel Application

This is a simple Laravel application for managing products, categories, and their prices over specific periods.  
It was built as part of a technical assessment task.

---

## 🚀 Features

-   CRUD for Products & Categories
-   Many-to-Many relationship between products and categories
-   Assign multiple prices to each product based on time period
-   Get the current price of any product based on today's date
-   Clean code structure using Form Requests and API Resources
-   RESTful API with JSON responses

---

## 🛠️ Tech Stack

-   PHP 8.2+
-   Laravel 12+
-   MySQL
-   Postman for testing the API

---

## 📦 Installation

### 1. Clone the repository and install dependencies

```bash
git clone https://github.com/YOUR_USERNAME/product-manager.git
cd product-manager
composer install
```

### 2. Copy `.env` and generate app key

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure your database

Edit your `.env` file:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run migrations and (optional) seed data

```bash
php artisan migrate
php artisan db:seed
```

### 5. Serve the application

```bash
php artisan serve
```

---

## 🤝 Author

Developed by **Mostafa Yasser**  
GitHub: [https://github.com/mostafayasser162](https://github.com/mostafayasser162)
