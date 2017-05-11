<?php

namespace FS\SolrBundle\Doctrine\Hydration;
use FS\SolrBundle\Doctrine\Mapper\MetaInformationInterface;

/**
 * Used when the index is not based on/in sync with a Database.
 */
class NoDatabaseValueHydrator extends ValueHydrator
{
    /**
     * @var HydratorInterface
     */
    protected $relationHydrator;

    /**
     * NoDatabaseValueHydrator constructor.
     *
     * @param HydratorInterface $hudrator
     *
     */
    public function __construct(HydratorInterface $hudrator)
    {
        $this->relationHydrator = $hudrator;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($document, MetaInformationInterface $metaInformation)
    {
        $targetEntity = parent::hydrate($document, $metaInformation);

        return $metaInformation->getRelations()
            ? $this->relationHydrator->hydrate($targetEntity, $metaInformation)
            : $targetEntity ;
    }

    /**
     * Let the original values from the index untouched.
     *
     * {@inheritdoc}
     */
    public function removePrefixedKeyValues($property)
    {
        return $property;
    }

}