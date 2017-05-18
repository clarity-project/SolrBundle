<?php


namespace FS\SolrBundle\Doctrine\Hydration;

use Doctrine\Common\Collections\ArrayCollection;
use FS\SolrBundle\Doctrine\Mapper\MetaInformationInterface;
use FS\SolrBundle\Repository\RepositoryInterface;
use FS\SolrBundle\Solr;
use FS\SolrBundle\Doctrine\Hydration\PropertyAccessor\PrivatePropertyAccessor;

/**
 * Class NoDatabaseRelationHydrator
 *
 * @author Vladislav Shishko <vladislav.shishko@infolox.de>
 */
class NoDatabaseRelationHydrator implements HydratorInterface
{
    /**
     * @var Solr
     */
    protected $solr;

    /**
     * RelationHydrator constructor.
     *
     * @param Solr $solr
     */
    public function __construct(Solr $solr)
    {
        $this->solr = $solr;
    }

    /**
     * @param object                   $document
     * @param MetaInformationInterface $metaInformation holds the target entity
     *
     * @return object
     */
    public function hydrate($document, MetaInformationInterface $metaInformation)
    {
        $targetEntity = $document;

        $reflectionClass = new \ReflectionClass($targetEntity);

        $relations = $metaInformation->getRelations();

        foreach ($relations as $relation) {
            /** @var \FS\SolrBundle\Doctrine\Annotation\Relation $relation */
            if ($relation->getType() == 'collection') {

                /** @var RepositoryInterface $repository */
                $repository = $this->solr->getRepository($relation->getTarget());
                
                $children = $repository->findByIds((array) $targetEntity->{'get'. ucfirst($relation->name)}());
                $classProperty = $reflectionClass->getProperty($relation->name);
                $accessor = new PrivatePropertyAccessor($classProperty);

                $accessor->setValue($targetEntity, new ArrayCollection($children));
            }
        }

        return $targetEntity;
    }
}