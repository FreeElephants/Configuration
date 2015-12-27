<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 * @author samizdam
 */
class JsonWriterTest extends AbstractConfigurationUnitTestCase
{
    public function testWriteFile()
    {
        $writer = new JsonWriter();
        $outputFilename = self::OUTPUT_PATH.'foo.json';
        $writer->writeFile($outputFilename, ['foo' => 'bar']);
        $this->assertFileExists($outputFilename);
    }

    public function testToString()
    {
        $writer = new JsonWriter();
        $this->assertJson(<<<JSON
{
    "foo": "bar"
}
JSON
            , $writer->toString(['foo' => 'bar']));
    }
}
