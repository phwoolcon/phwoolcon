# Phwoolcon

[![Build Status](https://travis-ci.org/phwoolcon/phwoolcon.svg?branch=master)](https://travis-ci.org/phwoolcon/phwoolcon)
[![Code Coverage](https://codecov.io/gh/phwoolcon/phwoolcon/branch/master/graph/badge.svg)](https://codecov.io/gh/phwoolcon/phwoolcon)
[![Gitter](https://badges.gitter.im/phwoolcon/phwoolcon.svg)](https://gitter.im/phwoolcon/phwoolcon?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
![Supported PHP versions: 5.5 .. 7.1](https://img.shields.io/badge/php-5.5%20~%207.1-blue.svg)
![Supported Phalcon versions: >= 3.0](https://img.shields.io/badge/Phalcon-%E2%89%A5%203.0-blue.svg)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)

Phalcon + Swoole

***

本项目的目的是创建一个高性能的 Web 应用程序，既可以运行于传统的 php-fpm  
模式下，也可以运行在服务模式下。

在服务模式中，你的应用程序可以减少许多非必要的重复计算，获得极致的性能。

如果在服务模式中出现了 Bug，你可以轻松地关闭服务模式，损失一些性能（但是  
仍然很快）换取稳定性，待 Bug 修复后再启用服务模式。

# 使用

## 安装
这是 Phwoolcon 库，你可能是要用 [Phwoolcon Bootstrap](https://github.com/phwoolcon/bootstrap) 来创建新项目。

你也可以用 composer 把 Phwoolcon 库加入到你的项目中：

```
composer require "phwoolcon/phwoolcon":"dev-master"
```

## 代码风格检查

### 系统要求
代码风格检查依赖于 `phpcs`。如果你还没有安装 `phpcs`，请运行：
```
pear install PHP_CodeSniffer
```

### 进行检查
请运行以下脚本：
```
tests/phpcs
```
警告和错误报告会被保存在这个文件里：
```
tests/root/storage/phpcs.txt
```

## 测试

### 系统要求
测试依赖于 `phpunit`。如果你还没有安装 `phpunit`，请运行：
```
wget https://phar.phpunit.de/phpunit.phar -O /usr/local/bin/phpunit
chmod +x /usr/local/bin/phpunit
```

### 进行测试
请运行以下脚本：
```
tests/phpunit
```
代码覆盖率报告会以 HTML 格式被保存在这个文件夹里：
```
tests/root/storage/coverage/
```
用浏览器打开 `index.html` 即可阅读报告。

# 主旨
* 关注性能
* 关注可伸缩性
* 提供强大的功能，但是保持直观易读的代码
* 基于组件，显式引入
* 功能可配置
* 代码可测试性
* 规范的代码风格（基于 [PSR-2](http://www.php-fig.org/psr/psr-2/)）

# 功能

## 基础组件
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

# 文档
* [API 参考文档](docs/ApiIndex.md)
