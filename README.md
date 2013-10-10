Symfony tunisia community Website
You will need:

Git 1.6+
PHP 5.3.3+
php5-intl
phpunit 3.6+ (optional)
composer
Installation

To get the website running, first clone the repository:

$ git clone git://github.com/kadala/symfony-tunisia-website.git
$ cd symfony-tunisia-website
Get the code

$ curl -s http://getcomposer.org/installer | php --
$ php composer.phar install
This will fetch the vendors and all it's dependencies.

The next step is to setup the database:

app/console doctrine:database:create
