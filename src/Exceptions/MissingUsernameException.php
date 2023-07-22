<?php

declare(strict_types=1);

namespace Alazzidev\LaraodooXmlrpc\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
class MissingUsernameException extends InvalidArgumentException
{
    public static function create(): self
    {
        return new self('The Odoo XML-RPC username is missing. Please publish the [odoo-xmlrpc.php] configuration file and set the [username].');
    }
}
