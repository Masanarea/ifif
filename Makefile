format:
	npm run prettier -- app/* --write
	npm run prettier -- config/* --write
	npm run prettier -- database/* --write
	npm run prettier -- resources/* --write
	npm run prettier -- routes/* --write
	npm run prettier -- tests/* --write

clear config cashe:
	php artisan config:clear
