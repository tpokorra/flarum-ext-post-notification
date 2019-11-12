ssh_url=tim00-timotheus@pokorra.de:testflarum

all: build upload

build:
	cd js && npm run build && cd ..

upload:
	rsync -zvhr --exclude node_modules --exclude .git . ${ssh_url}/vendor/tpokorra/flarum-ext-post-notification
	@echo
	@echo "now clear the cache on the server: php7.2 flarum cache:clear"


