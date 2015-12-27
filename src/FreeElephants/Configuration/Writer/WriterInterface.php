<?php

namespace FreeElephants\Configuration\Writer;

/**
 * @author samizdam
 */
interface WriterInterface
{
    /**
     * @param string $filename
     * @param mixed  $data
     */
    public function writeFile($filename, $data);

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function toString($data);
}
