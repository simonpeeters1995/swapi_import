<?php

namespace Swapi\Enrichment\Component\Connector\Reader;

use Akeneo\Tool\Component\Batch\Item\ItemReaderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Swapi\Enrichment\Component\Api\Swapi\SwapiApiClient;
use Swapi\Enrichment\Component\Modifier\SnakeCaseModifier;

class ProductReader implements ItemReaderInterface
{
    private $swapiApiClient;
    private $next_page_starships = 'https://swapi.co/api/starships/?page=1';
    private $next_page_vehicle = 'https://swapi.co/api/vehicles/?page=1';
    private $snakeCaseModifier;
    private $api_data;
    private $type = '';
    private $count = 0;

    public function __construct(SwapiApiClient $swapiApiClient,SnakeCaseModifier $snakeCaseModifier)
    {
        $this->swapiApiClient = $swapiApiClient;
        $this->snakeCaseModifier = $snakeCaseModifier;
    }

    public function read()
    {
        if (null === $this->api_data)
        {
            $product_array = $this->swapiApiClient->getStarships($this->next_page_starships);
            $this->api_data = new ArrayCollection($product_array['results']);
            $this->next_page_starships = $product_array['next'] ?? false;

            $this->type = 'starship';
        }

        if (false === $this->api_data->current() && $this->next_page_starships)
        {
            $product_array = $this->swapiApiClient->getStarships($this->next_page_starships);
            $this->api_data = new ArrayCollection($product_array['results']);
            $this->next_page_starships = $product_array['next'] ?? false;
        }

        if (false === $this->api_data->current() && $this->next_page_starships === false && $this->next_page_vehicle)
        {
            $product_array = $this->swapiApiClient->getStarships($this->next_page_vehicle);
            $this->api_data = new ArrayCollection($product_array['results']);
            $this->next_page_vehicle = $product_array['next'] ?? false;

            $this->type = 'vehicle';
        }

        while ($this->api_data->current())
        {
            $item = $this->api_data->current();
            $this->api_data->next();
            $this->count += 1;

            return $this->convertStructuredData($item,$this->type);

        }
        dump('DONE');
        return null;
    }

    private function convertStructuredData($data, $type)
    {
        dump( $this->count . ' -- ' .$data['name']);

        $identifier = $this->snakeCaseModifier->modify($data['name']);

        $convertedProductArray = [
            'identifier'=>   $identifier,
            'family'    => 'swapi_'. $type,
            'categories'    => [
                0   =>  $this->snakeCaseModifier->modify($data[$type . '_class'])
            ],

            'enabled'   => true,
            'values'    =>  [
                'sku'   => [
                    0 => [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $identifier
                    ]
                ],
                'product_name' => [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['name']
                    ]
                ],
                'product_model'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['model']
                    ]
                ],
                'product_manufacturer' => [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['manufacturer']
                    ]
                ],
                'length'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['length']
                    ]
                ],
                'max_atmosphering_speed' => [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['max_atmosphering_speed']
                    ]
                ],
                'crew'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['crew']
                    ]
                ],
                'passengers' => [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['passengers']
                    ]
                ],
                'cargo_capacity'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['cargo_capacity']
                    ]
                ],
                'consumables'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => $data['consumables']
                    ]
                ],
                'cost_in_credits'   =>  [
                    0   =>  [
                        "locale"    => null,
                        "scope"     => null,
                        "data"      => [
                            0   => [
                                "amount"    => $data['cost_in_credits'],
                                "currency"  => "EUR"
                            ]
                        ],
                     ]
                ],
            ]
        ];

        if($type === 'starship')
        {
            $convertedProductArray['values']['hyperdrive_rating'] = [
                0   =>  [
                    "locale"    => null,
                    "scope"     => null,
                    "data"      => $data['hyperdrive_rating']
                ]
            ];
        }

        return $convertedProductArray;
    }
}