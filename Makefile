.PHONY: test

install-composer:
	curl -s https://getcomposer.org/installer | php

install-dev-deps:
	php composer.phar install --dev

update-dev-deps:
	php composer.phar update --dev

install-production-deps:
	php composer.phar install

update-production-deps:
	php composer.phar update

test:
	./vendor/bin/phpunit --stderr --configuration=test/phpunit.xml

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml class test

clean:
	rm -rf coverage-report-html
