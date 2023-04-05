# 1.0 clone Project with PHP Version 8.2

## Prerequisites
### Before you begin, you must have the following installed on your system:

##### Git 
##### PHP 
##### Composer
##### Redis
##### MySQL


## Clone the Project by running the following command:

```
git clone https://github.com/<username>/<project-name>.git
```

## if you'r PHP version is 8.2 update php-gd package by running the following command:

```
sudo apt-get install php-gd
```

## Install the project dependencies by running the following command:

```
composer install
```
## Create a copy of the .env.example file and rename it to .env by running the following command:

```
cp .env.example .env
```

## Generate a new Laravel application key by running the following command:

```
php artisan key:generate
```

## Update .env Credentials

## Migrate and Seed DB by running the following command:

```
php artisan migrate --seed
```

## Run Octane Server by running the following command:

```
php artisan octane:start --watch
```

## Run Horizon dashboard for queues by running the following command:

```
php artisan horizon
```

## Run Vite by running the following command:

```
npm run dev
```




# 2.0 Redis and Horizon configuration

## Install the Predis package

```
composer require predis/predis
```

## Always set QUEUE_CONNECTION to redis in the .env file

```
QUEUE_CONNECTION=redis
```

## Start the Horizon dashboard and queue by running the following command (instead of php artisan queue:work)

```
php artisan horizon
```

## You should add your email to access Horizon dashboard in gate inside HorizonServiceProvider.php file

```
 protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                'ADD YOUR EMAIL HERE'
            ]);
        });
    }
```

### That's it! You should now be able to access the Horizon dashboard at http://your-app-url/horizon.
