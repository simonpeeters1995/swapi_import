<?php

namespace Swapi\Enrichment\Component\Connector\Reader;

use Akeneo\Tool\Component\Batch\Item\ItemReaderInterface;
use Akeneo\Pim\Enrichment\Component\Category\Connector\ArrayConverter\FlatToStandard\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Swapi\Enrichment\Component\Api\Swapi\SwapiApiClient;

class CategoryReader implements ItemReaderInterface
{
    public function read()
    {
        // TODO: Implement read() method.
    }
}