<?php

namespace FreeElephants\Configuration\Reader;

use FreeElephants\Configuration\FormatEnum;
use FreeElephants\Configuration\FormatNameNormalizer;
use FreeElephants\Configuration\Exception\ArgumentException;

/**
 * @author samizdam
 */
class ReaderFactory implements FormatEnum
{
    private $formatNameNormalizer;

    public function __construct()
    {
        $this->formatNameNormalizer = new FormatNameNormalizer();
    }

    /**
     * @param string $format
     *
     * @throws \DomainException
     *
     * @return ReaderInterface
     */
    public function createReader($format)
    {
        if ($this->formatNameNormalizer->isValidFormat($format)) {
            switch ($format) {
                case self::FORMAT_JSON:
                    $reader = new JsonReader();
                    break;
                case self::FORMAT_YAML:
                    $reader = new YamlReader();
                    break;
                case self::FORMAT_PHP:
                    $reader = new PhpReader();
                    break;
            }
        } else {
            throw new ArgumentException('Unsupported format. ');
        }

        return $reader;
    }
}
