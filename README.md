# Laravel Modules Asset Management Demo

A comprehensive demonstration of managing assets in a modular Laravel application using symbolic links. This project showcases a solution to the common problem of keeping module assets (JS, CSS, images) isolated within their respective modules while making them accessible to the public web directory.

## The Problem

When building large Laravel applications, developers often adopt a modular architecture to keep code organized. However, managing assets in this architecture presents a significant challenge:

1. **Asset Scattering**: Laravel expects assets to be in the `public` or `resources` directory, forcing developers to separate module logic from its assets.
2. **Module Coupling**: If assets are placed in the main `public` directory, modules are no longer truly independent or easily portable.
3. **Build Complexity**: Configuring build tools (Vite/Mix) to compile assets from multiple module directories can be complex and slow.

## The Solution

This demo implements a clean, elegant solution using a custom Artisan command (`CreateModuleSymlinks`) that creates symbolic links from each module's asset directory directly into the application's `public` directory.

### Key Benefits

- **True Modularity**: JavaScript, CSS, and other assets live right next to the module's PHP code.
- **Zero Build Configuration**: No complex Vite or Webpack configuration required for basic asset serving.
- **Instant Updates**: Because they are symlinks, changes to asset files are immediately reflected in the browser without copying files.
- **Clean Public Directory**: The `public/modules` directory stays organized automatically.

## Project Structure

This demo includes three sample modules to demonstrate the concept:

```text
Modules/
├── Dashboard/
│   └── Assets/
│       ├── js/dashboard.js
│       └── css/dashboard.css
├── Analytics/
│   └── Assets/
│       ├── js/analytics.js
│       └── css/analytics.css
└── Settings/
    └── Assets/
        ├── js/settings.js
        └── css/settings.css
```

When the command is run, it creates the following structure in the public directory:

```text
public/
└── modules/
    ├── dashboard/
    │   ├── js -> ../../Modules/Dashboard/Assets/js
    │   └── css -> ../../Modules/Dashboard/Assets/css
    ├── analytics/
    │   ├── js -> ../../Modules/Analytics/Assets/js
    │   └── css -> ../../Modules/Analytics/Assets/css
    └── settings/
        ├── js -> ../../Modules/Settings/Assets/js
        └── css -> ../../Modules/Settings/Assets/css
```

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- A Unix-like OS (Linux/macOS) or Windows with symlink support enabled

### Installation

1. Clone this repository:
   ```bash
   git clone <repository-url>
   cd laravel-modules-demo
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up your environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **The Magic Step** - Create the module symlinks:
   ```bash
   php artisan modules:symlink
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

6. Visit `http://localhost:8000/modules` in your browser to see the demo in action.

## How to Use This in Your Own Project

To implement this solution in your own Laravel project, you need three main components:

### 1. The Artisan Command

Copy the `app/Console/Commands/CreateModuleSymlinks.php` file to your project. This command scans your `Modules` directory and creates the necessary symlinks.

```php
// Run this whenever you add a new module or asset directory
php artisan modules:symlink
```

### 2. The Asset Helper (Optional but Recommended)

Copy the `app/Helpers/ModuleAssetHelper.php` file to your project. This provides clean, consistent ways to reference your module assets in Blade views.

```php
// In your Blade templates:
<link rel="stylesheet" href="{{ \App\Helpers\ModuleAssetHelper::css('dashboard', 'dashboard.css') }}">
<script src="{{ \App\Helpers\ModuleAssetHelper::js('dashboard', 'dashboard.js') }}"></script>
```

Alternatively, you can use Laravel's built-in `asset()` helper directly:

```php
<link rel="stylesheet" href="{{ asset('modules/dashboard/css/dashboard.css') }}">
```

### 3. Module Service Provider (Optional)

If you want your modules to automatically load their routes and views, copy the `app/Providers/ModuleServiceProvider.php` and register it in your `config/app.php`.

## Testing

This project includes comprehensive PHPUnit tests to verify the symlink command works correctly across different scenarios.

Run the tests using:

```bash
php artisan test
```

The tests verify:
- Symlinks are created for all modules
- Symlinks point to the correct source directories
- Missing directories are handled gracefully
- Existing symlinks are updated correctly
- Asset files are accessible through the symlinks
- The helper class generates correct URLs

## Advanced Usage

### Git Ignore

You should add the generated symlinks to your `.gitignore` file so they aren't committed to your repository:

```text
/public/modules/*
```

### Deployment

During deployment, you should run the symlink command as part of your deployment script (e.g., in Envoyer, Forge, or your CI/CD pipeline):

```bash
php artisan modules:symlink
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
