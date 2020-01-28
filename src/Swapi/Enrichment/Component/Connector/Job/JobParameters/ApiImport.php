<?php

namespace Swapi\Enrichment\Component\Connector\Job\JobParameters;

use Akeneo\Tool\Component\Batch\Job\JobInterface;
use Akeneo\Tool\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Akeneo\Tool\Component\Batch\Job\JobParameters\DefaultValuesProviderInterface;
use Symfony\Component\Validator\Constraints\Collection;

class ApiImport implements
    ConstraintCollectionProviderInterface,
    DefaultValuesProviderInterface
{
    private $baseDefaultValuesProvider;

    private $baseConstraintCollectionProvider;

    private $supportedJobNames;

    public function __construct(
        DefaultValuesProviderInterface $baseDefaultValuesProvider,
        ConstraintCollectionProviderInterface $baseConstraintCollectionProvider,
        array $supportedJobNames
    ) {
        $this->baseDefaultValuesProvider = $baseDefaultValuesProvider;
        $this->baseConstraintCollectionProvider = $baseConstraintCollectionProvider;
        $this->supportedJobNames = $supportedJobNames;
    }

    public function getDefaultValues()
    {
        return array_merge(
            $this->baseDefaultValuesProvider->getDefaultValues()
        );
    }

    public function getConstraintCollection()
    {
        $baseConstraints = $this->baseConstraintCollectionProvider->getConstraintCollection();
        $constraintFields = array_merge(
            $baseConstraints->fields
        );

        return new Collection(['fields' => $constraintFields]);
    }

    public function supports(JobInterface $job)
    {
        return in_array($job->getName(), $this->supportedJobNames);
    }
}