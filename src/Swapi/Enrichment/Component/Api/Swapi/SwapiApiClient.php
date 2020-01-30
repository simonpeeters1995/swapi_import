<?php

namespace Swapi\Enrichment\Component\Api\Swapi;

use GuzzleHttp\Exception\GuzzleException;
use mysql_xdevapi\Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use GuzzleHttp\Client;
use Swapi\Enrichment\Component\Api\Swapi\Exception\SwapiApiClientException;

class SwapiApiClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public const NAME = 'SwapiApiClient';
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://swapi.co/api']);
    }

    public function getStarships($url)
    {
        try {
            $response = $this->client->request(
                'GET',
                $url,
                [
                    'debug' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ]
                ]
            );

            $this->logger->info($this->getMessage('get all starships from swapi api!'));
            return json_decode($response->getBody()->getContents(),true);

        } catch (GuzzleException $x)
        {
            $this->logger->critical($this->getMessage($x->getMessage()));
        }
    }

    public function getVehicles($url)
    {
        try {
            $response = $this->client->request(
                'GET',
                $url,
                [
                    'debug' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ]
                ]
            );

            $this->logger->info($this->getMessage('get all vehicles from swapi api!'));
            return json_decode($response->getBody()->getContents(),true);

        } catch (GuzzleException $x)
        {
            $this->logger->critical($this->getMessage($x->getMessage()));
        }
    }

    public function getMessage(string $message):string
    {
        return static::NAME . ':' .  $message;
    }
}