<?php

namespace Andaniel05\HierarchyTrait\Exception;

class InvalidParentTypeException extends HierarchyTraitException
{
    public function __construct($parent, $self)
    {
        parent::__construct(sprintf('El padre debe ser del mismo tipo que el hijo. El tipo del padre es %s, mientras que el del hijo es %s.', $parent, $self));
    }
}