Pages, layouts adn stuff for Yii 2
=====
Provide:
* pages
* text blocks

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist webvimark/module-content "*"
```

or add

```
"webvimark/module-content": "*"
```

to the require section of your `composer.json` file.

Configuration
-------------

In your config/web.php

```php
	'urlManager'   => [
		'rules'=>[

			[
				'class' => 'webvimark\modules\content\components\PageUrlRule',
				'pattern'=>'',
				'route'=>'',
				'connectionID' => 'db',
			],

			'<_c:[\w \-]+>/<id:\d+>'=>'<_c>/view',
			'<_c:[\w \-]+>/<_a:[\w \-]+>/<id:\d+>'=>'<_c>/<_a>',
			'<_c:[\w \-]+>/<_a:[\w \-]+>'=>'<_c>/<_a>',

			'<_m:[\w \-]+>/<_c:[\w \-]+>/<_a:[\w \-]+>'=>'<_m>/<_c>/<_a>',
			'<_m:[\w \-]+>/<_c:[\w \-]+>/<_a:[\w \-]+>/<id:\d+>'=>'<_m>/<_c>/<_a>',

		],
	],


	'modules'=>[
		'content' => [
			'class' => 'webvimark\modules\content\ContentModule',
		],
	],

```

Usage
-----

Go to gii
