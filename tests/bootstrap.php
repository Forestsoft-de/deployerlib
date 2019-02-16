<?php

use Deployer\Console\Application;
use Deployer\Deployer;
use function Deployer\inventory;
use Deployer\Task\Context;

include_once dirname(__DIR__) . '/vendor/autoload.php';


define("FIXTURES", __DIR__ . "/fixtures");

$console = new Application('Deployer', "0.1");
$deployer = new Deployer($console);
$deployer->init();

$input = new \Symfony\Component\Console\Input\ArgvInput();
$output = new \Symfony\Component\Console\Output\BufferedOutput();

copy(FIXTURES . "/hosts.yml", __DIR__ . "/hosts.yml");
inventory(__DIR__ . "/hosts.yml");

$localhost = Deployer::get()->hostSelector->getByHostnames("dev.local");
Context::push(new Context($localhost[0], $input, $output));



