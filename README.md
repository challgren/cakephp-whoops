# Whoops for CakePHP

[![CI](https://github.com/dereuromark/cakephp-whoops/workflows/CI/badge.svg?branch=master)](https://github.com/dereuromark/cakephp-whoops/actions?query=workflow%3ACI+branch%3Amaster)
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-whoops/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops)
[![Latest Stable Version](https://poser.pugx.org/dereuromark/cakephp-whoops/v/stable.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/dereuromark/cakephp-whoops)

Seamlessly integrate [Whoops] into [CakePHP] applications.

Demo-Video: [Linux Mint + Firefox](https://streamable.com/s/h63t3/xweicf)

This branch is for use with **CakePHP 4.2+**. For details see [version map](https://github.com/dereuromark/cakephp-whoops/wiki#cakephp-version-map).

## Install

Using [Composer]:

```
composer require dereuromark/cakephp-whoops
```

As this package only offers a Whoops handler for CakePHP, there is no need to
enable it (no `Plugin::load()` call). You only need to configure that handler instead of CakePHP's own
`ErrorHandler` by replacing the following line in `bootstrap.php`:

```php
(new ErrorHandler(Configure::read('Error')))->register();
```

with the Whoops handler:

```php
(new \CakephpWhoops\Error\WhoopsHandler(Configure::read('Error')))->register();
```

When using new Application.php and Middleware approach, you also need to adjust that:
```php
// Replace ErrorHandlerMiddleware with
 ->add(new \CakephpWhoops\Error\Middleware\WhoopsHandlerMiddleware(Configure::read('Error')))
```

### Debug Mode
An important note: This plugin is installed as require dependency, but even so it is more used as require-dev one.
If the debug mode is off, it will completely ignore the Whoops handler, as without debug mode there is no exception to render.
It will then display the public error message and only log internally.

So make sure you enable debug (locally) for checking out this package.
For each error and exception you should then see the improved whoops handler output on your screen.

## Editor
Opening the file in the editor via click in the browser is supported for most major IDEs.
It uses `phpstorm://` URLs which can open the file through a command line call and directly jump to the right line.

Set your config as
```php
	'Whoops' => [
		'editor' => true,
	],
```
To enable it.

If you are using a VM, e.g. CakeBox, you will also need the path mapping:
```php
		'userBasePath' => 'C:\wamp\www\cakebox\Apps\my-app.local',
		'serverBasePath' => '/home/vagrant/Apps/my-app.local',
```


If you would like to override the default URL handler (`phpstorm://`) you could do so by setting the `ideLinkPattern` option to a custom URL handler:

* PhpStorm: `phpstorm://open?file=%s&line=%s`
* Visual Studio Code: `vscode://file/%s:%s`

See the Wiki for more details on different OS and Browsers.

## Strictness
As a bonus the error handler is a bit more strict here for development.
It will not just ignore notices and other errors, but display them the same way in order to fix them with the same ease and speed as exceptions.

Usually, when a variable is not found, all following code can also not yield any useful results, as the example below shows.
Better to code cleaner in the first place and to avoid any warning or notice to be thrown in the first place.

Before:

![Screenshot](docs/cake.png)

After:

![Screenshot](docs/whoops.png)

[CakePHP 3]:https://cakephp.org
[Composer]:https://getcomposer.org
[Whoops]:https://filp.github.io/whoops/
