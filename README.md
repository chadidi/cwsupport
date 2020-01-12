## Instructions

Instruction on how to setup the project bellow.

```sh
git clone git@github.com:chadidi/cwsupport.git
cd cwsupport
cp .env.example .env
# setup your database and you mail server (maybe mailtrap for development)
composer install
php artisan migrate
php artisan db:seed
# now back-end is ready, you may clone the front-end now
# https://github.com/chadidi/cwsupport-fe
```
