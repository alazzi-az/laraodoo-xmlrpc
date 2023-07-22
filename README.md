# Odoo XML-RPC Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alazzi-az/laraodoo-xmlrpc.svg?style=flat-square)](https://packagist.org/packages/alazzi-az/laraodoo-xmlrpc)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/alazzi-az/laraodoo-xmlrpc/run-tests?label=tests)](https://github.com/alazzi-az/laraodoo-xmlrpc/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/alazzi-az/laraodoo-xmlrpc/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/alazzi-az/laraodoo-xmlrpc/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alazzi-az/laraodoo-xmlrpc.svg?style=flat-square)](https://packagist.org/packages/alazzi-az/laraodoo-xmlrpc)

---
The **Odoo XML-RPC Client** is a PHP package that provides a simple and easy-to-use interface for interacting with the Odoo XML-RPC API. Unlike other Odoo clients that require extensions or other dependencies, this client uses the laminas/laminas-xmlrpc package, which is a pure PHP implementation of the XML-RPC protocol.

## Requirements

- PHP 8.1 or later




## Get Started
First, install laraodoo-xmlrpc via the Composer package manager:
```bash
composer require alazzi-az/laraodoo-xmlrpc
```
Next, publish the configuration file:
```bash
php artisan vendor:publish --provider="Alazzidev\LaraodooXmlrpc\ServiceProvider"
```
This will create a config/odoo-xmlrpc..php configuration file in your project, which you can modify to your needs using environment variables:

```php
return [
    'url' => env('ODOO_URL', ''),
    'suffix' => 'xmlrpc/2',
    'db' => env('ODOO_DB', ''),
    'username' => env('ODOO_USERNAME', ''),
    'password' => env('ODOO_PASSWORD', ''),
];
```
Finally, you may use the Odoo facade to access the Odoo Xml API:
```php
use Alazzidev\LaraodooXmlrpc\Facades\Odoo;

$result = Odoo::model('res.partner')->create([
            'test1'=>'test1-value',
            'test2'=>'test2-value'
            ]);
```

## Usage
For usage examples, take a look at the [alazzi-az/odoo-xmlrpc](https://github.com/alazzi-az/odoo-xmlrpc) repository.
## Use Case
For Create Invoice in Cummonity Version "account.move"
```php
use Alazzidev\LaraodooXmlrpc\Facades\Odoo;

// Define invoice line
$line = [
    0,
    false,
    [
        'currency_id' => $currency_id,
        'discount' => $discountPercentage,
        'display_type' => 'product',
        'name' => $name,
        'price_unit' => $price_unit,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'tax_ids' => $tax_ids,
    ]
];

$invoice_lines = [$line];

// Define invoice data
$invoice = [
    'partner_id' => $partner_id,
    'name' => $name,
    'invoice_date' => $invoice_date,
    'invoice_date_due' => $invoice_date_due,
    'payment_reference' => $payment_reference,
    'invoice_line_ids' => $invoice_lines,
    'currency_id' => $currency_id,
    'invoice_payment_term_id' => $payment_term_id,
    'state' => $state,
    'journal_id' => $journal_id,
    'move_type' => 'out_invoice',
];

// Create invoice using Odoo External API
$odoo = Odoo::model('account.move');
$odoo_invoice_id = $odoo->create($invoice);

```

## Testing
The Odoo facade comes with a fake() method that allows you to fake the API responses.

The fake responses are returned in the order they are provided to the fake() method.

All responses are having a fake() method that allows you to easily create a response object by only providing the parameters relevant for your test case.

```php
use Alazzidev\LaraodooXmlrpc\Facades\Odoo;

  Odoo::fake([
        'test1'=>'test1-value',
        'test2'=>'test2-value'
    ]);

    $response = Odoo::create('res.partner',[
        'test1'=>'test1-value',
        'test2'=>'test2-value'
    ]);

    expect($response['test1'])->toBe('test1-value');
```
And here You Can run test
```bash
composer test:unit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/alazzi-az/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mohammed Ali Azman](https://github.com/alazzi-az)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

