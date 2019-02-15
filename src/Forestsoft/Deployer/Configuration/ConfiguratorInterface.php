<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 15.02.2019
 * Time: 20:04
 */

namespace Forestsoft\Deployer\Configuration;

use Forestsoft\Deployer\Wrapper\Deployer;

/**
 * Class ConfiguratorInterface
 * @package Forestsoft\Deployer\Configuration
 */
interface ConfiguratorInterface
{
    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default);

    /**
     * @param string $string
     *
     * @return string
     */
    public function parse($string);

    /**
     * @param Deployer $deployer
     * @return ConfiguratorInterface
     */
    public function setDeployer(Deployer $deployer): ConfiguratorInterface;
}