<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\Configuration\FormatEnum;
use FreeElephants\Configuration\FormatNameNormalizer;
use FreeElephants\Configuration\Exception\ArgumentException;

/**
 * @author samizdam
 */
class WriterFactory implements FormatEnum
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
     * @return WriterInterface
     */
    public function createWriter($format)
    {
        if ($this->formatNameNormalizer->isValidFormat($format)) {
            switch ($format) {
                case self::FORMAT_JSON:
                    $writer = new JsonWriter();
                    break;
                case self::FORMAT_PHP:
                    $writer = new PhpWriter();
                    break;
                case self::FORMAT_YAML:
                    $writer = new YamlWriter();
                    break;
            }
        } else {
            throw new ArgumentException('Unsupported format. ');
        }

        return $writer;
    }
}
