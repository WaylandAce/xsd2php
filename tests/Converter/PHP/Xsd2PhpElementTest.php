<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Converter\PHP;

use GoetasWebservices\XML\XSDReader\Exception\IOException;
use PHPUnit\Framework\Attributes\DataProvider;

class Xsd2PhpElementTest extends Xsd2PhpBase
{
    /**
     * @throws IOException
     */
    #[DataProvider('getPrimitiveTypeConversions')]
    public function testElementOfPrimitiveType(string $xsType, string $phpName): void
    {
        $content = '
             <xs:schema targetNamespace="http://www.example.com" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <xs:element name="element-one" type="' . $xsType . '">

                </xs:element>
               </xs:schema>
            ';

        $classes = $this->converter->convert([$this->reader->readString($content)]);

        $this->assertCount(0, $classes);
    }

    /**
     * @throws IOException
     */
    #[DataProvider('getPrimitiveTypeConversions')]
    public function testElementOfPrimitiveTypeAnon(string $xsType, string $phpName): void
    {
        $content = '
             <xs:schema targetNamespace="http://www.example.com" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <xs:element name="element-one">
                    <xs:simpleType>
                         <xs:restriction base="' . $xsType . '">
                         </xs:restriction>
                    </xs:simpleType>
                </xs:element>
               </xs:schema>
            ';
        $classes = $this->converter->convert([$this->reader->readString($content)]);

        $this->assertCount(1, $classes);
    }

    /**
     * @throws IOException
     */
    #[DataProvider('getBaseTypeConversions')]
    public function testElementOfBaseType(string $xsType, string $phpName): void
    {
        $content = '
             <xs:schema targetNamespace="http://www.example.com" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <xs:element name="element-one" type="' . $xsType . '">
                </xs:element>
               </xs:schema>
            ';
        $classes = $this->converter->convert([$this->reader->readString($content)]);

        $this->assertCount(0, $classes);
    }

    /**
     * @throws IOException
     */
    #[DataProvider('getBaseTypeConversions')]
    public function testElementOfBaseTypeAnon(string $xsType, string $phpName): void
    {
        $content = '
             <xs:schema targetNamespace="http://www.example.com" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <xs:element name="element-one">
                    <xs:simpleType>
                         <xs:restriction base="' . $xsType . '">
                         </xs:restriction>
                    </xs:simpleType>
                </xs:element>
               </xs:schema>
            ';
        $classes = $this->converter->convert([$this->reader->readString($content)]);

        $this->assertCount(1, $classes);
    }
}
