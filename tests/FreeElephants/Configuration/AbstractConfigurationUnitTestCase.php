<?php

namespace FreeElephants\Configuration;

/**
 *
 * @author samizdam
 *
 */
abstract class AbstractConfigurationUnitTestCase extends \PHPUnit_Framework_TestCase
{


    const DS = DIRECTORY_SEPARATOR;


    /**
     * Path to static input testing data.
     *
     * @var string
     */
    const FIXTURE_PATH = __DIR__ . self::DS . "_fixtures" . self::DS;

    /**
     *
     * @var string
     */
    const OUTPUT_PATH = __DIR__ . self::DS . "_output" . self::DS;

    protected function setUp()
    {
        foreach(glob(self::OUTPUT_PATH . "*") as $filename){
            if($filename === ".gitignore"){
                continue;
            } else {
                unlink($filename);
            }
        }
        parent::setUp();
    }

    /**
     *
     * @param string $filename
     * @return string
     */
    protected function loadFixture($filename)
    {
        return file_get_contents(self::FIXTURE_PATH . $filename);
    }

    /**
     *
     *
     * @param string $filename
     * @return array
     */
    protected function loadPhpFixture($filename)
    {
        return require self::FIXTURE_PATH . $filename;
    }
}