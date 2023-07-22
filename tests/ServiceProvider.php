<?php

use AlazziAz\OdooXmlrpc\Contracts\OdooClientContract;
use AlazziAz\OdooXmlrpc\OdooClient;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingDbException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingPasswordException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingUrlException;
use Alazzidev\LaraodooXmlrpc\Exceptions\MissingUsernameException;
use Alazzidev\LaraodooXmlrpc\ServiceProvider;
use Illuminate\Config\Repository;

it('binds the client on the container', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'db' => 'foo',
            'username' => 'foo',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();

    expect($app->get(OdooClient::class))->toBeInstanceOf(OdooClient::class);
});

it('binds the client on the container as singleton', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'db' => 'foo',
            'username' => 'foo',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();

    $client = $app->get(OdooClient::class);

    expect($app->get(OdooClient::class))->toBe($client);
});

it('requires an url key', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => '',
            'db' => 'foo',
            'username' => 'foo',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();
})->throws(
    MissingUrlException::class,
    'The Odoo XML-RPC URL is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [url].',
);

it('requires an db key', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'db' => '',
            'username' => 'foo',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();
})->throws(
    MissingDbException::class,
    'The Odoo XML-RPC database name is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [db].',
);

it('requires an username key', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'db' => 'foo',
            'username' => '',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();
})->throws(
    MissingUsernameException::class,
    'The Odoo XML-RPC username is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [username].',
);

it('requires an password key', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'db' => 'foo',
            'username' => 'foo',
            'password' => '',
        ],
    ]));

    (new ServiceProvider($app))->register();
})->throws(
    MissingPasswordException::class,
    'The Odoo XML-RPC password is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [password].',
);

it('provides', function () {
    $app = app();

    $provides = (new ServiceProvider($app))->provides();

    expect($provides)->toBe([
        OdooClient::class,
        OdooClientContract::class,
        'laraodoo-xmlrpc',
    ]);
});
