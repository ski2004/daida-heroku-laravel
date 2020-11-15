[DEMO首頁](https://daidai-laravel.herokuapp.com/)

請事先安裝 [Composer](https://getcomposer.org/)、[Docker](https://www.docker.com/)，並將Composer設置為全域

`git clone https://github.com/ski2004/daida-heroku-laravel.git`

`cd daida-heroku-laravel`

`composer install`

`php artisan key:generate`

`cp .env.example .env` -> 後於.env調整db連線

`docker-compose up -d` ->可於 port 8081看到swagger文件