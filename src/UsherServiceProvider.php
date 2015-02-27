<?php namespace Maatwebsite\Usher;

use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Usher\Infrastructure\Roles\DoctrineRoleRepository;
use Maatwebsite\Usher\Infrastructure\Users\DoctrineUserRepository;
use Maatwebsite\Usher\Providers\UsherUserProvider;

/**
 * @property  listenForEvents
 */
class UsherServiceProvider extends ServiceProvider
{

    /**
     * Boot Service Provider
     */
    public function boot()
    {
        $this->registerPackageConfig();
        $this->listenForEvents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindUserEntity();
        $this->bindRepositories();
        $this->extendAuthManager();
    }

    /**
     * Extend the auth manager, so the Doctrine
     * User entity can be used as default
     */
    protected function extendAuthManager()
    {
        // Set Usher as default auth drive
        $this->app['config']->set('auth.driver', 'usher');

        // Extend the auth manager
        $this->app['Illuminate\Auth\AuthManager']->extend('usher', function ($app) {
            return new UsherUserProvider(
                $app['Illuminate\Contracts\Hashing\Hasher'],
                $app['Maatwebsite\Usher\Contracts\Users\UserRepository'],
                $app['config']['usher.users.entity']
            );
        });
    }

    /**
     * Listen for auth events
     */
    protected function listenForEvents()
    {
        foreach (config('usher.events', array()) as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->app['events']->listen($event, $listener);
            }
        }
    }

    /**
     * Bind repository implementations
     */
    protected function bindRepositories()
    {
        $this->app->bind('Maatwebsite\Usher\Contracts\Users\UserRepository', function ($app) {
            return new DoctrineUserRepository(
                $app['Doctrine\ORM\EntityManagerInterface'],
                new ClassMetadata(
                    $app['config']['usher.users.entity']
                )
            );
        });

        $this->app->bind('Maatwebsite\Usher\Contracts\Roles\RoleRepository', function ($app) {
            return new DoctrineRoleRepository(
                $app['Doctrine\ORM\EntityManagerInterface'],
                new ClassMetadata(
                    $app['config']['usher.roles.entity']
                )
            );
        });
    }

    /**
     * Bind the user interface to concrete implementation
     */
    protected function bindUserEntity()
    {
        $this->app->bind(
            'Maatwebsite\Usher\Contracts\Users\User',
            $this->app['config']['usher.users.entity']
        );

        $this->app->bind(
            'Maatwebsite\Usher\Contracts\Roles\Role',
            $this->app['config']['usher.roles.entity']
        );
    }

    /**
     * Register package config
     */
    protected function registerPackageConfig()
    {
        $path = __DIR__ . '/../config/usher.php';

        $this->publishes([
            $path => config_path('usher.php'),
        ]);

        $this->mergeConfigFrom(
            $path, 'usher'
        );
    }
}
