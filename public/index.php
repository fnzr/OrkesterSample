<?php
declare (strict_types=1);

require __DIR__.'/../vendor/autoload.php';
set_error_handler('errorHandler');

Orkester\Manager::process();
Orkester\Manager::terminate();
