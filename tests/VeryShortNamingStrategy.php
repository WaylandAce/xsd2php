<?php

namespace GoetasWebservices\Xsd\XsdToPhp\Tests;

use Doctrine\Inflector\InflectorFactory;
use GoetasWebservices\XML\XSDReader\Schema\Type\Type;
use GoetasWebservices\Xsd\XsdToPhp\Naming\ShortNamingStrategy;

/**
 * The OTA psr4 class paths can exceed windows max dir length.
 */
class VeryShortNamingStrategy extends ShortNamingStrategy
{
    /**
     * Suffix with 'T' instead of 'Type'.
     */
    public function getTypeName(Type $type): string
    {
        $name = $this->classify($type->getName());

        if ($name && substr($name, -4) !== 'Type') {
            return $name . 'T';
        }

        if (substr($name, -4) === 'Type') {
            return substr($name, 0, -3);
        }

        return $name;
    }

    /**
     * Suffix with 'A' instead of 'AType'.
     */
    public function getAnonymousTypeName(Type $type, string $parentName): string
    {
        return $this->classify($parentName) . 'A';
    }

    protected function classify(string $name): string
    {
        $inflector = InflectorFactory::create()->build();

        return $inflector->classify(str_replace('.', ' ', $name));
    }
}
