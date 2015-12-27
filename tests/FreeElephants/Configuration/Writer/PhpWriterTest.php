<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;
use FreeElephants\Configuration\Writer\PhpWriter;

/**
 *
 * @author samizdam
 *
 */
class PhpWriterTest extends AbstractConfigurationUnitTestCase
{

    public function testWriteFile()
    {
        $writer = new PhpWriter();
        $outputFilename = self::OUTPUT_PATH . "foo.php";
        $this->assertFileNotExists($outputFilename);
        $writer->writeFile($outputFilename, ["foo" => "bar"]);
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
            , $writer->toString(["foo" => "bar"]));
    }

}