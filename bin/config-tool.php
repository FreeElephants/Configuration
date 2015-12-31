<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use FreeElephants\Configuration\Console\Command\ConvertConfigCommand;

$app = new Application("FreeElephants Config Console App");
$app->add(new ConvertConfigCommand("config:convert"));
$app->run();