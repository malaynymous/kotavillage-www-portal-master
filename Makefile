COMPOSER_FILES = files/usr/share/kotavillage/composer.json files/usr/share/kotavillage/composer.lock files/usr/share/kotavillage/vendor/
BOWER_FILES = files/usr/share/kotavillage/bower.json
VERSION = $(shell sed -n '/kotavillage-www-portal/s/[^ ]* (//;s/).*//p;q' debian/changelog)

all: bower composer
#files/usr/share/kotavillage/src/includes/constants.php: debian/changelog
	sed -i 's/APPLICATION_VERSION", "[^"]*"/APPLICATION_VERSION", "$(VERSION)"/' files/usr/share/kotavillage/src/includes/constants.php
	chmod 0440 sudo/kotavillage-www-portal

bower:
	mkdir -p ext-libs/bower
	cp $(BOWER_FILES) ext-libs/bower
	cd ext-libs/bower; /usr/local/bin/bower install

composer:
	cd files/usr/share/kotavillage/; /usr/local/bin/composer install
	mkdir -p ext-libs/composer
	cp -r $(COMPOSER_FILES) ext-libs/composer/
	rm -fr files/usr/share/kotavillage/vendor

clean:
	rm -fr ext-libs
