# LaraText

Developer friendly Laravel package to text using msg91 sms gateway.

## Getting Started

Install the latest version of the package with ```composer require santoshkorukonda/laratext```

### Prerequisites

1. requires ``php >= 5.6.4``
2. requires ``php ext-curl``
3. requires ``monolog/log``

### Installation

Detailed installation and configuration procedure of the package.

Add ``santoshkorukonda/laratext`` package to your ``composer.json`` file

``json
{
    "require": {
        "santoshkorukonda/laratext": "0.1",
    },
}
``

Update **composer** with

```composer update```

Add **LaraTextServiceProvider** to ```config/app.php```

```php
<?php

return [
    ...,
    'providers' => [
        ...,
        SantoshKorukonda\LaraText\LaraTextServiceProvider::class,
        ...,
    ],
    ...,
];
```

Add **LaraTextFacade** to ```config/app.php```

```php
<?php

return [
    ...,
    'aliases' => [
        ...,
        SantoshKorukonda\LaraText\LaraTextFacade::class,
        ...,
    ],
    ...,
];
```

Publish **LaraText configuration** file

```php artisan vendor:publish```


**Note:** Don't confuse with ```...,``` it's just used for visual explanation, in real scenario it can be any text in your ```composer.json``` or ```app.php``` files.

## License

This package is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.