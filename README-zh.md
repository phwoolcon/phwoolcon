# Phwoolcon Bootstrap

Phalcon + Swoole

***

**警告**：此项目现在处于非常早期开发状态，请慎重使用！

***

本项目的目的是创建一个高性能的 Web 应用程序，既可以运行于传统的 php-fpm  
模式下，也可以运行在服务模式下。

在服务模式中，你的应用程序可以减少许多非必要的重复计算，获得极致的性能。

如果在服务模式中出现了 Bug，你可以轻松地关闭服务模式，损失一些性能（但是  
仍然很快）换取稳定性，待 Bug 修复后再启用服务模式。

# 使用
这是 Phwoolcon 库，你可能是要用 [Phwoolcon Bootstrap](https://github.com/phwoolcon/bootstrap) 来创建新项目。

你也可以用 composer 把 Phwoolcon 库加入到你的项目中：

```
composer require "phwoolcon/phwoolcon":"dev-master"
```

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
