<?php

namespace Forestsoft\Deployer\Configuration;


use Forestsoft\Deployer\Wrapper\Deployer;

class Configurator implements ConfiguratorInterface
{
    /**
     * @var Deployer 
     */
    protected $_deployer;

    /**
     * @var array 
     */
    protected $_settings;

    public function __construct(Deployer $wrapper)
    {
        $this->_deployer = $wrapper;
        $this->_settings = $this->getAppConfig();
    }

    /**
     * @return array
     */
    public function getAppConfig()
    {
        $settings = $this->_deployer->get("app");
        $this->parseConfig($settings, "app");
        return $this->_deployer->get("app");
    }

    /**
     * @param $settingsApp
     * @param $index
     */
    public function parseConfig($settingsApp, $index)
    {
        if (!is_array($settingsApp)) {
            throw new \InvalidArgumentException("Could not parse config. Given config is empty");
        }

        foreach ($settingsApp as $key => $value) {
            if (is_array($value) && preg_match("#[A-z]+#", $key)) {
                $this->parseConfig($value, $index . "." . $key );
            } else {
                $indexKey = $index . "." . $key;

                if ($this->_deployer->isDebug()) {
                   $this->_deployer->writeln("Set config " . $indexKey . " to '" . $value . "'");
                }
                $this->_deployer->set($indexKey, $value);
            }
        }
    }

    /**
     * @param $string
     */
    public function parse($string)
    {
        return $this->_deployer->parse($string);
    }

    public function get($key, $default = null)
    {
        return $this->_deployer->get($key, $default);
    }

    /**
     * @param Deployer $deployer
     */
    public function setDeployer(Deployer $deployer): ConfiguratorInterface
    {
        $this->_deployer = $deployer;

        return $this;
    }
}