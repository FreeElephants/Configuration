<?php

namespace FreeElephants\Configuration\Console\Exception;

use FreeElephants\Configuration\Exception\ConfigurationExceptionInterface;

/**
 * @author samizdam
 */
class RuntimeException extends \Symfony\Component\Console\Exception\RuntimeException implements ConfigurationExceptionInterface
{
}
