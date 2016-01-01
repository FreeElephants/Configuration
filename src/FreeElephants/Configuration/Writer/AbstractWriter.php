<?php

namespace FreeElephants\Configuration\Writer;

use FreeElephants\BitMask\BitMaskTrait;

/**
 * @author samizdam
 */
abstract class AbstractWriter implements WriterInterface
{
    use BitMaskTrait;

    /**
     *
     * @var int
     */
    private $options = 0;

    public function __construct()
    {
        $this->setOptions($this->getDefaultOptions());
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function getBitFieldValue()
    {
        return $this->getOptions();
    }
}
