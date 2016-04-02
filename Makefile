.PHONY: all
all: checksums/css.php

last-install.lock: composer.json package.json Makefile
	npm install --production && \
	composer install --no-dev && \
	mkdir -p public/assets/vendor && \
	rsync -avz node_modules/bootstrap/dist/ public/assets/vendor/bootstrap && \
	rsync -avz node_modules/angular/ public/assets/vendor/angular && \
	rsync -avz node_modules/angular-animate/ public/assets/vendor/angular-animate && \
	rsync -avz node_modules/angular-touch/ public/assets/vendor/angular-touch && \
	rsync -avz node_modules/angular-ui-bootstrap/dist/ public/assets/vendor/angular-ui-bootstrap && \
	touch $@

checksums/without-css.php: last-install.lock bin/checksums.php $(shell find public/assets -type f | egrep -v "\.css$$")
	mkdir -p checksums && \
	find public/assets -type f | egrep -v "\.css$$" | bin/checksums.php $@

last-css.lock: checksums/without-css.php bin/addChecksumsToCss.php $(shell find public/assets -type f -name '*.css')
	find public/assets -type f -name '*.css' | bin/addChecksumsToCss.php && \
	touch $@

checksums/css.php: last-css.lock bin/checksums.php $(shell find public/assets -type f -name '*.css')
	mkdir -p checksums && \
	find public/assets -type f -name '*.css' | bin/checksums.php $@

.PHONY: clean
clean:
	rm -rf last-install.lock \
	last-css.lock \
	public/assets/vendor \
	checksums