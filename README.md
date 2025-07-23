# Laravel Dynamic Config

A Laravel utility for accessing configuration values stored in the database with caching support.

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

DynamicConfig provides a simple, singleton-based interface to retrieve configuration values saved in a database table. It caches the configuration collection for performance and supports retrieving values as strings, integers, floats, booleans, or even as related models.

---

## Features

- Load config key-value pairs from a `config` database table.
- Cache configuration values indefinitely using Laravel's cache.
- Singleton pattern for efficient, repeated access.
- Type-safe getters: string, int, float, boolean.
- Easily extendable for custom retrieval logic.
- Fully tested with PHPUnit and Mockery.

---

## Installation

Require the package via Composer:

```bash
composer require anthhyo/dynamic-dynamic
````

---

## Usage

```php
use Anthhyo\DynamicConfig\DynamicConfig;

// Retrieve raw string value
$value = DynamicConfig::get('some_config_key', 'default_value');

// Retrieve boolean
$enabled = DynamicConfig::getBoolean('feature_enabled', false);

// Retrieve integer
$maxItems = DynamicConfig::getInt('max_items', 10);

// Retrieve float
$piValue = DynamicConfig::getFloat('pi_constant', 3.14);
```

---

## Configuration

Make sure you have a `config` table with at least two columns: `Name` and `Value`. This package expects your config keys to be stored in the `Name` column, with their corresponding values in the `Value` column.

## Testing

---

To run tests:

```bash
composer install
./vendor/bin/phpunit
```

---

## Requirements

* PHP 8.1.3 or higher
* Laravel's Illuminate Support package (v10 or v11)

---

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the issues page and submit pull requests.

---

## License

This project is licensed under the MIT License.
