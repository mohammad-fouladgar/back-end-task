## Backend Task

### Requirements
- PHP Version:  8.1.2
- composer Version: 2.2.6

### Setup Project
Please run these below commands:
```shell
composer install

cp .env.example .env

php artisan key:generate
```


### Run Commission Fee Command
After installing and setting up project, you can run this artisan command:
```shell
php artisan commission-fee:calculate input.csv
```
This command has an `csv-file` argument. You can pass your own csv file.

### Testing
```shell
php artisan test
```

