<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 * @author samizdam
 */
class PhpWriterTest extends AbstractConfigurationUnitTestCase
{
    public function testWriteFile()
    {
        $writer = new PhpWriter();
        $outputFilename = self::OUTPUT_PATH.'foo.php';
        $this->assertFileNotExists($outputFilename);
        $writer->writeFile($outputFilename, ['foo' => 'bar']);
        $this->assertFileExists($outputFilename);
    }

    public function testToString()
    {
        $writer = new PhpWriter();
        $this->assertContains(<<<PHP
array (
  'foo' => 'bar',
)
PHP
            , $writer->toString(['foo' => 'bar']));
    }

    public function testToStringWithOpenTag()
    {
        $writer = new PhpWriter();
        $writer->setOptions(PhpWriter::OPTION_ADD_PHP_OPEN_TAG);
        $this->assertContains('<?php', $writer->toString(['foo' => 'bar']));
    }
}
