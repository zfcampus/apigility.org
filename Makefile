# apigility.org Makefile
#
# Primary purpose is for updating the site to add releases.
#
# Configurable variables:
# - PHP - PHP executable to use, if not in path
# - AG_VERSION - Apiglity version being released or added to site; required for
#   all but homepage target
# - ZS_CLIENT - path to zs-client.phar; set this if it's not on your $PATH
# - VERSION - version string to use for the deployment package; defaults to
#   a date-time-formatted string.
# - APP_ID - application ID on Zend Server to deploy to; has a sane default
# - APP_TARGET - zs-client API target that you have configured for Zend Server;
#   defaults to "apigility"
#
# Available targets:
# - github  - get release changelogs from github
# - release - indicate a new Apigility release; also executes github target
# - package - create a new ZPK
# - package - deploy a ZPK
# - all     - currently, synonym for deploy target

PHP ?= /usr/local/zend/bin/php
AG_VERSION ?= false

BIN = $(CURDIR)/bin

CONFIG_DIST ?= $(CURDIR)/config/autoload/global.php.dist
CONFIG_RELEASE ?= $(CURDIR)/config/autoload/global.php

INSTALL_DIST ?= $(CURDIR)/bin/install.php.dist
INSTALL_RELEASE ?= $(CURDIR)/bin/install.php

APP_ID ?= 10
APP_TARGET ?= apigility
VERSION ?= $(shell date -u +"%Y.%m.%d.%H.%M")
ZS_CLIENT ?= zs-client.phar

.PHONY : all release github package deploy

all : deploy

release: update-config github documentation

update-config: check-version
	@echo "Updating version to $(AG_VERSION)..."
	- sed s/%VERSION%/$(AG_VERSION)/g $(CONFIG_DIST) > $(CONFIG_RELEASE)
	- sed s/%VERSION%/$(AG_VERSION)/g $(INSTALL_DIST) > $(INSTALL_RELEASE)
	@echo "[DONE] Updating version"

github:
	@echo "Updating release changelogs..."
	- $(PHP) $(BIN)/get-releases.php
	@echo "[DONE] Updating release changelogs"

composer:
	@echo "Updating composer.phar"
	- $(PHP) composer.phar self-update
	@echo "[DONE] Updating composer.phar"

documentation: composer
	@echo "Updating documentation..."
	- $(PHP) composer.phar update zfcampus/apigility-documentation
	@echo "[DONE] Updating documentation"

videos:
	@echo "Generating video page..."
ifeq ($(YT_KEY),)
	@echo "Youtube API key not defined, exiting..."
	exit 1
else
	- $(PHP) $(BIN)/youtube.php --key=$(YT_KEY)
	@echo "[DONE] generating video page"
endif


package: release
	@echo "Creating ZPK..."
	-$(CURDIR)/vendor/bin/zfdeploy.php build apigility-$(VERSION).zpk --zpkdata zpk --version $(VERSION)
	@echo "[DONE] Creating ZPK"

apigility-$(VERSION).zpk: package

deploy: apigility-$(VERSION).zpk
	@echo "Deploying ZPK..."
	-$(ZS_CLIENT) applicationUpdate --appPackage=apigility-$(VERSION).zpk --appId=$(APP_ID) --target=$(APP_TARGET)
	@echo "[DONE] Deploying ZPK"

check-version:
ifeq ($(AG_VERSION),false)
	@echo "Missing AG_VERSION assignment on commandline"
	exit 1
endif
