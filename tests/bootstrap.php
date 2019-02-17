<?php

use Deployer\Console\Application;
use Deployer\Deployer;
use function Deployer\inventory;

include_once dirname(__DIR__) . '/vendor/autoload.php';
include_once __DIR__ . '/unit/Forestsoft/Deployer/BaseTest.php';


define("FIXTURES", __DIR__ . "/fixtures");

$console = new Application('Deployer', "0.1");
$deployer = new Deployer($console);
$deployer->init();

copy(FIXTURES . "/hosts.yml", __DIR__ . "/hosts.yml");
inventory(__DIR__ . "/hosts.yml");



