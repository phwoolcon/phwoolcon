# Phwoolcon

[![Build Status](https://travis-ci.org/phwoolcon/phwoolcon.svg?branch=master)](https://travis-ci.org/phwoolcon/phwoolcon)
[![Code Coverage](https://codecov.io/gh/phwoolcon/phwoolcon/branch/master/graph/badge.svg)](https://codecov.io/gh/phwoolcon/phwoolcon)
[![Gitter](https://badges.gitter.im/phwoolcon/phwoolcon.svg)](https://gitter.im/phwoolcon/phwoolcon?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
![Supported PHP versions: 5.5 .. 7.1](https://img.shields.io/badge/php-5.5%20~%207.1-blue.svg)
![Supported Phalcon versions: >= 3.0](https://img.shields.io/badge/Phalcon-%E2%89%A5%203.0-blue.svg)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)

Phalcon + Swoole

***
[中文 Readme](README-zh.md)

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
composer require "phwoolcon/phwoolcon":"dev-master"
```

## Code Style Checking

### Requirements
Code style checking depends on `phpcs`.  
If you don't have `phpcs` installed, please run:
```
pear install PHP_CodeSniffer
```

### Run Checking
Please run the following script:
```
tests/phpcs
```
Any warnings or errors will be reported in file:
```
tests/root/storage/phpcs.txt
```

## Testing

### Requirements
Testings depends on `phpunit`.  
If you don't have `phpunit` installed, please run:
```
wget https://phar.phpunit.de/phpunit.phar -O /usr/local/bin/phpunit
chmod +x /usr/local/bin/phpunit
```

### Run Testings
Please run the following script:
```
tests/phpunit
```
The code coverage report in HTML format will be generated in folder:
```
tests/root/storage/coverage/
```
To read the report, please open `index.html` in a web browser.

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
* Mail
* Symfony CLI console

# Documents
* [API Reference](docs/ApiIndex.md)
