<?php

namespace Forestsoft\Deployer\Wrapper\Deployer;


use function Deployer\cd;
use function Deployer\download;
use function Deployer\get;
use function Deployer\has;
use Deployer\Host\Localhost;
use function Deployer\inventory;
use function Deployer\isDebug;
use function Deployer\parse;
use function Deployer\run;
use function Deployer\runLocally;
use function Deployer\set;
use Deployer\Task\Context;
use function Deployer\upload;

use function Deployer\write;
use function Deployer\writeln;
use Forestsoft\Deployer\Factory;
use Forestsoft\Deployer\Wrapper\Deployer;

class Stub implements Deployer
{


    /**
     * Stub constructor.
     */
    public function __construct()
    {
    }

    public function download($source, $destination)
    {
        download($source, $destination);
    }

    public function upload($source, $destination)
    {
        upload($source, $destination);
    }

    public function run($command)
    {
        run($command);
    }

    public function runLocally($command)
    {
        runLocally($command);
    }

    /**
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return get($key, $default);
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return isDebug();
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return set($key, $value);
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function write($text)
    {
        return write($text);
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function writeln($text)
    {
        return writeln($text);
    }

    /**
     * @param $string
     * @return mixed
     */
    public function parse($string)
    {
        return parse($string);
    }

    /**
     * @return array
     */
    public function getParsedConfig() : array
    {
        $config = Factory::getInstance()->getConfigurator();
        return $config->getAppConfig();
    }

    /**
     * @param string $string
     * @return bool
     */
    public function has(string $string) : bool
    {
        return has($string);
    }

    /**
     * @param $filename
     * @return mixed
     */
    public function inventory($filename)
    {
        inventory($filename);
    }

    public function cd($directory)
    {
        cd($directory);
        return $this;
    }

    /**
     * @return bool
     * @throws \Deployer\Exception\Exception
     */
    public function isLocal(): bool
    {
        return Context::get()->getHost() instanceof Localhost;
    }
}