<?php

namespace Forestsoft\Deployer;

use Forestsoft\Deployer\Configuration\Configurator;
use Forestsoft\Deployer\Configuration\Database;
use Forestsoft\Deployer\Configuration\Writer\File;
use Forestsoft\Deployer\Wrapper\Deployer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

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
     * @var ContainerInterface
     */
    private $_container;

    /**
     * Factory constructor.
     */
    public function __construct($hostConfig)
    {
        $this->_container = new ContainerBuilder();
        $loader = new XmlFileLoader($this->_container, new FileLocator(__DIR__));
        $loader->load(__DIR__ . '/services.xml');

        /** @var Deployer\Stub $wrapper */
        $wrapper = $this->_container->get('forestsoft_deployer');
        $wrapper->inventory($hostConfig);
        $this->setWrapper($wrapper);
        $this->init();
    }

    public static function app($key)
    {
        return self::container()->get($key);
    }

    public static function container()
    {
        $instance = self::getInstance();
        return $instance->getContainer();
    }

    /**
     * @return Factory
     */
    public static function getInstance($hostConfig = "hosts.yml")
    {
        if (self::$instance === null) {
           self::$instance = new Factory($hostConfig);
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
        return $this->getContainer()->get('forestsoft_deployer_configurator');
    }

    /**
     * @return File
     */
    public function getConfigFileWriter()
    {
        return $this->getContainer()->get('forestsoft_deployer_configurator_file');
    }

    /**
     * @return Command\Database
     */
    public function getDatabaseCommand() : \Forestsoft\Deployer\Command\Database
    {
        return $this->_container->get("forestsoft_deployer_command_database");
    }

    public function init()
    {
        $this->_wrapper->set('keep_releases', 5);
        $this->_wrapper->set('ssh_multiplexing', true);
        $this->_wrapper->set("configFile","{{configFile}}");
        $this->_wrapper->set('default_stage', 'dev');

        $this->getConfigurator();
    }

    public function getContainer() : ContainerInterface
    {
        return $this->_container;
    }
}