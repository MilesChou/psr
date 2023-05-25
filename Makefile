#!/usr/bin/make -f

PROCESSORS_NUM := $(shell getconf _NPROCESSORS_ONLN)

# --------------------------------------------------------------------

.PHONE: all
all: phpcs test

.PHONE: clean
clean:
	rm -rf ./build

.PHONE: clean-all
clean-all: clean
	rm -rf ./vendor
	rm -rf ./composer.lock

.PHONY: phpcs
phpcs:
	php vendor/bin/phpcs --parallel=${PROCESSORS_NUM}

.PHONY: test
test:
	php vendor/bin/phpunit

.PHONY: coverage
coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi
