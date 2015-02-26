# Usher
### A Doctrine ACL package for Laravel 5

* Login with Doctrine User entity
* User roles
* User banning
* User suspending
* User permissions
* User last login and last attempt event listeners
* Role permissions

## Installation

Include the service provider in `config/app.php`
```php
'Maatwebsite\Usher\UsherServiceProvider'
```

## Config

To change the defaults of this package, publish the config:
```php
php artisan vendor:publish --provider="Maatwebsite\Usher\UsherServiceProvider"
```
