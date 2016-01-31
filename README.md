# Template Engine for PHP

This project aims to deliver an easy to use, free as in freedom and fast template engine for php (code name: yepte - yet another php template engine).

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_template.png?branch=master)](http://travis-ci.org/bazzline/php_component_template)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_template.svg)](https://packagist.org/packages/net_bazzline/php_component_template)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_template/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_template/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/56181f0cb06d5000090013f9/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56181f0cb06d5000090013f9)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_template).

# Why

I wanted to create a lean (in matter of lines of code and number of files) fast, extendable but expendable template engine for php.
This project does not aim to shake on the throne of the big template engine available for php. They have different goals, more manpower and different ideas behind.

Personally, I like the [php-text-template](https://github.com/sebastianbergmann/php-text-template) but sebastian has a different approach in mind (writing something to a file). Adding my goals to his project would add more complexity to his library.

## Available Templates

Currently, this component tries to solve three problems when dealing with php templates.

[RuntimeContentBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/RuntimeContentBasedTemplate.php) solve the problem to replacing content stored in a string.

[FileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/FileBasedTemplate.php) solves the problem replacing content stored in a file.

[ComplexFileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/ComplexFileBasedTemplate.php) solves the problem replacing complex content stored in a file. This is commonly known as the view in php frameworks.

[CallableComplexFileBasedTemplateManager](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/CallableComplexFileBasedTemplateManager.php) solves the problem externalise reusable template tasks. This is commonly known as the view helper pattern.

## Notes

### What is a complex content?

Complex content contains code like:

```php
$isFoo = ($bar === 'foo');
if ($isFoo) {
     /* ... */ 
} else { 
    /*  ... something else */ 
}
```

### What is a callable?

Callable is an other word for the famous view helper design pattern.
The template provides a method called "registerCallable" to register a callable and bind it to a name.

```php
//assuming the file in the relative path 'template.phtml' has the following content
//<?php $this->foobar('foo', 'bar');
$myViewHelper = function($foo, $bar) {
    return 'there is no ' . $foo . ' without a ' . $bar;
}
$template = new CallableComplexFileBasedTemplateManager('template.phtml');
$template->registerCallable('foobar', $myViewHelper);
echo $template->render() . PHP_EOL;
//expected result: there is no foo without a bar
```

### What kind of complex content should I use?

Well, it is up to you and the code is pretty flexible.

My two cents are, limit yourself to *foreach*. *if/else* is one step further to "adding business logic to the template". *switch* is another step into this direction.

# Usage

```php
use Net\Bazzline\Component\Template\RuntimeContentBasedTemplate;

//create a instance
$template = new RuntimeContentBasedTemplate();

//set content
$template->setContent('there is no {one} without a {two}');

//assign variable one by one ...
$template->assignOne('one', 'foo');
//... or by providing an array
$template->assignMany(array('one' => 'foo'));

//you can render it in different ways
//1) explicit calling the method
echo $template->render();
//2) casting it to a string
echo (string) $template;
//3) using it as a function
//  you can also provide all optional parameters like in the constructor
echo $template();
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

[API](http://www.bazzline.net/a9ecef3b441a70ebebc0488a427c61fac06cd3aa/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add examples
        * add download per months icon
        * add refuse/take/resign if needed and useful
        * add unit tests
        * implement caching
    * added [zend-expressive-template](https://github.com/zendframework/zend-expressive-template) as suggested package
    * added *TryToInstallZendExpressiveTemplate* command that installs zend-expressive-template if requirements are met in development mode
    * removed build von php 5.3.3
* [3.1.2](https://github.com/bazzline/php_component_template/tree/3.1.2) - released at 26.01.2016
    * updated dependencies
* [3.1.1](https://github.com/bazzline/php_component_template/tree/3.1.1) - released at 11.12.2015
    * refactored CallableComplexFileBasedTemplateManager::registerCallable()
    * updated dependencies
* [3.1.0](https://github.com/bazzline/php_component_template/tree/3.1.0) - released at 28.10.2015
    * added [CallableComplexFileBasedTemplateManager](https://github.com/bazzline/php_component_template/blob/3.1.0/source/Net/Bazzline/Component/Template/CallableComplexFileBasedTemplateManager.php) which allows registering callable to easy up reusing code and nest templates in templates
    * added "[TemplateDumper](https://github.com/bazzline/php_component_template/blob/3.1.0/source/Net/Bazzline/Component/Template/TemplateDumper.php)" to easy up dumping rendered content to a file
    * easy up reading readme
* [3.0.0](https://github.com/bazzline/php_component_template/tree/3.0.0) - released at 09.10.2015
    * added links to travis, scrutinizer, openhub, versioneye
    * added the *DelimiterInterface*
    * implemented *__invoke* in all templates to speed up usage and rendering
    * implemented *reset*
    * refactored existing templates by introducing *AbstractFileBasedTemplate* and slicing out the delimiter handling
    * renamed *setOpenDelimiter* to *setOpeningDelimiter*
    * renamed *FileTemplate* to *FileBasedTemplate*
    * renamed *StringTemplate* to *RuntimeContentBasedTemplate*
    * renamed *ViewTemplate* to *ComplexFileBasedTemplate*
    * shifted order from *filePath* and *variables* in the constructor of *RuntimeContentBasedTemplate* and *FileBasedContent*
    * started link section
    * updated *ComplexFileBasedTemplate* variable handling by adding "EXTR_SKIP" to the *extract* method
    * updated dependency
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

# Links to other libraries

* [crazedsanity template](https://github.com/crazedsanity/template)
* [latte](https://github.com/nette/latte)
* [mindy template](https://github.com/studio107/Mindy_Template)
* [php-liquid](https://github.com/harrydeluxe/php-liquid)
* [raintpl3](https://github.com/rainphp/raintpl3)
* [rock template](https://github.com/romeOz/rock-template)
* [smarty](https://github.com/smarty-php/smarty)
* [ste](https://github.com/SugiPHP/STE)
* [StringTemplate](https://github.com/nicmart/StringTemplate)
* [twig](https://github.com/memio/twig-template-engine)
* [php-array-view](https://github.com/huytbt/php-array-view)
* [and even more ...](https://packagist.org/search/?search_query%5Bquery%5D=template+engine)

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it :-D.
