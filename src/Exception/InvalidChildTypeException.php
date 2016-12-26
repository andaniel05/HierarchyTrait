<?php

namespace Andaniel05\HierarchyTrait\Exception;

class InvalidChildTypeException extends HierarchyTraitException
{
    public function __construct($parent, $child)
    {
        parent::__construct(sprintf('El hijo debe ser del mismo tipo que el padre. El tipo del padre es %s, mientras que el del hijo es %s.', $parent, $child));
    }
}