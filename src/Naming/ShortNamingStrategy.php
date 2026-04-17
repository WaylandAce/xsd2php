<?php

namespace GoetasWebservices\Xsd\XsdToPhp\Naming;

use GoetasWebservices\XML\XSDReader\Schema\Item;
use GoetasWebservices\XML\XSDReader\Schema\Type\Type;

class ShortNamingStrategy extends AbstractNamingStrategy
{
    public function getTypeName(Type $type): string
    {
        $name = $this->classify($type->getName());
        if ($name && !str_ends_with($name, 'Type')) {
            $name .= 'Type';
        }

        return $name;
    }

    public function getAnonymousTypeName(Type $type, string $parentName): string
    {
        return $this->classify($parentName) . 'AType';
    }
}
