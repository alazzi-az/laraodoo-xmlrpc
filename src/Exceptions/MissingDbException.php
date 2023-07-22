<?php

declare(strict_types=1);

namespace Alazzidev\LaraodooXmlrpc\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
class MissingDbException extends InvalidArgumentException
{
    public static function create(): self
    {
        return new self('The Odoo XML-RPC database name is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [db].');
    }
}
