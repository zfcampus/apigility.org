# apigility.org Makefile
#
# Primary purpose is for updating the site to add releases.
#
# Configurable variables:
# - PHP - PHP executable to use, if not in path
# - VERSION - version being released or added to site; required for all but
#   homepage target
#
# Available targets:
# - github  - get release changelogs from github
# - release - indicate a new Apigility release; also executes github target
# - all     - currently, synonym for release target

VERSION ?= false
PHP ?= /usr/local/zend/bin/php

BIN = $(CURDIR)/bin

CONFIG_DIST ?= $(CURDIR)/config/autoload/global.php.dist
CONFIG_RELEASE ?= $(CURDIR)/config/autoload/global.php

INSTALL_DIST ?= $(CURDIR)/bin/install.php.dist
INSTALL_RELEASE ?= $(CURDIR)/bin/install.php

.PHONY : all release github

all : release

release: update-config github

update-config: check-version
	@echo "Updating version to $(VERSION)..."
	- sed s/%VERSION%/$(VERSION)/g $(CONFIG_DIST) > $(CONFIG_RELEASE)
	- sed s/%VERSION%/$(VERSION)/g $(INSTALL_DIST) > $(INSTALL_RELEASE)
	@echo "[DONE] Updating version"

github:
	@echo "Updating release changelogs..."
	- $(PHP) $(BIN)/get-releases.php
	@echo "[DONE] Updating release changelogs"

check-version:
ifeq ($(VERSION),false)
	@echo "Missing VERSION assignment on commandline"
	exit 1
endif
