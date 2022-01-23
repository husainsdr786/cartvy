# Develop REST API with Lumen and PASSPORT authentication

# Installation

1. Clone this repo

```
git clone https://github.com/husainsdr786/cartvy.git
```

2. Install composer packages

```
cd cartvy
$ composer install
```

3. Create and setup .env file

```
make a copy of .env.example
$ copy .env.example .env
$ php artisan key:generate
put database credentials in .env file
```

4. Migrate and insert records

```
$ php artisan migrate
```

5. Passport install and setup

```
$ php artisan passport:install
Put these keys and values in .env file
PASSPORT_LOGIN_ENDPOINT=
PASSPORT_CLIENT_ID=
PASSPORT_CLIENT_SECRET=
```
