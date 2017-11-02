# Phwoolcon Change Logs

## [v1.1.8](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.8) (2017-11-xx)
#### Features:
* **View**: Add reset item `$this->_mainView`
* Add `UserProfile::generateResetPasswordToken()`
* **Mailer**: Log email content
* **Composer**: Suggest `phwoolcon/mail-renderer`

#### Bug Fixes:
* **View**:
  - Theme fallback detection
  - Renew expiration when calling CSRF token widget

## [v1.1.7](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.7) (2017-10-29)
#### Features:
* **View**:
  - CDN support for compiled assets by config `view.options.assets_options.cdn_prefix`
  - Add CSRF token widget
* **Assets**:
  - Add `addEventListener`, `removeEventListener`, `dispatchEvent`, `CustomEvent` IE8 polyfill
  - Add `Element.prototype.matches` IE8 polyfill
  - Toggle html class `has-js`/`no-js`

## [v1.1.6](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.6) (2017-10-20)
#### Features:
* **View**:
  - Generate more detailed IDE helper for `Widget` class
  - Two-parameter invocation on `View::render()`  
    - Phalcon like:  
      `View::render(string $controllerName[, string $actionName[, array $params]])`
    - Two-parameter:  
      `View::render(string $path[, array $params])`

* Update Phwoolcon skeleton:
  - `.editorconfig`: Do not insert final newline for minimized js/css

#### Bug Fixes:
* **Assets**: `$p.log()` throws `Uncaught TypeError: Illegal invocation` in old Chrome browser

## [v1.1.5](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.5) (2017-10-18)
#### Features:
* **Assets**:
  - Add `document.head` IE8 polyfill
  - Add `console.log.apply` IE8 polyfill
  - Sort resources with flag `SORT_NATURAL`
* Compatible with Phalcon 3.2.3, which introduces a [backward incompatible change](https://github.com/phalcon/cphalcon/commit/3f703832786c7fb7a420bcf31ea0953ba538591d)

#### Bug Fixes:
* **Error Codes**: Skip `getAllErrorCodes()` in the first run because DI not ready
* Use numeric version id for `$_SERVER['PHWOOLCON_PHALCON_VERSION']`
* Set `$this->_viewParams` directly to avoid `First argument is not an array` error in `Phalcon\Mvc\View::setVars()`

#### Tests:
Run phpunit from `vendor/bin`

## [v1.1.4](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.4) (2017-10-12)
#### Features:
* **Composer**: Update dependency versions
* **Assets**:
  - Add `$p.trace()` to phwoolcon.js
  - Add `$p.ajax.get()` and `$p.ajax.post()` to phwoolcon.js

## [v1.1.3](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.3) (2017-10-9)
#### Features:
* Add HTTP client
#### Bug Fixes:
* Windows compatibility

## [v1.1.2](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.2) (2017-9-27)
#### Features:
* **Error Codes**:
  - Be able to annotate numeric error codes
  - Add method to get all codes

## [v1.1.1](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.1) (2017-9-26)
#### Features:
* **Error Codes**: Generate and return an exception by `ErrorCodes::genXx()` magic method

## [v1.1.0](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.1.0) (2017-9-25)
#### Features:
* **I18n**: Ability to append/override locale by sub directory
* **Error Codes**:
  - Add class `Phwoolcon\ErrorCodes` and its alias `ErrorCodes`;
  - Detect error codes in locale file `error_codes.php`, format: `'code' => 'message'`;
  - Generate IDE helper for `ErrorCodes::getYourCustomizedCode($param ...)` auto-completion;

## [v1.0.9](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.9) (2017-9-13)
#### Features:
* **Assets**: Add `utils.js`

## [v1.0.8](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.8) (2017-9-12)
#### Features:
* Add `publicPath()` function
* **Assets**:
  - Add group `phwoolcon-js`
  - Add group `ie-hack-js`
  - Remove jQuery dependency

#### Bug Fixes:
* Adjust register sequence of services

## [v1.0.7](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.7) (2017-9-7)
#### Features:
* Update Phwoolcon skeleton:
  - Disable twitter question
  - Allow php 5.5 to pass phwoolcon travis build
  - Update Apache license text

#### Tests:
* **Travis**: Compatible with the trusty environment

## [v1.0.6](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.6) (2017-9-6)
#### Features:
* Add `package:create` command to create a new Phwoolcon package
* **Dev Mode**: Introduce `phwoolcon/skeleton` (based on `thephpleague/skeleton`)

#### Tests:
* **Session**: Compatible with php 7.2
* **Travis**: Compatible with the trusty environment

## [v1.0.5](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.5) (2017-8-23)
#### Bug Fixes:
* Logger error in resource update script when DB `query_log` is enabled
* **Composer**: Remove mcrypt dependency
#### Tests:
* **Travis**: Add php 7.2 env
* **Session**: Compatible with php 7.2

## [v1.0.4](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.4) (2017-8-22)
#### Features:
* Add http redirect exception

## [v1.0.3](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.3) (2017-8-18)
#### Features:
* **Controller**: Add getRawPhpInput() method

#### Tests:
* **Travis**: Do not build tags

## [v1.0.2](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.2) (2017-8-15)
#### Features:
* **Text**: Optimize Phalcon\Text::random(RANDOM_ALNUM)

## [v1.0.1](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.1) (2017-8-10)
#### Features:
* **Queue**: Apply soft delete for db queue jobs

## [v1.0.0](https://github.com/phwoolcon/phwoolcon/releases/tag/v1.0.0) (2017-7-18)
#### Initial release
