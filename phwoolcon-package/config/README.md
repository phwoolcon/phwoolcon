## Configuration

All `.php` files under this directory will be symlinked to `app/config/`,  
then they will be read by `Phwoolcon\Config`.

For example: `phwoolcon-package/config/foo.php` has following content: 
```php
<?php
return [
    'hello' => 'world',
];
```
Then you can read it:
```php
<?php
use Config;

var_dump(Config::get('foo.hello')); // string(5) "world"
```

## Overriding
If you need to override some config items (for example `app.timezone`,  
which is `'UTC'` in `phwoolcon/phwoolcon`), please do not create `app.php`  
just under this directory, put it under a `override-*` subdirectory instead

Don't do this:
```text
phwoolcon-package/config/app.php                ✗
```

Do this:
```text
phwoolcon-package/config/override-10/app.php    ✓
```
