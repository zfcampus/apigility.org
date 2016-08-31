# apigility.org Makefile
#
# Primary purpose is for updating the site to add releases.
#
# Configurable variables:
# - PHP - PHP executable to use, if not in path
# - AG_VERSION - Apiglity version being released or added to site; required for
#   all but homepage target
#
# Available targets:
# - release - indicate a new Apigility release
# - videos  = update video page wtih latest YouTube video releases
# - all     - currently, synonym for release target

PHP ?= /usr/local/zend/bin/php
AG_VERSION ?= false

BIN = $(CURDIR)/bin

CONFIG_DIST ?= $(CURDIR)/config/autoload/global.php.dist
CONFIG_RELEASE ?= $(CURDIR)/config/autoload/global.php

INSTALL_DIST ?= $(CURDIR)/bin/install.php.dist
INSTALL_RELEASE ?= $(CURDIR)/bin/install.php

.PHONY : all release

all : release

release: update-config

update-config: check-version
	@echo "Updating version to $(AG_VERSION)..."
	- sed s/%VERSION%/$(AG_VERSION)/g $(CONFIG_DIST) > $(CONFIG_RELEASE)
	- sed s/%VERSION%/$(AG_VERSION)/g $(INSTALL_DIST) > $(INSTALL_RELEASE)
	@echo "[DONE] Updating version"

videos:
	@echo "Generating video page..."
ifeq ($(YT_KEY),)
	@echo "Youtube API key not defined, exiting..."
	exit 1
else
	- $(PHP) $(BIN)/youtube.php --key=$(YT_KEY)
	@echo "[DONE] generating video page"
endif

check-version:
ifeq ($(AG_VERSION),false)
	@echo "Missing AG_VERSION assignment on commandline"
	exit 1
endif
