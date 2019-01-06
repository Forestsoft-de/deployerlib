<?php

use Deployer\Console\Application;
use Deployer\Deployer;

include_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
$console = new Application('Deployer', "0.1");
new Deployer($console);



