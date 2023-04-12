#!/usr/bin/make -f

PROCESSORS_NUM := $(shell getconf _NPROCESSORS_ONLN)

.PHONY: all clean clean-all check test coverage

# ---------------------------------------------------------------------

.PHONE: all
all: test

.PHONE: clean
clean:
	rm -rf ./build

.PHONE: clean-all
clean-all: clean
	rm -rf ./vendor
	rm -rf ./composer.lock

.PHONY: check
check:
	php vendor/bin/phpcs --parallel=${PROCESSORS_NUM}

.PHONY: test
test: check
	php vendor/bin/phpunit

.PHONY: coverage
coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi
