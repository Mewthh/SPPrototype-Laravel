# for codespace

## install
composer install
npm install

## environment
cp .env.example .env

## run
php artisan serve --host=0.0.0.0 --port=8000
npm run dev -- --host 0.0.0.0

## additional
npm install
npm run build
php artisan optimize:clear
php artisan serve --host=0.0.0.0 --port=8000

APP_URL=https://ominous-winner-7v9w69xvr67g2p6vx-8000.app.github.dev/
ASSET_URL=https://ominous-winner-7v9w69xvr67g2p6vx-8000.app.github.dev

vite: true instead of laravel url
