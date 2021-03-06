<?php

namespace FreeElephants\Configuration\Writer;

/**
 * @author samizdam
 */
class PhpWriter extends AbstractWriter
{
    const OPTION_ADD_PHP_OPEN_TAG = 0b0001;

    const OPTION_ADD_RETURN_STATEMENT = 0b0010;

    public function getDefaultOptions()
    {
        return self::OPTION_ADD_RETURN_STATEMENT;
    }

    public function writeFile($filename, $data)
    {
        file_put_contents($filename, $this->toString($data));
    }

    public function toString($data)
    {
        $string = var_export($data, true);
        if ($this->hasFlag(self::OPTION_ADD_PHP_OPEN_TAG)) {
            $string = "<?php\n".$string;
        }
        if ($this->hasFlag(self::OPTION_ADD_RETURN_STATEMENT)) {
            $string = "return\n".$string;
        }

        return $string;
    }
}
