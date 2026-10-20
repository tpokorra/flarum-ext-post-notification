ssh_url=tim05-flarum@tim05.hostsharing.net:flarum

all: build upload

build:
	cd js && npm run build && cd ..

upload:
	rsync -zvhr --exclude node_modules --exclude .git . ${ssh_url}/vendor/tpokorra/flarum-ext-post-notification
	@echo
	@echo "now clear the cache on the server: php8.4 flarum cache:clear"


