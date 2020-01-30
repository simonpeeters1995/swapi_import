<?php

namespace Swapi\Enrichment\Component\Connector\Reader;

use Akeneo\Tool\Component\Batch\Item\ItemReaderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Swapi\Enrichment\Component\Api\Swapi\SwapiApiClient;
use Swapi\Enrichment\Component\Modifier\SnakeCaseModifier;

class CategoryReader implements ItemReaderInterface
{
    private $swapiApiClient;
    private $api_data;
    private $next_page_starship = 'https://swapi.co/api/starships?page=1';
    private $next_page_vehicle = 'https://swapi.co/api/vehicles?page=1';
    private $type;
    private $snakeCaseModifier;
    private $count=0;

    public function __construct(SwapiApiClient $swapiApiClient, SnakeCaseModifier $snakeCaseModifier)
    {
        $this->swapiApiClient = $swapiApiClient;
        $this->snakeCaseModifier = $snakeCaseModifier;
    }

    public function read()
    {
        if(null == $this->api_data)
        {
            $category_array = $this->swapiApiClient->getStarships($this->next_page_starship);

            $this->api_data = new ArrayCollection($category_array['results']);
            $this->next_page_starship = $category_array['next'] ?? false;

            $this->type = 'starship';
        }

        if(false === $this->api_data->current() && $this->next_page_starship)
        {
            $category_array = $this->swapiApiClient->getStarships($this->next_page_starship);

            $this->api_data = new ArrayCollection($category_array['results']);
            $this->next_page_starship = $category_array['next'] ?? false;
        }

        if(false === $this->api_data->current() && $this->next_page_starship === false
            && $this->next_page_vehicle)
        {
            $category_array = $this->swapiApiClient->getVehicles($this->next_page_vehicle);

            $this->api_data = new ArrayCollection($category_array['results']);
            $this->next_page_vehicle = $category_array['next'] ?? false;

            $this->type = 'vehicle';
        }

        while ($this->api_data->current())
        {

            $item = $this->api_data->current();

            $this->api_data->next();
            $this->count +=1;

            return $this->convertStructuredData($item[$this->type.'_class']);
        }
        return null;

    }

    private function convertStructuredData(string $value)
    {
        dump( $this->count . ' -- ' .$value);
        return [
            'code' => (string) $this->snakeCaseModifier->modify($value),
            'parent' => 'star_wars',
            'labels' => [
                'en_US' => (string) $value,
            ]
        ];
    }
}