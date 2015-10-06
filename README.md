# Template Engine for PHP

This project aims to deliver an easy to use and free as in freedom template engine for php.

@TODO
add link to travis, scrutinizer, openhub etc.

# Usage

```php
$template = new Template('path/to/the/template/file');
$template->assignOne($key, $value);
//...
$template->render();
//or
(string) $template;
```

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_template
cd vendor/net_bazzline/php_component_template
git clone https://github.com/bazzline/php_component_template .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_template)

```
    composer require net_bazzline/php_component_template:dev-master
```

# API

*@TODO
[API](http://www.bazzline.net/efef04b8bf3867f969285f1160d52ee8a719940e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add unassign if needed and useful
        * implement easy way to nest template in template
        * add unit tests
        * refactor AbstractTemplate and ViewTemplate since the ViewTemplate does not need the delimiters
* [2.1.0](https://github.com/bazzline/php_component_template/tree/2.1.0) - released at 06.10.2015
    * added *throws RuntimeException* to *__toString()* method description
    * added *ViewTemplate*
    * add *isAssigned*
* [2.0.0](https://github.com/bazzline/php_component_template/tree/2.0.0) - released at 02.10.2015
    * added *TemplateInterface*
    * decoupled file based template from generic template
        * renamed class *Template* to *AbstractTemplate*
        * introduced *FileTemplate* and *StringTemplate*
* [1.1.0](https://github.com/bazzline/php_component_template/tree/1.1.0) - released at 01.10.2015
    * fixed major bug in "assignOne" (now it is working as expected)
* [1.0.0](https://github.com/bazzline/php_component_template/tree/1.0.0) - released at 01.10.2015
    * initial release 
