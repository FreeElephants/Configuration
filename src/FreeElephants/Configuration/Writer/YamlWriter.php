<?php

namespace FreeElephants\Configuration\Writer;

use Symfony\Component\Yaml\Yaml;

/**
 * @author samizdam
 */
class YamlWriter extends AbstractWriter
{
    const INLINE_LEVEL_1 = 0b0000000001;
    const INLINE_LEVEL_2 = 0b0000000010;
    const INLINE_LEVEL_3 = 0b0000000100;
    const INLINE_LEVEL_4 = 0b0000001000;
    const INLINE_LEVEL_5 = 0b0000010000;
    const INLINE_LEVEL_6 = 0b0000100000;
    const INLINE_LEVEL_DEFAULT = self::INLINE_LEVEL_4;

    const INDENT_2 = 0b0010000000;
    const INDENT_4 = 0b1000000000;
    const INDENT_DEFAULT = self::INDENT_4;

    private $inlineValueMap = [
        self::INLINE_LEVEL_1 => 1,
        self::INLINE_LEVEL_2 => 2,
        self::INLINE_LEVEL_3 => 3,
        self::INLINE_LEVEL_4 => 4,
        self::INLINE_LEVEL_5 => 5,
        self::INLINE_LEVEL_6 => 6,
    ];

    private $indentValueMap = [
        self::INDENT_2 => 2,
        self::INDENT_4 => 4,
    ];

    public function getDefaultOptions()
    {
        return self::INLINE_LEVEL_DEFAULT | self::INDENT_DEFAULT;
    }

    public function writeFile($filename, $data)
    {
        file_put_contents($filename, $this->toString($data));
    }

    public function toString($data)
    {
        $inline = $this->getInlineValue();
        $indent = $this->getIndentValue();

        return Yaml::dump($data, $inline, $indent);
    }

    private function getInlineValue()
    {
        $inlineValue = self::INLINE_LEVEL_DEFAULT;
        foreach ($this->inlineValueMap as $option => $value) {
            if ($this->hasFlag($option)) {
                $inlineValue = $value;
            }
        }

        return $inlineValue;
    }

    private function getIndentValue()
    {
        $indentValue = self::INDENT_DEFAULT;
        foreach ($this->indentValueMap as $option => $value) {
            if ($this->hasFlag($option)) {
                $indentValue = $value;
            }
        }

        return $value;
    }
}
