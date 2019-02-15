<?php

namespace Forestsoft\Deployer\Wrapper;


use function Deployer\get;

interface Deployer
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function download($source, $destination);

    /**
     * @param $source
     * @param $detsination
     * @return mixed
     */
    public function upload($source, $detsination);

    /**
     * @param $command
     * @return mixed
     */
    public function run($command);

    /**
     * @param $command
     * @return mixed
     */
    public function runLocally($command);

    /**
     * @param $key
     * @param $default
     * 
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @return bool
     */
    public function isDebug();

    /**
     * @param $key
     * @param $value
     * 
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param $text
     * 
     * @return mixed
     */
    public function write($text);

    /**
     * @param $text
     * 
     * @return mixed
     */
    public function writeln($text);

    /**
     * @param $string
     * @return mixed
     */
    public function parse($string);

    /**
     * @return array
     */
    public function getParsedConfig() : array;

    /**
     * @param string $string
     * @return bool
     */
    public function has(string $string) : bool;

    /**
     * @param $filename
     * @return mixed
     */
    public function inventory($filename);

    /**
     * @param $directory
     * @return mixed
     */
    public function cd($directory);
}