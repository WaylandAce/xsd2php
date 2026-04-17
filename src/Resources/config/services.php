<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\Xsd\XsdToPhp\Jms\PathGenerator\Psr4PathGenerator;
use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlConverter;
use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlValidatorConverter;
use GoetasWebservices\Xsd\XsdToPhp\Naming\LongNamingStrategy;
use GoetasWebservices\Xsd\XsdToPhp\Naming\NoConflictLongNamingStrategy;
use GoetasWebservices\Xsd\XsdToPhp\Naming\ShortNamingStrategy;
use GoetasWebservices\Xsd\XsdToPhp\Php\ClassGenerator;
use GoetasWebservices\Xsd\XsdToPhp\Php\PhpConverter;
use GoetasWebservices\Xsd\XsdToPhp\Writer\JMSWriter;
use GoetasWebservices\Xsd\XsdToPhp\Writer\PHPClassWriter;
use GoetasWebservices\Xsd\XsdToPhp\Writer\PHPWriter;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('goetas_webservices.xsd2php.naming_convention.short', ShortNamingStrategy::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.naming_convention.long', LongNamingStrategy::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.naming_convention.long_no_conflicts', NoConflictLongNamingStrategy::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.schema_reader', SchemaReader::class)
        ->public();

    $services->set('goetas_webservices.xsd2php.naming_convention')
        ->public()
        ->synthetic();

    $services->set('logger')
        ->synthetic();

    $services->set('goetas_webservices.xsd2php.converter.php', PhpConverter::class)
        ->public()
        ->args([service('goetas_webservices.xsd2php.naming_convention')])
        ->call('setLogger', [service('logger')]);

    $services->set('goetas_webservices.xsd2php.converter.jms', YamlConverter::class)
        ->public()
        ->args([service('goetas_webservices.xsd2php.naming_convention')])
        ->call('setLogger', [service('logger')]);

    $services->set('goetas_webservices.xsd2php.converter.validation', YamlValidatorConverter::class)
        ->public()
        ->args([service('goetas_webservices.xsd2php.naming_convention')])
        ->call('setLogger', [service('logger')]);

    $services->set('goetas_webservices.xsd2php.path_generator.php')
        ->public()
        ->synthetic();

    $services->set('goetas_webservices.xsd2php.path_generator.jms')
        ->public()
        ->synthetic();

    $services->set('goetas_webservices.xsd2php.path_generator.validation')
        ->synthetic();

    $services->set('goetas_webservices.xsd2php.path_generator.php.psr4', \GoetasWebservices\Xsd\XsdToPhp\Php\PathGenerator\Psr4PathGenerator::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.path_generator.jms.psr4', Psr4PathGenerator::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.path_generator.validation.psr4', Psr4PathGenerator::class)
        ->private();

    $services->set('goetas_webservices.xsd2php.writer.php', PHPWriter::class)
        ->public()
        ->args([
            service('goetas_webservices.xsd2php.class_writer.php'),
            service('goetas_webservices.xsd2php.php.class_generator'),
            service('logger'),
        ]);

    $services->set('goetas_webservices.xsd2php.class_writer.php', PHPClassWriter::class)
        ->public()
        ->args([
            service('goetas_webservices.xsd2php.path_generator.php'),
            service('logger'),
        ]);

    $services->set('goetas_webservices.xsd2php.php.class_generator', ClassGenerator::class)
        ->public();

    $services->set('goetas_webservices.xsd2php.writer.jms', JMSWriter::class)
        ->public()
        ->args([
            service('goetas_webservices.xsd2php.path_generator.jms'),
            service('logger'),
        ]);

    $services->set('goetas_webservices.xsd2php.writer.validation', JMSWriter::class)
        ->public()
        ->args([
            service('goetas_webservices.xsd2php.path_generator.validation'),
            service('logger'),
        ]);
};
