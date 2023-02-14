<p align="center">
<picture width="500">
  <source width="500" media="(prefers-color-scheme: dark)" srcset="/public/img/dash-color-darkmode.svg">
  <img width="500" alt="Hubble logo" src="/public/img/dash-color.svg">
</picture>
</p>

# Dash Starter

### Laravel dashboard template

## Deployment

Clone the repository

```
git clone https://github.com/leventdev/dash-starter.git
```

Go into the cloned repository

```
cd dash-starter
```

Install composer dependancies

```
composer install
```

Install npm dependancies

```
npm install
```

Make an environment configuration based on the example and set it up

```
cp .env.example .env
nano .env
```

Set the app key

```
php artisan key:generate
```

Set up the tables

```
php artisan migrate
```

Set up permissions for the app

```
sudo chown -R www-data:www-data /root/to/dash
```

Set up the web server of your choice

And finish off by building the app

```
npm run prod
```

Add command to crontab  
Replace /var/www/dash to Dash's location

```
* * * * * cd /var/www/dash && php artisan schedule:run

```

# Redis and Horizon configuration

1. Install the Predis package

```
composer require predis/predis

```

2. Always set QUEUE_CONNECTION to redis in the .env file

```
QUEUE_CONNECTION=redis

```

3. Start the Horizon dashboard and queue by running the following command (instead of php artisan queue:work)

```
php artisan horizon

```

4. You should add your email to access Horizon dashboard in gate inside HorizonServiceProvider.php file

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

4. That's it! You should now be able to access the Horizon dashboard at http://your-app-url/horizon.
