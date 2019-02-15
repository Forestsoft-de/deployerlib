<?php

use Deployer\Console\Application;
use Deployer\Deployer;
use Deployer\Task\Context;

include_once dirname(__DIR__) . '/vendor/autoload.php';
define("FIXTURES", __DIR__ . "/fixtures");

$console = new Application('Deployer', "0.1");
new Deployer($console);

$input = new \Symfony\Component\Console\Input\ArgvInput();
$output = new \Symfony\Component\Console\Output\BufferedOutput();

$localhost = new \Deployer\Host\Localhost();
$localhost->set("foo", "bar");
Context::push(new Context($localhost, $input, $output));

copy(FIXTURES . "/hosts.yml", __DIR__ . "/hosts.yml");



