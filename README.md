## Publishing System

This is a web application built with Laravel 8 and InertiaJS for managing publishing workflows. The application allows publishers to create, edit, and publish content across multiple platforms.

## Features

- User authentication and authorization
- User roles and permissions
- Content creation and editing
- Content publishing to multiple platforms
- Content scheduling
- Content search and filtering
- Activity logging


## Installation

1. Clone the repository

```
git clone https://github.com/your-username/publishing-system.git
```

2. Install dependencies
```
composer install
npm install
````

3. Copy .env.example file to .env and configure your database settings.

4. Generate application key
```
php artisan key:generate
````

5. Run database migrations
```
php artisan migrate
````

6. Build assets using Laravel Mix
```
npm run dev
````

7. Serve the application
```
php artisan serve
```


## Usage

After installation and setup, you can access the application in your browser by visiting http://localhost:8000. The first user to register will automatically become the administrator and will be able to create additional users and manage their roles and permissions.

## Contributing

Contributions to this project are welcome. If you would like to contribute, please create a new branch and submit a pull request.