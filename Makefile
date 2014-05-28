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

tidy:
	find partials -name "*.html" -print0 | xargs -0 -t -n 1 tidy -qe

clean:
	rm -rf coverage-report-html


jsmin:
	cd js
	java -jar ./../vendor/packagist/closurecompiler-bin/bin/compiler.jar --js ng-books.js --js_output_file ng-books.min.js --create_source_map ng-books.min.map
	java -jar ./../vendor/packagist/closurecompiler-bin/bin/compiler.jar --js ng-spreadsheet.js --js_output_file ng-spreadsheet.min.js --create_source_map ng-spreadsheet.min.map
	cd ..
