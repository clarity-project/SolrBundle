<?php


namespace FS\SolrBundle\Doctrine\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Relation
 *
 * @author Vladislav Shishko <vladislav.shishko@infolox.de>
 *
 * @Annotation
 */
class Relation extends Annotation
{
    /**
     * single, collection
     *
     * @var string
     */
    public $type;

    /**
     * target class
     *
     * @var string
     */
    public $target;

    /**
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

}