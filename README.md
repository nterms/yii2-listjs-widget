yii2-listjs-widget
========================

List.js widget for Yii2. This widget makes List.js functionality available on any list or table in Yii2 applications.
Visit [List.js](http://www.listjs.com/) website for more info and examples.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nterms/yii2-listjs-widget "*"
```

or add

```
"nterms/yii2-listjs-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```php
<?= \nterms\listjs\ListJs::begin([
	'id' => 'days-list',
	'clientOptions' => [
		'valueNames' => ['day'],
	],
]); ?>

<ul class="list">
	<li class="day">Sunday</li>
	<li class="day">Monday</li>
	<li class="day">Tuesday</li>
	<li class="day">Wednesday</li>
	<li class="day">Thursday</li>
	<li class="day">Friday</li>
	<li class="day">Saturday</li>
</ul>

<?= \nterms\listjs\ListJs::end(); ?>
```

Configurations
--------------

Following properties are available for customizing the widget.

- `options`: HTML attributes for the container element
- `clientOptions`: Options for List.js. Read [this](http://www.listjs.com/docs/options) for list of options.
- `content`: HTML content, preferably a list or table. If the widget is used in content capturing mode this will be ignored.
- `view`: name of the view file to render the content. If the widget is used in content capturing mode or a string is assigned to [[content]] property this will be ignored.
- `viewParams`: parameters to be passed to [[view]] when it is being rendered. This property is used only when [[view]] is rendered to generate the content of the widget.

License
-------

[MIT](LICENSE.md)