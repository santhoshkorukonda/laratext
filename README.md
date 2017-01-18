# LaraText

Developer friendly Laravel package to text using [msg91](https://msg91.com/) sms gateway.

## Getting Started

Install the latest version of the package with ``composer require santhoshkorukonda/laratext``

### Prerequisites

1. requires ``php >= 5.6.4``
2. requires ``php ext-curl``
3. requires ``monolog/log``

### Installation

Detailed installation and configuration procedure of the package.

Add ``santhoshkorukonda/laratext`` package to your ``composer.json`` file

```json
{
    "require": {
        "santoshkorukonda/laratext": "0.1",
    },
}
```

Update **composer** with

```composer update```

Add **LaraTextServiceProvider** to ``config/app.php``

```php
<?php

return [
    'providers' => [
        SantoshKorukonda\LaraText\LaraTextServiceProvider::class,
    ],
];
```

Add **LaraTextFacade** to ``config/app.php``

```php
<?php

return [
    'aliases' => [
        SantoshKorukonda\LaraText\LaraTextFacade::class,
    ],
];
```

Publish **LaraText configuration** file

``php artisan vendor:publish``

## Quick Start

Sending an SMS is simple and easy. Call ``sms($phone, $message)`` function from anywhere of your application to text the message.

## License

This package is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.