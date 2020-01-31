<?php

namespace Swapi\Enrichment\Component\Connector\Job\JobParameters\DefaultValueProvider;

use Akeneo\Tool\Component\Batch\Job\JobParameters\DefaultValuesProviderInterface;

class ProductApiImport extends BaseApiImport implements DefaultValuesProviderInterface
{
    public function getDefaultValues()
    {
        $parameters['realTimeVersioning'] = true;
        $parameters['enabledComparison'] = true;
        $parameters['user_to_notify'] = null;
        $parameters['is_user_authenticated'] = null;

        return $parameters;
    }
}