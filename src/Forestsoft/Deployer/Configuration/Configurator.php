<?php

namespace Forestsoft\Deployer\Configuration;


use Forestsoft\Deployer\Wrapper\Deployer;

class Configurator
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
     * @param Deployer $deployer
     */
    public function setDeployer(Deployer $deployer): void
    {
        $this->_deployer = $deployer;
    }
}