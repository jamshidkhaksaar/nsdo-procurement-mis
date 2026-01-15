# Repository Guidelines for AI Coding Agents

This document provides comprehensive guidance for AI coding agents working on the Procurement MIS (Management Information System) project.

## Project Overview
A Laravel 12 application for procurement/asset management using Livewire 3 (reactive UI), TailwindCSS 4 (Vite), Laravel Reverb (real-time), Excel/DomPDF (reporting), and Laravel Auditing.

## Project Structure
```
app/
├── Events/           # Broadcast events (ContractCreated, etc.)
├── Http/
│   ├── Controllers/  # Resource controllers (Admin/, Manager/)
│   └── Livewire/     # Reactive components
├── Models/           # Eloquent models (Auditable)
tests/
├── Feature/          # Integration tests (Tests\TestCase)
└── Unit/             # Logic tests (PHPUnit\Framework\TestCase)
```

## Build, Test & Development Commands

### Setup & Development
```bash
composer run setup          # Full setup: install deps, migrate, build assets
composer run dev            # Run server, queue, logs, and Vite concurrently
php artisan serve           # Backend only (http://localhost:8000)
npm run dev                 # Vite dev server (hot-reload)
npm run build               # Production asset build
```

### Testing Commands (CRITICAL)
Always verify changes with tests.
```bash
composer run test                           # Run all tests
php artisan test                            # Run all tests
php artisan test --filter=ContractTest      # Run a single test class
php artisan test --filter=test_method_name  # Run a single test method
php artisan test tests/Feature/ExampleTest.php  # Run specific file
php artisan test --parallel                 # Run tests in parallel
```

### Code Quality
```bash
vendor/bin/pint             # Format all PHP code (Laravel Pint)
vendor/bin/pint app/Models  # Format specific directory
```

## Code Style Guidelines

### General PHP & Naming
- **Standards**: PSR-12/PER. Use 4 spaces for indentation.
- **Namespaces**: Match directory structure (PSR-4).
- **Classes**: StudlyCase (`ContractController`).
- **Methods/Properties**: camelCase (`getStatusAttribute`, `$validatedData`).
- **Database**: snake_case columns (`signed_date`, `vendor_name`).
- **Routes/Views**: dot.notation (`contracts.index`, `contracts.show`).

### Import Organization
Sort imports by category:
1. PHP core classes
2. Laravel/Framework classes
3. Third-party packages
4. App namespace classes

```php
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Contract;
```

### Controller Patterns
- **Type Hinting**: Always type hint method arguments (`Request $request`, `Contract $contract`).
- **Validation**: Validate inline using `$request->validate([...])`.
- **Return**: Use `redirect()->route(...)->with('success', ...)` for mutations; `view(..., compact(...))` for reads.
- **Resourceful**: Stick to standard `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` methods.

```php
public function update(Request $request, Contract $contract)
{
    $validated = $request->validate([
        'vendor_name' => 'required|string|max:255',
        'expiry_date' => 'required|date|after:signed_date',
    ]);
    
    $contract->update($validated);
    
    return redirect()->route('contracts.index')
        ->with('success', 'Contract updated successfully.');
}
```

### Model Patterns
- **Mass Assignment**: Use `$fillable` (whitelist) rather than `$guarded`.
- **Casting**: Define `$casts` for dates/booleans/enums (`'signed_date' => 'date'`).
- **Auditing**: Implement `OwenIt\Auditing\Contracts\Auditable` and use the trait.
- **Relationships**: Define methods with return types (`HasMany`, `BelongsTo`).

```php
class Contract extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['vendor_name', 'signed_date'];
    protected $casts = ['signed_date' => 'date'];

    public function amendments(): HasMany
    {
        return $this->hasMany(ContractAmendment::class);
    }
}
```

### Livewire Patterns
- Use `#[On('event-name')]` attributes for listeners.
- Use `WithPagination` trait for lists.
- Keep `render()` simple, returning the view with data.

### Error Handling
- **External Services**: Wrap in `try-catch`.
- **Reporting**: Use `report($e)` to log exceptions without interrupting flow.
- **Validation**: Allow Laravel's automatic validation exception handling to redirect back with errors.

## Testing Guidelines
- **Feature Tests**: Extend `Tests\TestCase`. Use `RefreshDatabase` trait.
- **Naming**: `test_snake_case_description(): void`.
- **Assertions**: Use specific assertions (`assertRedirect`, `assertViewHas`, `assertDatabaseHas`).

```php
public function test_contract_can_be_created(): void
{
    $response = $this->post(route('contracts.store'), [
        'vendor_name' => 'Acme Corp',
        'signed_date' => now(),
    ]);
    
    $response->assertRedirect(route('contracts.index'));
    $this->assertDatabaseHas('contracts', ['vendor_name' => 'Acme Corp']);
}
```

## Security & Configuration
- Access config via `config('key')`.
- Store secrets in `.env` (never commit).
- Use `auth` middleware for protected routes.
- Sanitize output is handled automatically by Blade `{{ }}`.
