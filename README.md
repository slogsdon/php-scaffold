# Scaffold

> Minimal web application toolkit

### Features

- Minimal configuration
- Extendable

### Reasoning

PHP is easy to install, if not already present on you computer. PHP runs pretty much everywhere. PHP is flexible.

## Requirements

- [PHP 7.1+](http://www.php.net)
- [Composer](https://getcomposer.org/)

## Getting Started

```json
{
    "name": "user/site",
    "description": "",
    "require": {
        "slogsdon/scaffold": "dev-master"
    },
    "scripts": {
        "start": "@php -S 127.0.0.1:9000 -t public"
    },
    "config": {
        "process-timeout": 0
    }
}
```

The `scripts` and `config` sections are not required, but they do help simplify the development process. If using the `start` script, the `process-timeout` configuration option allows Composer to run a script for longer than the default timeout (300 seconds).

If not using Composer script configurations, you'll need to manually run a PHP web server, e.g.:

```
php -S 127.0.0.1:9000 -t public
```

After setting up your `composer.json` file, don't forget to pull down your dependencies:

```
composer install
```

### Adding an Entrypoint

Next, your web server will need an entrypoint to serve requests. Scaffold uses the front controller pattern, so it's safe to route all PHP traffic to this entrypoint, here defined as `public/index.php`:

```php
<?php /* public/index.php */

// bootstrap
require '../vendor/autoload.php';

$app = new Scaffold\Application();

// define routes
$app->route->get('/', function ($request, $response) use ($app) {
    $response->getBody()->write('Hello, world');
    
    return $response;
});

$app->run();
```

### Running the Development Server

Ready to test? Spin up the development server:

```
composer start
```

This will start a PHP development server listening on `http://localhost:3000`. Pressing `Ctrl-C` will stop the server, freeing the way for your project's continued development.

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
