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
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml app test

ctags:
	ctags --languages=PHP --exclude=vendor --exclude=.git --exclude=composer.phar -R -f .tags

clean:
	rm -rf coverage-report-html
