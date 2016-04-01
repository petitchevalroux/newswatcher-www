.PHONY: install
install: last-install.lock

last-install.lock: composer.json package.json Makefile
	npm install --production && \
	composer install --no-dev && \
	mkdir -p public/assets/vendor &&  \
	rsync -avz node_modules/bootstrap/dist/ public/assets/vendor/bootstrap && \
    rsync -avz node_modules/angular/ public/assets/vendor/angular && \
    rsync -avz node_modules/angular-animate/ public/assets/vendor/angular-animate && \
    rsync -avz node_modules/angular-touch/ public/assets/vendor/angular-touch && \
	rsync -avz node_modules/angular-ui-bootstrap/dist/ public/assets/vendor/angular-ui-bootstrap && \
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
	public/assets/vendor \
	checksums
