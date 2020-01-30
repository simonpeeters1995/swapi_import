<?php

namespace Swapi\Enrichment\Component\Connector\Reader;

use Akeneo\Tool\Component\Batch\Item\ItemReaderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Swapi\Enrichment\Component\Api\Swapi\SwapiApiClient;

class ProductReader implements ItemReaderInterface
{
    private $swapiApiClient;

    public function __construct(SwapiApiClient $swapiApiClient)
    {
        $this->swapiApiClient = $swapiApiClient;
    }

    public function read()
    {
        die('zit in de product reader');
        // TODO: Implement read() method.
    }
}