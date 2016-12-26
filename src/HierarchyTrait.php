<?php

namespace Andaniel05\HierarchyTrait;

use Andaniel05\HierarchyTrait\Exception\InvalidParentTypeException;
use Andaniel05\HierarchyTrait\Exception\InvalidChildTypeException;

/**
 * Añade funcionalidad jerárquica a clases.
 *
 * @author Andy D. Navarro Taño <andaniel05@gmail.com>
 * @version 1.0.0
 */
trait HierarchyTrait
{
    /**
     * @var object
     */
    protected $parent;

    /**
     * @var array
     */
    protected $children = [];

    /**
     * @see HierarchyInterface::getId()
     */
    abstract public function getId();

    /**
     * @see HierarchyInterface::setParent()
     */
    public function setParent($parent, $registerChildInParent = true, $unregisterFromOld = true)
    {
        if (null !== $parent && __CLASS__ != get_class($parent)) {
            throw new InvalidParentTypeException(get_class($parent), __CLASS__);
        }

        if (true === $unregisterFromOld && null !== $this->parent) {
            $this->parent->removeChild($this->getId());
        }

        $this->parent = $parent;

        if (true === $registerChildInParent) {
            $this->parent->addChild($this);
        }
    }

    /**
     * @see HierarchyInterface::getParent()
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @see HierarchyInterface::getChildren()
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @see HierarchyInterface::addChild()
     */
    public function addChild($child, $registerParentInChild = true)
    {
        if (__CLASS__ != get_class($child)) {
            throw new InvalidChildTypeException(__CLASS__, get_class($child));
        }

        $this->children[$child->getId()] = $child;

        if (true === $registerParentInChild) {
            $child->setParent($this, false, false);
        }
    }

    /**
     * @see HierarchyInterface::getChild()
     */
    public function getChild($id)
    {
        return (true === isset($this->children[$id])) ? $this->children[$id] : null;
    }

    /**
     * @see HierarchyInterface::removeChild()
     */
    public function removeChild($id, $unregisterParent = true)
    {
        if (true === isset($this->children[$id])) {

            $child = $this->children[$id];

            if (true === $unregisterParent) {
                $child->setParent(null, false, false);
            }

            unset($this->children[$id]);
        }
    }
}