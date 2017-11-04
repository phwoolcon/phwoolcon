## Templates

All files under this directory will be symlinked to `app/views/`,  
then you can use them by `$this->render()` (in controllers),  
or `$this->include()` (inside templates).

For example:

`phwoolcon-package/views/default/foo.phtml` [[<sup>1</sup>]](#mark-1):
```php
<?php
/* @var \Phwoolcon\View\Engine\Php $this */
/* @var string $name */
?>
<h1><?= __('Hello %name%', ['name' => $name]) ?></h1>
<div>
    <?php $this->include('bar.phtml') ?>
</div>
```
`phwoolcon-package/views/default/bar.phtml`:
```php
<?php
/* @var \Phwoolcon\View\Engine\Php $this */
?>
<p><?= __('Welcome to Bar') ?></p>
```
<a name="mark-1"></a>
> [1]: The term `default` in the path is the theme name, please see [`config/view.php`](https://github.com/phwoolcon/phwoolcon/blob/84f0a85e30d7b25deb7e2fd939c6a073761f2b93/phwoolcon-package/config/view.php#L19)  
(`view.theme`) for details.

Then you can render it in a controller:
```php
<?php
/* @var \Phwoolcon\Controller $this */
$this->render('foo', ['name' => 'John']);
```
It will present:
```html
<h1>Hello John</h1>
<div>
    <p>Welcome to Bar</p>
</div>
```
