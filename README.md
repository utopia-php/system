# Utopia System

[![Build Status](https://travis-ci.com/utopia-php/system.svg?branch=main)](https://travis-ci.com/utopia-php/system)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/system.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia System library is a simple and lite library to obtain information about the host's system, and provides an easy way to detect on which CPU architecture your code is running. This library is aiming to be as simple and easy to learn and use. This library is maintained by the [Appwrite team](https://appwrite.io).

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

echo System::getOS(); // prints "Linux" for example
echo System::getHostname(); // Your hostname
echo System::getArch(); // x86_64

echo System::isArm(); // bool
echo System::isPPC(); // bool
echo System::isX86(); // bool
```

## System Requirements

Utopia Framework requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Supported Methods
|         | getCPUCores | getCPUUsage | getMemoryTotal | getMemoryFree | getDiskTotal | getDiskFree | getIOUsage | getNetworkUsage |
|---------|-------------|-------------------|----------------|---------------|--------------|-------------|------------|-----------------|
| Windows | ✅           |                   |                |               | ✅            | ✅           |            |                 |
| MacOS   | ✅           |                   | ✅              | ✅             | ✅            | ✅           |            |                 |
| Linux   | ✅           | ✅                 | ✅              | ✅             | ✅            | ✅           | ✅          | ✅               |

## Authors

**Eldad Fux**

+ [https://twitter.com/eldadfux](https://twitter.com/eldadfux)
+ [https://github.com/eldadfux](https://github.com/eldadfux)

**Torsten Dittmann**

+ [https://twitter.com/dittmanntorsten](https://twitter.com/dittmanntorsten)
+ [https://github.com/torstendittmann](https://github.com/torstendittmann)

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
