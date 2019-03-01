#!/bin/bash

php7.1 /usr/bin/composer update

cd $WORKSPACE/tests

php7.1 $WORKSPACE/vendor/phpunit/phpunit/phpunit -c $WORKSPACE/tests/unit/phpunit.xml
php7.1 $WORKSPACE/vendor/bin/phpspec run -c $WORKSPACE/tests/phpspec.yml --format pretty