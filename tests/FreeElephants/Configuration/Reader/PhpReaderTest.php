<?php

namespace FreeElephants\Configuration\Reader;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 *
 * @author samizdam
 *
 */
class PhpReaderTest extends AbstractConfigurationUnitTestCase
{
    public function testReadFile()
    {
        $reader = new PhpReader();
        $this->assertEquals(["foo" => "bar"], $reader->readFile(self::FIXTURE_PATH . "foo.php"));
    }

    public function testReadString()
    {
        $reader = new PhpReader();
        $this->assertEquals(["foo" => "bar"], $reader->readString(<<<PHP
return array (
  'foo' => 'bar',
);
PHP
            ));
    }

}