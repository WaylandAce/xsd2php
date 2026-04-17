<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Naming;

use GoetasWebservices\XML\XSDReader\Schema\Type\Type;

class LongNamingStrategy extends AbstractNamingStrategy
{
    public function getTypeName(Type $type): string
    {
        return $this->classify($type->getName()) . 'Type';
    }

    public function getAnonymousTypeName(Type $type, $parentName): string
    {
        return $this->classify($parentName) . 'AnonymousPHPType';
    }
}
