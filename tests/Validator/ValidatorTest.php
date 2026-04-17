<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Validator;

use Composer\Autoload\ClassLoader;
use GoetasWebservices\Xsd\XsdToPhp\Tests\Validator\ota\php\TestNotNullType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorTest extends TestCase
{
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        $loader = new ClassLoader();
        $loader->addPsr4('GoetasWebservices\\Xsd\\XsdToPhp\\Tests\\Validator\\ota\\php\\', __DIR__ . '/ota/php');
        $loader->register();

        $builder = Validation::createValidatorBuilder();

        foreach (glob(__DIR__ . '/ota/validator/*.yml') as $file) {
            $builder->addYamlMapping($file);
        }

        $this->validator = $builder->getValidator();
    }

    public function testNotNullViolations(): void
    {
        $object = new TestNotNullType();
        $violations = $this->validator->validate($object);

        $this->assertCount(1, $violations);

        $object->setValue('My value');
        $violations = $this->validator->validate($object);

        $this->assertCount(0, $violations);
    }
}
