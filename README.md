# Phwoolcon

[![Build Status](https://travis-ci.org/phwoolcon/phwoolcon.svg?branch=master)](https://travis-ci.org/phwoolcon/phwoolcon)

Phalcon + Swoole

***

**WARNING**: This library is in very early stage of development, use at your own risk!

***

The purpose of this library is to create a high performance web application,
which can run in traditional php-fpm mode and service mode.

In service mode, you gain extreme speed for your application.

If you have bugs in service mode, you can easily turn off the service mode, you loose some speed (but still fast) to gain more stability, fix your bugs and apply service mode again.

# Usage
This is the Phwoolcon library, you may use [Phwoolcon Bootstrap](https://github.com/phwoolcon/bootstrap) to start a new project.

Or add this library to your project by composer:

```
composer require "phwoolcon/phwoolcon":"dev-master"
```
