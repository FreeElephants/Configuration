<?php

namespace FreeElephants\Configuration\Writer;

/**
 * @author samizdam
 */
class JsonWriter extends AbstractWriter
{
    public function getDefaultOptions()
    {
        return JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;
    }

    public function writeFile($filename, $data)
    {
        file_put_contents($filename, $this->toString($data));
    }

    public function toString($data)
    {
        return json_encode($data, $this->getOptions());
    }
}
