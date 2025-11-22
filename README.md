# clone the repo
git clone https://github.com/greeshmaponnappan/shopping_cart.git
cd shopping_cart

# install PHP dependencies
composer install

# create .env
cp .env.example .env
# update DB credentials in .env

# generate app key
php artisan key:generate

# run migrations & seeders
php artisan migrate --seed

# run local server
php artisan serve
# or use Valet / Sail / Docker as preferred
