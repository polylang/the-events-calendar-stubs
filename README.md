# The Events Calendar Stubs

This package provides stub declarations for [The Events Calendar](https://wordpress.org/plugins/the-events-calendar/).
These stubs can help plugin and theme developers leverage static analysis tools like [PHPStan](https://phpstan.org/).

Stubs are generated directly from the source using [php-stubs/generator](https://github.com/php-stubs/generator).

## Requirements

- PHP >=7.3

## Installation

Require this package as a development dependency with Composer.

```bash
composer require --dev wpsyntex/the-events-calendar-stubs
```

## Usage in PHPStan

Include the stubs in the PHPStan configuration file.

```yaml
parameters:
  bootstrapFiles:
    - vendor/wpsyntex/the-events-calendar-stubs/the-events-calendar-stubs.php
```
