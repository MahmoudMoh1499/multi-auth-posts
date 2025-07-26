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
    git clone https://github.com/MahmoudMoh1499/multi-auth-posts.git
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

## API Testing

A ready-to-use Postman collection is included for testing all API endpoints:

- **File:** `Laravel Vue Multi-Auth Posts API.postman_collection.json`

### How to Use

1. Open [Postman](https://www.postman.com/).
2. Click **Import** and select the `Laravel Vue Multi-Auth Posts API.postman_collection.json` file from the project root.
3. Set the `base_url` variable to your backend URL (default: `http://localhost:8000`).
4. Use the provided requests to test authentication and posts management for both Admin and User roles.
5. After logging in, copy the returned token into the `admin_token` or `user_token` variable in Postman to authorize further requests.

---

This collection covers:
- Admin and User login/logout
- CRUD operations for posts (as Admin and User)

## Notes

- Sanctum is used for API authentication.
- Policies ensure only owners or admins can update/delete posts.


## Demo

Watch a demo of the application here: [https://youtu.be/wukqr5Hd4i8](https://youtu.be/wukqr5Hd4i8)

## License

MIT
"# multi-auth-posts" 
