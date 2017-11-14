# Phwoolcon

[![Build Status](https://img.shields.io/travis/phwoolcon/phwoolcon/master.svg?style=flat-square)](https://travis-ci.org/phwoolcon/phwoolcon)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phwoolcon/phwoolcon.svg?style=flat-square)](https://scrutinizer-ci.com/g/phwoolcon/phwoolcon/code-structure/master/code-coverage)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phwoolcon/phwoolcon.svg?style=flat-square)](https://scrutinizer-ci.com/g/phwoolcon/phwoolcon/reports/)
[![Gitter](https://img.shields.io/gitter/room/phwoolcon/phwoolcon.svg?style=flat-square)](https://gitter.im/phwoolcon/phwoolcon?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Supported PHP versions](https://img.shields.io/badge/php-5.5%20~%207.2-blue.svg?style=flat-square)](https://secure.php.net/)
[![Supported Phalcon versions](https://img.shields.io/badge/Phalcon-%E2%89%A5%203.0-blue.svg?style=flat-square)](https://phalconphp.com/)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg?style=flat-square)](https://opensource.org/licenses/Apache-2.0)

Phalcon + Swoole

***
[为什么要开发 Phwoolcon](https://github.com/phwoolcon/phwoolcon/wiki/%E4%B8%BA%E4%BB%80%E4%B9%88%E8%A6%81%E5%BC%80%E5%8F%91-Phwoolcon)

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
composer require phwoolcon/phwoolcon
```

## 代码风格检查

请运行以下脚本：
```
tests/phpcs
```
警告和错误报告会被保存在这个文件里：
```
tests/root/storage/phpcs.txt
```

## 测试

请运行以下脚本：
```
tests/phpunit
```
代码覆盖率报告会以 HTML 格式被保存在这个文件夹里：
```
tests/root/storage/coverage/
```
用浏览器打开 `index.html` 即可阅读报告。

## 配置
请见 [phwoolcon-package/config/](phwoolcon-package/config/)
## 模板
See [phwoolcon-package/views/](phwoolcon-package/views/)
## 静态资源
See [phwoolcon-package/assets/](phwoolcon-package/assets/)
## 翻译/语言
See [phwoolcon-package/locale/](phwoolcon-package/locale/)
## 依赖注入
See [phwoolcon-package/di.php](phwoolcon-package/di.php)

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

# 文档
* [API 参考文档](docs/ApiIndex.md)
