<?php

namespace FreeElephants\Configuration\Reader;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;
use FreeElephants\Configuration\Exception\ArgumentException;

/**
 * @author samizdam
 */
class ReaderFactoryTest extends AbstractConfigurationUnitTestCase
{
    public function testCreateReader()
    {
        $factory = new ReaderFactory();
        $this->assertInstanceOf(JsonReader::class, $factory->createReader(ReaderFactory::FORMAT_JSON));
        $this->assertInstanceOf(PhpReader::class, $factory->createReader(ReaderFactory::FORMAT_PHP));
        $this->assertInstanceOf(YamlReader::class, $factory->createReader(ReaderFactory::FORMAT_YAML));
    }

    public function testCreateReaderArgumenrException()
    {
        $factory = new ReaderFactory();
        $this->setExpectedException(ArgumentException::class);
        $factory->createReader('Foo');
    }
}
