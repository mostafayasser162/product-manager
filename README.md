# Product Manager Task – Laravel Application

A Laravel-based API for managing products, categories, and time-based pricing.  
Built as part of a backend developer technical assessment.


---

## 🚀 Features

-   RESTful JSON API
-   CRUD operations for Products and Categories
-   Many-to-Many relationship between Products and Categories
-   Multiple prices per Product based on time periods
-   Current price retrieval based on today's date
-   Clean architecture using Form Requests, Services, and API Resources


---

## 🛠️ Tech Stack

-   PHP 8.2+
-   Laravel 12
-   MySQL
-   Laravel Telescope (for local debugging)
-   Postman for testing the API

---

## 📦 Installation

### 1. Clone the repository and install dependencies

```bash
git clone https://github.com/mostafayasser162/product-manager.git
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
