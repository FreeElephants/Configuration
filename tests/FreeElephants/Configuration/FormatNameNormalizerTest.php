<?php

namespace FreeElephants\Configuration;

/**
 *
 * @author samizdam
 *
 */
class FormatNameNormalizerTest extends AbstractConfigurationUnitTestCase
{

    public function testNormalizeFormatWithYamlAlias()
    {
        $configurationFormatNormalizer = new FormatNameNormalizer();
        $this->assertEquals("yaml", $configurationFormatNormalizer->normalizeFormat("yml"));
    }
}