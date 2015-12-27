<?php

namespace FreeElephants\Configuration\Reader;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 * @author samizdam
 */
class JsonReaderTest extends AbstractConfigurationUnitTestCase
{
    public function testReadFile()
    {
        $reader = new JsonReader();
        $this->assertEquals(['foo' => 'bar'], $reader->readFile(self::FIXTURE_PATH.'foo.json'));
    }

    public function testReadString()
    {
        $reader = new JsonReader();
        $this->assertEquals(['foo' => 'bar'], $reader->readString('{"foo": "bar"}'));
    }
}
