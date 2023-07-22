<?php

declare(strict_types=1);

namespace Alazzidev\LaraodooXmlrpc\Facades;

use AlazziAz\OdooXmlrpc\OdooClient;
use AlazziAz\OdooXmlrpc\QueryBuilder;
use AlazziAz\OdooXmlrpc\Testing\OdooClientFake;
use Illuminate\Support\Facades\Facade;
use Laminas\XmlRpc\Client;

/**
 * @method static array get(string $model, array $filters = [], array $fields = [], int $limit = null, int $offset = null)
 * @method static array|int|null call(array $params)
 * @method static int getUid()
 * @method static array|null read(string $model, array $ids, array $fields = [])
 * @method static array|null search(string $model, array $filters = [])
 * @method static int|array create(string $model, array $data)
 * @method static int|null update(string $model, int|array $ids, array $data)
 * @method static int|null delete(string $model, int|array $ids)
 * @method static int|null count(string $model, array $filters = [])
 * @method static QueryBuilder model(string $model)
 * @method static mixed getVersion()
 * @method static Client getCommonClient()
 * @method static Client getObjectClient()
 *
 * @see OdooClient
 */
final class Odoo extends Facade
{
    /**
     * @param  array<array-key, array|string|int>  $objectResponse
     */
    public static function fake(array|string|int $objectResponse = [], array|string|int $commonResponse = 1): OdooClientFake
    /** @phpstan-ignore-line */
    {
        $fake = new OdooClientFake(fakeObjectResponse: $objectResponse, fakeCommonResponse: $commonResponse);
        self::swap($fake);

        return $fake;
    }

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraodoo-xmlrpc';
    }
}
