<?php

namespace Forestsoft\Deployer;

use Forestsoft\Deployer\Configuration\Configurator;
use Forestsoft\Deployer\Configuration\Database;
use Forestsoft\Deployer\Wrapper\Deployer;

class Factory
{
    /**
     * @var Factory
     */
    private static $instance = null;

    /**
     * @var Deployer
     */
    private $_wrapper;


    /**
     * @return Factory
     */
    public static function getInstance($hostConfig = "hosts.yml")
    {
        if (self::$instance === null) {
            self::$instance = new Factory();
            $wrapper = new Wrapper\Deployer\Stub();
            $wrapper->inventory($hostConfig);
            self::$instance->setWrapper($wrapper);
        }

        return self::$instance;
    }

    /**
     * 
     */
    public static function reset()
    {
        self::$instance = null;
    }

    /**
     * @return Database
     */
    public function getDatabaseConfigurator()
    {
        return new Database($this->_wrapper);
    }

    public function setWrapper(Deployer $wrapper)
    {
        $this->_wrapper = $wrapper;
    }

    /**
     * @return Configurator
     */
    public function getConfigurator()
    {
        return new Configurator($this->_wrapper);
    }

    /**
     * @return Command\Database
     */
    public function getDatabaseCommand() : \Forestsoft\Deployer\Command\Database
    {
        return new \Forestsoft\Deployer\Command\Database($this->_wrapper);
    }

    public function init()
    {
        $this->_wrapper->set('keep_releases', 5);
        $this->_wrapper->set('ssh_multiplexing', true);
        $this->_wrapper->set("configFile","{{configFile}}");
        $this->_wrapper->set('default_stage', 'dev');
    }
}