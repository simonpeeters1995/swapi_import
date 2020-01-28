<?php

namespace Swapi\Enrichment\Component\Api\Swapi;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use GuzzleHttp\Client;

class SwapiApiClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public const NAME = 'SwapiApiClient';

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => '']);
    }
}