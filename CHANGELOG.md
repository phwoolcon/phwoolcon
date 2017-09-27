# Phwoolcon Change Logs

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
* Adjust register sequence of servicies

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
