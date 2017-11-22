# Phwoolcon

[![Latest Version on Packagist](https://img.shields.io/github/release/phwoolcon/phwoolcon.svg?style=flat-square)](https://packagist.org/packages/phwoolcon/phwoolcon)
[![Build Status](https://img.shields.io/travis/phwoolcon/phwoolcon/master.svg?style=flat-square)](https://travis-ci.org/phwoolcon/phwoolcon)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phwoolcon/phwoolcon.svg?style=flat-square)](https://scrutinizer-ci.com/g/phwoolcon/phwoolcon/code-structure/master/code-coverage)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phwoolcon/phwoolcon.svg?style=flat-square)](https://scrutinizer-ci.com/g/phwoolcon/phwoolcon/)
[![Gitter](https://img.shields.io/gitter/room/phwoolcon/phwoolcon.svg?style=flat-square)](https://gitter.im/phwoolcon/phwoolcon?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Supported PHP versions](https://img.shields.io/badge/php-5.5%20~%207.2-blue.svg?style=flat-square)](https://secure.php.net/)
[![Supported Phalcon versions](https://img.shields.io/badge/Phalcon-%E2%89%A5%203.0-blue.svg?style=flat-square)](https://phalconphp.com/)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg?style=flat-square)](LICENSE)

Phalcon + Swoole

***
[中文 Readme](README-zh.md)  
[Why Do I Start Phwoolcon Project](https://github.com/phwoolcon/phwoolcon/wiki/%E4%B8%BA%E4%BB%80%E4%B9%88%E8%A6%81%E5%BC%80%E5%8F%91-Phwoolcon)

The purpose of this library is to create a high performance  
web application, which can run in traditional php-fpm mode and  
service mode.

In service mode, you gain extreme speed for your application,  
by reducing lot of unnecessary and repetitive computing.

If you have bugs in service mode, you can easily turn off the service  
mode, you loose some speed (but still fast) to gain more stability,  
fix your bugs and apply service mode again.

# Usage

## Installation
This is the Phwoolcon library, you may use [Phwoolcon Bootstrap](https://github.com/phwoolcon/bootstrap)  
to start a new project.

Or add this library to your project by composer:

```
composer require phwoolcon/phwoolcon
```

## Code Style Checking

Please run the following script:
```
tests/phpcs
```
Any warnings or errors will be reported in file:
```
tests/root/storage/phpcs.txt
```

## Testing

Please run the following script:
```
tests/phpunit
```
The code coverage report in HTML format will be generated in folder:
```
tests/root/storage/coverage/
```
To read the report, please open `index.html` in a web browser.

## Configuration
See [phwoolcon-package/config/](phwoolcon-package/config/)
## Templates
See [phwoolcon-package/views/](phwoolcon-package/views/)
## Assets
See [phwoolcon-package/assets/](phwoolcon-package/assets/)
## Locale
See [phwoolcon-package/locale/](phwoolcon-package/locale/)
## Dependency Injection
See [phwoolcon-package/di.php](phwoolcon-package/di.php)

# Spirits
* Aimed at performance
* Aimed at scalability
* Powerful features, with intuitive and readable codes
* Component based, explicitly introduced
* Configurable features
* Code testability
* Follow standard coding style (based on [PSR-2](http://www.php-fig.org/psr/psr-2/))

# Features

## Base Components
* Extended Phalcon Config (Both in native PHP file and DB)
* Phalcon Cache
* Extended Phalcon ORM
* Error Codes
* View: Theme based layouts and templates
* Multiple DB connector
* Events
* Configurable Cookies
* Session
* Openssl based encryption/decryption
* Multiple Queue producer and asynchronous CLI worker
* Assets: Theme based, compilable JS/CSS management
* Log
* Lighten route dispatcher
* Internalization
* Finite state machine
* Simple HTTP client
* Swift Mailer
* Symfony CLI console

# Documents
* [API Reference](docs/ApiIndex.md)
