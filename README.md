# Configuration

[![Build Status](https://travis-ci.org/FreeElephants/Configuration.svg?branch=master)](https://travis-ci.org/FreeElephants/Configuration)

Based on Config component's concept from Zend Framework. 

## Summary  

Currently supported formats: 
- PHP (native arrays) 
- YAML
- JSON

Configuration include Readers and Writers. 

Readers can read configuration from files in supported formats or strings. 

Writers can dump configuration to files or strings. 

## Console Tool

```php

php bin/config-tool.php config:convert config-source.php config-dest.yaml

```

Run `php bin/config-tool.php -h` for get usage. 
