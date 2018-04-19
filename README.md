Vedic-Rishi-Astro-API-PHP-Client
================================

This is PHP client to consume Vedic Rishi Astro APIs

Where to get API Key
====================

You can visit https://www.astrologyapi.com/ to get the astrology API key to be used for your websites or
mobile applications.

How to Use
==========

```sh composer require kadircanerergun/astro-api-php-client ```
```php $client = new VedicRishiClient("user_id","api_key");
            $response = $client->getTodaysPrediction("cancer", {timezone}); ```
