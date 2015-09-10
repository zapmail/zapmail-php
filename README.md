# zapmail-php
Free Email Verification for PHP https://zapmail.io

# Email Verification Library for PHP
ZapMail helps determine the deliverability on an email address by verifying the recipient actually exists, and more.

## Getting Started
To begin, hop over to [zapmail.io](http://zapmail.io) and create a free account. Once you've signed up and logged in, click on **API Settings** and then click **Generate new token**. Take note of the generated API Key - you'll need it for the example below.

## Installation
Make sure you have [composer](https://getcomposer.org) installed.

```bash
& php composer.phar require zapmail/zapmail
```

## Usage

```php
<?php

// Use the autoloader generated by Composer
require_once 'vendor/autoload.php';

$client   = new Zapmail\Client("YOUR_API_TOKEN");
$response = $client->verify("test@example.net");
```

#### Options

**timeout** `integer` (optional) - Maximum time, in milliseconds, for the API to complete a verification request. Default: 6000.