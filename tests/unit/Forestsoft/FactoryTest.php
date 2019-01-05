<?php

use Forestsoft\Deployer\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    /**
     * @var Factory
     */
    protected $_object = null;

    protected function setUp()
    {
        $this->_object = Factory::getInstance();
    }

    public function testGetInstance()
    {
        $instance = Factory::getInstance();
        $this->assertInstanceOf(Factory::class, $instance);
    }

    public function testGetDatabaseConfigurator()
    {

    }

    public function testGetDatabaseCommand()
    {

    }


}
