# Repository Guidelines

## Project Structure & Module Organization
- `app/`: Laravel application code (controllers, models, jobs, policies).
- `routes/`: route definitions (`web.php`, `console.php`).
- `resources/`: Blade views and frontend assets (`resources/views`, `resources/css/app.css`, `resources/js/app.js`).
- `database/`: migrations, seeders, and factories.
- `tests/`: PHPUnit tests (`tests/Feature`, `tests/Unit`).
- `public/`: web root; compiled assets are served here.
- `storage/`: logs, cache, and local uploads (do not commit generated files).

## Build, Test, and Development Commands
- `composer run setup`: installs PHP and Node dependencies, creates `.env`, generates the app key, runs migrations, and builds frontend assets.
- `composer run dev`: runs Laravel server, queue worker, log tailer, and Vite together.
- `php artisan serve`: backend only.
- `npm run dev`: Vite dev server for frontend assets.
- `npm run build`: production asset build.
- `composer run test` or `php artisan test`: runs the PHPUnit suite in the testing environment.

## Coding Style & Naming Conventions
- Indentation: 4 spaces; YAML uses 2 spaces; LF line endings; trim trailing whitespace (see `.editorconfig`).
- PHP: PSR-4 autoloading; class names in StudlyCase; namespaces match folder structure under `app/`.
- Tests: name files `*Test.php` under `tests/Unit` or `tests/Feature`.
- Formatting: use Laravel Pint when needed (`vendor/bin/pint`).

## Testing Guidelines
- Framework: PHPUnit (configured in `phpunit.xml`); test env uses `DB_DATABASE=testing`.
- Add coverage for new behavior in the appropriate suite and keep tests deterministic.

## Commit & Pull Request Guidelines
- Commits: history uses short sentence-style summaries (for example, `Initial commit`); keep messages concise and descriptive.
- PRs: include a clear summary, testing notes (commands run), and screenshots for UI changes; link related issues if available.

## Configuration & Security
- Keep secrets in `.env` and update `.env.example` for new settings.
- Do not commit generated files from `storage/` or local environment data.
