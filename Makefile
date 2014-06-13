.PHONY: test

install-composer:
	curl -sS https://getcomposer.org/installer | php

install-deps update-deps:
	php composer.phar update --dev

update-prod-deps update-production-deps:
	php composer.phar update

test:
	./vendor/bin/phpunit

lint-php:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml settings test view

lint-html:
	find partials -name "*.html" -print0 | xargs -0 -t -n 1 tidy -qe

clean:
	rm -rf coverage-report-html

jsmin:
	uglifyjs js/ng-books.js -o js/ng-books.min.js --source-map js/ng-books.min.js.map --prefix relative --lint
	uglifyjs js/ng-register-user.js -o js/ng-register-user.min.js --source-map js/ng-register-user.min.js.map --prefix relative --lint
	uglifyjs js/ng-spreadsheet.js -o js/ng-spreadsheet.min.js --source-map js/ng-spreadsheet.min.js.map --prefix relative --lint
