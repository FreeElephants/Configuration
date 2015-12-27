<?php

namespace FreeElephants\Configuration\Reader;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;

/**
 *
 * @author samizdam
 *
 */
class YamlReaderTest extends AbstractConfigurationUnitTestCase
{
    public function testReadFile()
    {
        $reader = new YamlReader();
        $this->assertEquals(["foo" => "bar"], $reader->readFile(self::FIXTURE_PATH . "foo.yaml"));
    }

    public function testReadString()
    {
        $reader = new YamlReader();
        $this->assertEquals(["foo" => "bar"], $reader->readString(
<<<YML
foo: bar
YML
        ));
    }
}