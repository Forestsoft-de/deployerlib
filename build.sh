#!/bin/bash

php7.1 /usr/local/bin/composer update

cd $WORKSPACE/tests
chmod 755 $WORKSPACE/vendor/bin/phpunit && php7.1 $WORKSPACE/vendor/phpunit/phpunit/phpunit -c $WORKSPACE/tests/unit/phpunit.xml

chmod 755 $WORKSPACE/vendor/bin/phpspec && php7.1 $WORKSPACE/vendor/bin/phpspec run -c $WORKSPACE/tests/phpspec.yml --format pretty