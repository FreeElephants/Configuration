<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 * @author samizdam
 */
class YamlWriterTest extends AbstractConfigurationUnitTestCase
{
    public function testWriteFile()
    {
        $writer = new YamlWriter();
        $outputFilename = self::OUTPUT_PATH.'foo.yaml';
        $writer->writeFile($outputFilename, ['foo' => 'bar']);
        $this->assertFileExists($outputFilename);
    }

    public function testToString()
    {
        $writer = new YamlWriter();
        $this->assertEquals("foo: bar\n", $writer->toString(['foo' => 'bar']));
    }
}
