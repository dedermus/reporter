Exception reporter for Open-Admin-Core
=================================

This tool stores the exception information into the database and provides a developer-friendly web interface to view the exception information.

[![StyleCI](https://styleci.io/repos/508366116/shield?branch=main)](https://styleci.io/repos/508366116)
[![Packagist](https://img.shields.io/github/license/open-admin-org/reporter.svg?maxAge=2592000&style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-ext/reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/open-admin-ext/reporter.svg?style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-ext/reporter)
[![Pull request welcome](https://img.shields.io/badge/pr-welcome-green.svg?style=flat-square&color=brightgreen)]()

## Screenshot

![open-admin-reporter](https://user-images.githubusercontent.com/86517067/176226958-b3ed0a1c-7b87-4e43-a2fd-f487f110d9f5.png)


## Installation

```
$ composer require dedermus/reporter

$ php artisan vendor:publish --tag=open-admin-reporter

$ php artisan migrate --path=vendor/dedermus/reporter/database/migrations

$ php artisan admin:import reporter
```

Open `bootstrap/app.php`,
1) Add: `use OpenAdminCore\Admin\Reporter\Reporter;`
2) Call `$exceptions->reportable(function (Throwable $e) {
   Reporter::report($e);
   });` inside `Application` ... `withExceptions` method:
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use OpenAdminCore\Admin\Reporter\Reporter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
 ->withExceptions(function (Exceptions $exceptions) {

    // Add This line
    $exceptions->reportable(function (Throwable $e) {
        Reporter::report($e);
    });
})->create();

```

Open `http://localhost/admin/exceptions` to view exceptions.

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
