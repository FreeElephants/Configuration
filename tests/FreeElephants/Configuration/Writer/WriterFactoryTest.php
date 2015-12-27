<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;
use FreeElephants\Configuration\Exception\ArgumentException;

/**
 *
 * @author samizdam
 *
 */
class WriterFactoryTest extends AbstractConfigurationUnitTestCase
{

    public function testCreateWriter()
    {
        $factory = new WriterFactory();
        $this->assertInstanceOf(JsonWriter::class, $factory->createWriter(WriterFactory::FORMAT_JSON));
        $this->assertInstanceOf(PhpWriter::class, $factory->createWriter(WriterFactory::FORMAT_PHP));
        $this->assertInstanceOf(YamlWriter::class, $factory->createWriter(WriterFactory::FORMAT_YAML));
    }

    public function testCreateWriterArgumentException()
    {
        $factory = new WriterFactory();
        $this->setExpectedException(ArgumentException::class);
        $factory->createWriter("Foo");
    }
}