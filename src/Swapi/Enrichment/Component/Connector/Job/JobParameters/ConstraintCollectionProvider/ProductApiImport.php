<?php

namespace Swapi\Enrichment\Component\Connector\Job\JobParameters\ConstraintCollectionProvider;

use Akeneo\Tool\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ProductApiImport  extends BaseApiImport implements ConstraintCollectionProviderInterface
{
    public function getConstraintCollection()
    {
        return new Collection(
            [
                'fields' => [
                    'realTimeVersioning' => new Type('bool'),
                    'enabledComparison' => new Type('bool'),
                    'is_user_authenticated' => new Type('bool'),
                    'user_to_notify' => [
                    ],
                ],
            ]
        );
    }
}