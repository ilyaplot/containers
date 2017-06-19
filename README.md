# Containers extensions

[![GitHub tag](https://img.shields.io/github/tag/ilyaplot/containers.svg)](https://github.com/ilyaplot/containers)
[![Packagist](https://img.shields.io/packagist/dt/ilyaplot/yii2-key-helper.svg)](https://packagist.org/packages/ilyaplot/containers)
[![Packagist](https://img.shields.io/packagist/l/ilyaplot/yii2-key-helper.svg)](https://packagist.org/packages/ilyaplot/containers)
[![GitHub issues](https://img.shields.io/github/issues/ilyaplot/yii2-key-helper.svg)](https://github.com/ilyaplot/containers/issues)


Installation 
------------------------------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Just run

```
php composer.phar require --prefer-dist ilyaplot/containers
```
or add

```
"ilyaplot/containers": "*"
```
to the require section of your `composer.json` file.


Usage Container exaple:
-------------

```php
$container = new \ilyaplot\Container(['value' => 100]);
$container->value1 = 200;

echo $container->value; // 100
echo $container->value1; // 200
echo $container['value1']; // 200

foreach ($container as $key=>$value) {
  echo $key . ':' . $value; // value:100 and value1:200
}

echo count($container); // 2

echo (string) $container; // {"value":100, "value2":200}

```

Usage Config exaple:
-------------

File: config.php:

```php
<?php 
  return ['hostname' => '127.0.0.1', 'username' => 'guest'];
```

Usage: 
```php

// Example config.php:

$config = new \ilyaplot\Config('config.php', ['password' => 'qwe123', 'username' => 'admin']);

echo $config->hostname; // 127.0.0.1
echo $config->password; // qwe123
echo $config->username; // guest

echo count($config); // 3


$config = new \ilyaplot\Config('config.php', [], ['required_param']);

// throws ContainerException with message: Required param(s) "required_param" has not been set.
```
