<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Naming;

use GoetasWebservices\XML\XSDReader\Schema\Item;
use GoetasWebservices\XML\XSDReader\Schema\Type\Type;

interface NamingStrategy
{
    public function getTypeName(Type $type): string;

    public function getAnonymousTypeName(Type $type, string $parentName): string;

    public function getItemName(Item $item): string;

    //@todo introduce common type for attributes and elements
    public function getPropertyName($item): string;
}
