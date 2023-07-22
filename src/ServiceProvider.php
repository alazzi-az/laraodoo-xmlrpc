<?php

declare(strict_types=1);

namespace Alazzidev\LaraodooXmlrpc;

use AlazziAz\OdooXmlrpc\Contracts\OdooClientContract;
use AlazziAz\OdooXmlrpc\Odoo;
use AlazziAz\OdooXmlrpc\OdooClient;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingDbException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingPasswordException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingUrlException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingUsernameException;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * @internal
 */
final class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OdooClientContract::class, static function (): OdooClientContract {
            $url = config('odoo-xmlrpc.url');
            $suffix = config('odoo-xmlrpc.suffix', 'xmlrpc/2');
            $db = config('odoo-xmlrpc.db');
            $username = config('odoo-xmlrpc.username');
            $password = config('odoo-xmlrpc.password');

            if (empty($url)) {
                throw MissingUrlException::create();
            }

            if (empty($db)) {
                throw MissingDbException::create();
            }

            if (empty($username)) {
                throw MissingUsernameException::create();
            }

            if (empty($password)) {
                throw MissingPasswordException::create();
            }

            return Odoo::client(
                url: $url, suffix: $suffix, db: $db, username: $username, password: $password
            );
        });

        $this->app->alias(OdooClientContract::class, 'laraodoo-xmlrpc');
        $this->app->alias(OdooClientContract::class, OdooClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/odoo-xmlrpc.php' => config_path('odoo-xmlrpc.php'),
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            OdooClient::class,
            OdooClientContract::class,
            'laraodoo-xmlrpc',
        ];
    }
}
