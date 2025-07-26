# Multi-Auth Posts App

A Laravel + Vue.js application with multi-auth (Admin & User) and posts management using Sanctum.

## Features

- User and Admin authentication (multi-auth)
- CRUD for posts (with policies)
- RESTful API with Laravel Sanctum
- Vue.js SPA frontend

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or compatible DB

## Installation

1. **Clone the repository**
    ```bash
    git clone https://github.com/your-username/multi-auth-posts.git
    cd multi-auth-posts/backend
    ```

2. **Install PHP dependencies**
    ```bash
    composer install
    ```

3. **Install JS dependencies**
    ```bash
    npm install
    ```

4. **Copy and configure environment**
    ```bash
    cp .env.example .env
    # Edit .env for your DB and app settings
    ```

5. **Generate app key**
    ```bash
    php artisan key:generate
    ```

6. **Run migrations**
    ```bash
    php artisan migrate
    ```

7. **(Optional) Seed database**
    ```bash
    php artisan db:seed
    ```

8. **Start the backend server**
    ```bash
    php artisan serve
    ```

9. **Start the frontend dev server**
    ```bash
    npm run dev
    ```

## Usage

- Visit [http://localhost:8000](http://localhost:8000) for the backend.
- login as User or Admin to manage posts.


## Testing

To run the feature tests:

```bash
php artisan test
```

## Notes

- Sanctum is used for API authentication.
- Policies ensure only owners or admins can update/delete posts.

## License

MIT
"# multi-auth-posts" 
