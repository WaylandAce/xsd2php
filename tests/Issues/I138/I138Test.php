<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Issues\I138;

use GoetasWebservices\XML\XSDReader\Exception\IOException;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\Xsd\XsdToPhp\Naming\ShortNamingStrategy;
use GoetasWebservices\Xsd\XsdToPhp\Php\PhpConverter;
use PHPUnit\Framework\TestCase;

class I138Test extends TestCase
{
    /**
     * @throws IOException
     */
    public function testChoice(): void
    {
        $reader = new SchemaReader();
        $schema = $reader->readFile(__DIR__ . '/data.xsd');

        $phpConv = new PhpConverter(new ShortNamingStrategy());
        $phpConv->addNamespace('http://www.example.com/', 'Epa');

        $items = $phpConv->convert([$schema]);

        $this->assertTrue($items['Epa\ComplexType']->getProperty('option1')->getNullable());
        $this->assertTrue($items['Epa\ComplexType']->getProperty('option2')->getNullable());
    }
}
