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

	'layout'=>'@vendor/webvimark/module-content/views/layouts/defaultMain',

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
			'freeAccess' => true, // Feature for webvimark/module-user-management. Default is false

			/*
			'left3ColumnCssClass'           => 'col-xs-15',
			'center3ColumnCssClass'         => 'col-xs-30',
			'right3ColumnCssClass'          => 'col-xs-15',

			'left2ColumnCssClass'           => 'col-xs-15',
			'centerForLeft2ColumnCssClass'  => 'col-xs-45',

			'right2ColumnCssClass'          => 'col-xs-15',
			'centerForRight2ColumnCssClass' => 'col-xs-45',
			*/
		],
	],

```

Usage
-----

Go to gii
