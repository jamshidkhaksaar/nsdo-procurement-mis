# Procurement MIS NSDO

## Project Overview

This is a web application built using the **Laravel** PHP framework (v12.x). It follows the standard Laravel application structure and includes a modern frontend stack using **Vite** and **Tailwind CSS**.

**Key Technologies:**

*   **Backend:** PHP ^8.2, Laravel Framework 12.0
*   **Frontend:** Vite, Tailwind CSS 4.0, Axios
*   **Database:** SQLite (default configuration), customizable via `.env`
*   **Testing:** PHPUnit

## Building and Running

### Initial Setup

To set up the project from scratch, including dependencies, environment configuration, and database migration, run:

```bash
composer run setup
```

This script executes the following:
1.  Installs PHP dependencies (`composer install`)
2.  Sets up the `.env` file
3.  Generates the application key
4.  Runs database migrations
5.  Installs Node.js dependencies
6.  Builds frontend assets

### Development Server

To start the development environment (Laravel server, Queue worker, Logs, and Vite) concurrently:

```bash
composer run dev
```

Alternatively, you can run services individually:

*   **Backend:** `php artisan serve`
*   **Frontend (Vite):** `npm run dev`
*   **Queue:** `php artisan queue:listen`

### Production Build

To compile frontend assets for production:

```bash
npm run build
```

## Testing

The project uses PHPUnit for testing. To run the test suite:

```bash
composer run test
```
or
```bash
php artisan test
```

## Development Conventions

*   **Architecture:** MVC (Model-View-Controller) as per standard Laravel conventions.
    *   **Controllers:** `app/Http/Controllers/`
    *   **Models:** `app/Models/`
    *   **Views:** `resources/views/`
*   **Routing:** Defined in `routes/web.php` (web) and `routes/console.php` (commands).
*   **Database:**
    *   Migrations are located in `database/migrations/`.
    *   Seeders are in `database/seeders/`.
    *   Default connection is `sqlite`.
*   **Code Style:** Follows PSR-4 autoloading standards.
*   **Frontend:** Assets are managed via Vite (`vite.config.js`). CSS entry point is `resources/css/app.css`. JavaScript entry point is `resources/js/app.js`.

## Key Configuration Files

*   `.env`: Environment-specific configurations (database credentials, app keys, debug mode).
*   `composer.json`: PHP dependency management and project scripts.
*   `package.json`: Node.js dependency management and frontend scripts.
*   `vite.config.js`: Configuration for the Vite build tool.

## Deployment Notes (cPanel)

*   Legacy site `hr.nsdo.org.af` needs PHP 7.4. Add to `/home/nsdopqrj/hr.nsdo.org.af/.htaccess`:

```apache
# Set PHP 7.4
<FilesMatch \.(php4|php5|php3|php2|php|phtml)$>
    SetHandler application/x-httpd-alt-php74
</FilesMatch>
```

*   New app `pr.nsdo.org.af` runs PHP 8.4. Ensure `public/.htaccess` includes the PHP 8.4 handler and root `.htaccess` rewrites to `public/`.
*   Production `.env` was set to `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://pr.nsdo.org.af`, and MySQL credentials (DB `nsdopqrj_pr`, user `nsdopqrj_procurement`). Keep the password only in `.env`.
*   App key: `php artisan key:generate --force`.
*   DB setup: `php artisan migrate:fresh --force`. If you hit MySQL key length errors, add `Schema::defaultStringLength(191);` in `AppServiceProvider::boot()` and retry.
*   Storage link: `php artisan storage:link`.
*   Frontend build: `npm install && npm run build` (outputs to `public/build`).
*   Admin user created: `it@nsdo.org.af` (password set during deployment).
