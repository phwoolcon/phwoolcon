## Assets

All files under this directory will be symlinked to `public/assets/`,  
which are accessible publicly.  

## Arrange CSS/JS Assets Groups
Assume you have following css/js files:
```text
phwoolcon-package/assets/foo/bar.css
phwoolcon-package/assets/foo/style.css

phwoolcon-package/assets/foo/bar.js
phwoolcon-package/assets/foo/baz.js
```

You can group them in `phwoolcon-package/package.php` like this:
```php
<?php
return [
    'foo/bar' => [
        'assets' => [
            'hello-css' => [
                'foo/style.css',
                'foo/bar.css',
            ],
            'hello-js' => [
                'foo/bar.js',
                'foo/baz.js',
            ],
        ],
    ],
];
``` 

## Introduce CSS/JS in Templates
```php
<?php
/* @var \Phwoolcon\View\Engine\Php $this */
?>
<?= View::assets('hello-css') ?>
<?= View::assets('hello-js') ?>
```
It will present:
```html
<link rel="stylesheet" href="//your-site.com/static/hello.ccd0384a.css" />
<script src="//your-site.com/static/hello.56c31c9b.js"></script>
```
The css/js files will be minimized and combined by default, please see [`config/view.php`](https://github.com/phwoolcon/phwoolcon/blob/master/phwoolcon-package/config/view.php#L37)  
(`view.options.assets_options.apply_filter`) for details.

> **CDN-ready**: The CRC32 checksum will be append to the css/js file,  
> the CDN URL prefix can be set in `view.options.assets_options.cdn_prefix`  
> (please see [`config/view.php`](https://github.com/phwoolcon/phwoolcon/blob/84f0a85e30d7b25deb7e2fd939c6a073761f2b93/phwoolcon-package/config/view.php#L38)).

If `view.options.assets_options.apply_filter` is `false`, css/js will be output as is:
```html
<link rel="stylesheet" href="/assets/foo/style.css" />
<link rel="stylesheet" href="/assets/foo/bar.css" />
<script src="/assets/foo/bar.js"></script>
<script src="/assets/foo/baz.js"></script>
```
