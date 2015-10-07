# Template Engine for PHP

This project aims to deliver an easy to use and free as in freedom fast template engine for php.

@TODO
add link to travis, scrutinizer, openhub etc.

# Why

I wanted to create a lean (in matter of lines of code and number of files) fast and expendable template engine for php.
This project does not aim to shake on the throne of the big template engine available for php. They have different goals, more manpower and different ideas behind.

Personally, I like the [php-text-template](https://github.com/sebastianbergmann/php-text-template) but sebastian has a different approach in mind (writing something to a file). Adding my goals to his project would add more complexity to his library.

Currently, this component tries to solve three problems when dealing with php templates.
[RuntimeContentBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/RuntimeContentBasedTemplate.php) solve the problem to replacing content stored in a string.
[FileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/FileBasedTemplate.php) solves the problem replacing content stored in a file.
[ComplexFileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/ComplexFileBasedTemplate.php) solves the problem replacing complex content stored in a file. This is commonly known as the view in php frameworks.

What is a complex content? Complex content contains decisions like *$isFoo = ($bar === 'foo'); if ($isFoo) { /* ... */ } else { /* display something else */*.
What kind of complex content should I use? Well, it is up to you and the code is pretty flexible. My two cents are, limit yourself to "foreach", "if/else" is one step further to "adding business logic to the template", *switch* is another step into this direction.

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

# Links

* [StringTemplate](https://github.com/nicmart/StringTemplate)

# API

*@TODO
[API](http://www.bazzline.net/efef04b8bf3867f969285f1160d52ee8a719940e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add examples
        * add unassign if needed and useful
        * implement easy way to nest template in template
        * add unit tests
* [3.0.0](https://github.com/bazzline/php_component_template/tree/3.0.0) - upcomming
    * added the *DelimiterInterface*
    * implemented *__invoke* in all templates to speed up usage and rendering
    * implemented *reset*
    * refactored existing templates by introducing *AbstractFileBasedTemplate* and slicing out the delimiter handling
    * renamed *setOpenDelimiter* to *setOpeningDelimiter*
    * renamed *FileTemplate* to *FileBasedTemplate*
    * renamed *StringTemplate* to *RuntimeContentBasedTemplate*
    * renamed *ViewTemplate* to *ComplexFileBasedTemplate*
    * shifted order from *filePath* and *variables* in the constructor of *RuntimeContentBasedTemplate* and *FileBasedContent*
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
