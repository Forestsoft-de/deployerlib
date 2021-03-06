<?php

use Deployer\Deployer;

use Deployer\Task\Context;
use Forestsoft\Deployer\Configuration\Writer;
use Forestsoft\Deployer\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    /**
     * @var Factory
     */
    protected $_object = null;
    
    private $_input;
    private $_output;

    protected function setUp()
    {
        $this->_object = Factory::getInstance();
        $this->_input = new \Symfony\Component\Console\Input\ArgvInput();
        $this->_output = new \Symfony\Component\Console\Output\BufferedOutput();
        
        Context::push(new Context(Deployer::get()->hosts->get("dev.local"), $this->_input, $this->_output));
    }

    public function testGetInstanceThrowsExceptionIfHostFileNotFound()
    {
        Factory::reset();
        
        $this->expectException(\Deployer\Exception\Exception::class);
        $this->expectExceptionMessage("File `notfound.yml` doesn't exists or doesn't readable.");
        
        Factory::getInstance("notfound.yml");
    }

    public function testGetInstance()
    {
        $instance = Factory::getInstance();
        $this->assertInstanceOf(Factory::class, $instance);
    }

    public function testGetDatabaseConfigurator()
    {
        $this->assertInstanceOf(\Forestsoft\Deployer\Configuration\Configurator::class, $this->_object->getDatabaseConfigurator());
    }

    public function testGetDatabaseCommand()
    {
        $this->assertInstanceOf(\Forestsoft\Deployer\Command\Database::class, $this->_object->getDatabaseCommand());
    }

    public function testgetFileConfigWriter()
    {
        $this->assertInstanceOf(Writer::class, $this->_object->getConfigFileWriter());
    }

    public function tearDown()
    {
        Factory::reset();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}
