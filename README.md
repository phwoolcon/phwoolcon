# Phwoolcon

[![Build Status](https://travis-ci.org/phwoolcon/phwoolcon.svg?branch=master)](https://travis-ci.org/phwoolcon/phwoolcon)
[![Code Coverage](https://codecov.io/gh/phwoolcon/phwoolcon/branch/master/graph/badge.svg)](https://codecov.io/gh/phwoolcon/phwoolcon)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)

Phalcon + Swoole

***

**WARNING**: This library is in very early stage of development,  
use at your own risk!

***

The purpose of this library is to create a high performance  
web application, which can run in traditional php-fpm mode and  
service mode.

In service mode, you gain extreme speed for your application,  
by reducing lot of unnecessary and repetitive computing.

If you have bugs in service mode, you can easily turn off the service  
mode, you loose some speed (but still fast) to gain more stability,  
fix your bugs and apply service mode again.

# Usage
This is the Phwoolcon library, you may use [Phwoolcon Bootstrap](https://github.com/phwoolcon/bootstrap)  
to start a new project.

Or add this library to your project by composer:

```
composer require "phwoolcon/phwoolcon":"dev-master"
```

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

[中文](README-zh.md)
