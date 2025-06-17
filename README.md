# hexagonal-symfony-app

This project is built using **Symfony >=8.2** and follows **Hexagonal Architecture (Ports & Adapters)** and **Domain-Driven Design (DDD)** principles.

---

## 🧱 Project Structure

```
src/
├── Application/        # Use cases and command handlers
├── Domain/             # Business entities and interfaces
├── Infrastructure/     # Repositories, security, and service implementations
├── Interface/
│   └── Controller/     # HTTP controllers
│   └── Http/Form/      # Symfony form definitions
```

---

## 🚀 Installation

```bash
git clone <repository-url>
cd hexagonal
composer install
cp .env .env.local
```

Set up the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

---

## ▶️ Running the Application

```bash
symfony server:start
# or
php -S localhost:8000 -t public
```

---

## 🔐 Authentication

- `GET /register` — user registration form
- `POST /register` — user registration via command handler
- `GET /login` — login form
- `POST /login` — custom login using LoginUserCommand + LoginUserHandler
- `GET /dashboard` — protected area for authenticated users

User authentication is implemented manually using Symfony's `UsernamePasswordToken`, `TokenStorageInterface` and session management. No `form_login` or JWT authentication bundle is used.

---

## 📦 Symfony Packages Used (partial)

symfony/asset, symfony/asset-mapper, symfony/console, symfony/doctrine-messenger, symfony/dotenv, symfony/expression-language, symfony/flex, symfony/form...

---

## 🧪 Testing

```bash
php bin/phpunit
```

---

## 🧠 Author

Developed using principles of Clean Architecture and Domain-Driven Design.
