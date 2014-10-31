php-time-functions
==================

A collection of various time functions written in PHP are available in the src folder. For example, a function which returns working hours for two supplied timestamps.


Grunt tasks
==================

Grunt tasks are included for
- Linting the JS files contained in the Grunt folder using grunt-contrib-jshint
- Linting the PHP files using grunt-phplint
- Code Style checking the JS files in the Grunt folder using grunt-jscs
- Code style checking the PHP files in the src and tests folder using grunt-phpcs
- Generating documentation with PHPDocumentor using grunt-phpdocumentor (results are in the docs folder)
- Unit testing the PHP files using grunt-phpunit

Note that you need to have installed and configured phpdocumentor and phpunit on your machine for the documentation and unit test tasks to work.

In progress
==================

The Getworkinghours and beautifytime files both contain one phpcs warning about putting
the functions in a static class. I dont want to do that as the idea of this library
is to give easy to use functions rather than classes.