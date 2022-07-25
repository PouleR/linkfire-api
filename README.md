# Linkfire API PHP

This is a PHP wrapper for the Linkfire API.

## Requirements
* PHP >=8.1

## Installation
Install it using [Composer](https://getcomposer.org/):

```sh
composer require pouler/linkfire-api
```

## Example usage
```php
<?php 

declare(strict_types=1);

use PouleR\LinkfireAPI\Entity\CampaignLink;
use PouleR\LinkfireAPI\LinkfireAPI;
use PouleR\LinkfireAPI\LinkfireAPIClient;
use Symfony\Component\HttpClient\CurlHttpClient;

require 'vendor/autoload.php';

$httpClient = new CurlHttpClient();
$apiClient = new LinkfireAPIClient($httpClient);
$linkfireAPI = new LinkfireAPI($apiClient);

$authenticatedToken = $linkfireAPI->authenticate('client-id', 'client-secret');
$linkfireAPI->setAccessToken($authenticatedToken->getAccessToken());

// Retrieve all mediaServices for a given board
$mediaServices = $linkfireAPI->getBoardMediaServices('board-id');

// Create a campaign link
$campaignLink = $api->createCampaignLink('board-id', [
    'title' => 'Readme',
    'baseUrl' => 'https://open.spotify.com/album/your-album-uri',
    'domainId' => 'domain-id',
    'artist' => 'PouleR',
    'album' => 'Readme',
    'mediaType' => 'Music',
    ]);
```
