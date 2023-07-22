<?php

use Alazzidev\LaraodooXmlrpc\Facades\Odoo;
use Alazzidev\LaraodooXmlrpc\ServiceProvider;
use Illuminate\Config\Repository;
use Laminas\XmlRpc\Client;

it('resolves resources', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'odoo-xmlrpc' => [
            'url' => 'http://foo',
            'suffix' => 'xmlrpc/2',
            'db' => 'foo',
            'username' => 'foo',
            'password' => 'foo',
        ],
    ]));

    (new ServiceProvider($app))->register();

    Odoo::setFacadeApplication($app);

    $completions = Odoo::getObjectClient();

    expect($completions)->toBeInstanceOf(Client::class);
});

test('fake returns the given response', function () {
    Odoo::fake([
        'test1' => 'test1-value',
        'test2' => 'test2-value',
    ]);

    $response = Odoo::create('res.partner', [
        'test1' => 'test1-value',
        'test2' => 'test2-value',
    ]);

    expect($response['test1'])->toBe('test1-value');
});
