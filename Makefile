.PHONY: install
install: last-install.lock

last-install.lock: composer.json package.json Makefile
	npm install --production && \
	composer install --no-dev && \
	mkdir -p public/assets/ &&  \
	rsync -avz node_modules/bootstrap/dist/ public/assets && \
    cp node_modules/angular/angular.js public/assets/js/ && \
	touch $@;

.PHONY: build
build: last-build.lock install

last-build.lock: checksums
	touch $@

.PHONY: checksums
checksums: checksums/without-css.php checksums/css.php

checksums/without-css.php: $(shell find public/assets -type f | egrep -v "\.css$$")
	mkdir -p checksums
	echo $? | bin/checksums.php $@

checksums/css.php: css
	mkdir -p checksums
	echo $(shell find public/assets -type f -name '*.css') | bin/checksums.php $@

.PHONY: css
css: last-css.lock

last-css.lock: $(shell find public/assets -type f -name '*.css') checksums/without-css.php bin/addChecksumsToCss.php
	echo $(filter-out checksums/without-css.php bin/addChecksumsToCss.php,$^) | bin/addChecksumsToCss.php
	touch $@

.PHONY: clean
clean:
	rm -rf last-install.lock \
	last-build.lock \
	last-css.lock \
	checksums
