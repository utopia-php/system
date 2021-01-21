# Utopia System

[![Build Status](https://travis-ci.org/utopia-php/system.svg?branch=master)](https://travis-ci.com/utopia-php/system)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/system.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia framework system library is simple and lite library for managing application translations and localization. This library is aiming to be as simple and easy to learn and use. This library is maintained by the [Appwrite team](https://appwrite.io).

Although this library is part of the [Utopia Framework](https://github.com/utopia-php/framework) project it is dependency free and can be used as standalone with any other PHP project or framework.

## Getting Started

Install using composer:
```bash
composer require utopia-php/system
```

Init in your application:
```php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Utopia\System\System;

// Init translations
System::setLanguage('en-US', ['hello' => 'Hello','world' => 'World']); // Set English
System::setLanguage('he-IL', ['hello' => 'שלום',]); // Set Hebrew

// Get translation

echo Locale::getText('hello'); // prints "שלום"
echo Locale::getText('world'); // prints "World"
```

## System Requirements

Utopia Framework requires PHP 7.4 or later. We recommend using the latest PHP version whenever possible.

## Authors

**Eldad Fux**

+ [https://twitter.com/eldadfux](https://twitter.com/eldadfux)
+ [https://github.com/eldadfux](https://github.com/eldadfux)

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
