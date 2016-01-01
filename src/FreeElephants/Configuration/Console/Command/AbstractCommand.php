<?php

namespace FreeElephants\Configuration\Console\Command;

use Symfony\Component\Console\Command\Command;

/**
 * @author samizdam
 */
abstract class AbstractCommand extends Command
{
    /**
     *
     *
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $name = $name ? $name : $this->getDefaultName();
        parent::__construct($name);
    }

    /**
     *
     * @return string
     */
    abstract public function getDefaultName();
}
