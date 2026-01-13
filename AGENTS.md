# Repository Guidelines for AI Coding Agents

This document provides comprehensive guidance for AI coding agents working on the Procurement MIS (Management Information System) project.

## Project Overview

A Laravel 12 application for procurement and asset management with:
- Livewire 3 for reactive UI components
- TailwindCSS 4 for styling (via Vite)
- Laravel Reverb for real-time broadcasting
- Maatwebsite Excel for exports
- DomPDF for PDF generation
- Laravel Auditing for change tracking

## Project Structure

```
app/
├── Events/           # Broadcast events (ContractCreated, AssetDeleted, etc.)
├── Exports/          # Excel export classes (Maatwebsite/Excel)
├── Http/
│   ├── Controllers/  # Main controllers
│   │   ├── Admin/    # Admin-only controllers (users, settings, audits)
│   │   ├── Auth/     # Authentication controllers
│   │   └── Manager/  # Manager-only controllers (asset types, provinces)
│   └── Middleware/   # Custom middleware
├── Livewire/         # Livewire components
├── Mail/             # Mailable classes
├── Models/           # Eloquent models
├── Observers/        # Model observers
├── Providers/        # Service providers
└── Traits/           # Reusable traits
database/
├── factories/        # Model factories
├── migrations/       # Database migrations
└── seeders/          # Database seeders
resources/
├── css/app.css       # TailwindCSS entry point
├── js/app.js         # JavaScript entry point
└── views/            # Blade templates
routes/
├── web.php           # Web routes
└── console.php       # Artisan commands
tests/
├── Feature/          # Feature tests (extend Tests\TestCase)
└── Unit/             # Unit tests (extend PHPUnit\Framework\TestCase)
```

## Build, Test & Development Commands

### Setup & Development
```bash
composer run setup          # Full setup: install deps, migrate, build assets
composer run dev            # Run server, queue, logs, and Vite together
php artisan serve           # Backend only (http://localhost:8000)
npm run dev                 # Vite dev server for hot-reload
npm run build               # Production asset build
```

### Testing Commands
```bash
composer run test                           # Run all tests
php artisan test                            # Run all tests
php artisan test --filter=ContractTest      # Run single test class
php artisan test --filter=test_method_name  # Run single test method
php artisan test tests/Feature/ExampleTest.php  # Run specific file
php artisan test --parallel                 # Run tests in parallel
```

### Code Formatting
```bash
vendor/bin/pint             # Format all PHP code with Laravel Pint
vendor/bin/pint --test      # Check formatting without changes
vendor/bin/pint app/Models  # Format specific directory
```

### Useful Artisan Commands
```bash
php artisan make:model ModelName -mfc       # Model with migration, factory, controller
php artisan make:livewire ComponentName     # Create Livewire component
php artisan make:event EventName            # Create broadcast event
php artisan make:observer ModelObserver     # Create model observer
php artisan migrate:fresh --seed            # Reset database with seeds
php artisan queue:listen --tries=1          # Process queued jobs
```

## Code Style Guidelines

### Formatting Rules (see .editorconfig)
- Indentation: 4 spaces (2 for YAML)
- Line endings: LF (Unix-style)
- Trim trailing whitespace
- Insert final newline
- Use Laravel Pint for PHP formatting

### PHP & Naming Conventions
- **Namespaces**: PSR-4, match folder structure (`App\Http\Controllers\Admin\UserController`)
- **Classes**: StudlyCase (`ContractController`, `AssetExport`)
- **Methods**: camelCase (`getStatusAttribute`, `viewContract`)
- **Properties**: camelCase (`$selectedContract`, `$showModal`)
- **Database columns**: snake_case (`vendor_name`, `contract_reference`)
- **Route names**: dot notation (`contracts.index`, `admin.users.store`)
- **Views**: dot notation matching folder structure (`contracts.create`, `livewire.contract-list`)

### Import Organization
Order imports as follows:
1. PHP built-in classes
2. Laravel/Illuminate classes
3. Third-party packages
4. Application classes (App\...)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;           // Laravel core
use Maatwebsite\Excel\Facades\Excel;   // Third-party
use App\Models\Contract;                // Application
use App\Exports\AssetExport;            // Application
```

### Controller Patterns
- Use resource controllers with standard methods: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`
- Validate input inline with `$request->validate([...])`
- Use route model binding for single-resource operations
- Return redirects with flash messages for success/error feedback

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'vendor_name' => 'required|string|max:255',
        'contract_reference' => 'required|string|unique:contracts',
    ]);

    Contract::create($validated);

    return redirect()->route('contracts.index')
        ->with('success', 'Contract created successfully.');
}
```

### Model Patterns
- Define `$fillable` for mass assignment protection
- Use `$casts` for date and type casting
- Define relationships with explicit return types
- Use accessors for computed attributes (`getStatusAttribute`)
- Implement `Auditable` interface for audit logging

```php
class Contract extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['vendor_name', 'signed_date', 'expiry_date'];
    protected $casts = ['signed_date' => 'date', 'expiry_date' => 'date'];

    public function amendments(): HasMany
    {
        return $this->hasMany(ContractAmendment::class);
    }
}
```

### Livewire Component Patterns
- Use `WithPagination` trait for paginated lists
- Use `#[On('event')]` attributes for event listeners
- Public properties are automatically reactive
- Return views from `render()` method with data array

```php
class ContractList extends Component
{
    use WithPagination;

    public $search = '';
    
    #[On('echo:contracts,ContractCreated')]
    public function refreshList() {}

    public function render()
    {
        return view('livewire.contract-list', [
            'contracts' => Contract::paginate(10),
        ]);
    }
}
```

### Error Handling
- Use try-catch for external services (mail, API calls)
- Use `report($e)` to log exceptions without interrupting flow
- Validate all user input at controller level
- Use Laravel's built-in validation rules

```php
try {
    Mail::to($users)->send(new NotificationMail());
} catch (\Exception $e) {
    report($e);  // Log error but continue execution
}
```

### Testing Guidelines
- Feature tests extend `Tests\TestCase` (has Laravel application)
- Unit tests extend `PHPUnit\Framework\TestCase` (no Laravel)
- Name test methods: `test_descriptive_action_name(): void`
- Use `RefreshDatabase` trait for database tests
- Test files must end with `Test.php`

```php
class ContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_contract(): void
    {
        $response = $this->post('/contracts', [...]);
        $response->assertRedirect('/contracts');
    }
}
```

## Configuration & Security

- Store secrets in `.env`, never commit them
- Update `.env.example` when adding new config keys
- Use `config('key')` or `env('KEY')` to access values
- Test environment uses `DB_DATABASE=testing`
- Do not commit `storage/` generated files

## Routing Conventions

- Public routes: no middleware
- Auth routes: `middleware('auth')`
- Admin routes: `middleware('can:isAdmin')` with `admin.` prefix
- Manager routes: `middleware('can:isManager')` with `manager.` prefix
- Use resource routes where applicable: `Route::resource('contracts', ContractController::class)`

## Commit & PR Guidelines

- Commits: short, descriptive messages ("Add contract expiry validation")
- PRs: include summary, testing notes, screenshots for UI changes
- Link related issues when available
