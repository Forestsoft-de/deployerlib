<?php
/**
 * Created by PhpStorm.
 * User: sebastian.foerster
 * Date: 06.01.2019
 * Time: 23:00
 */

namespace spec\Forestsoft\Deployer;

use Forestsoft\Deployer\Factory;
use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{

    function let()
    {

    }

    public  function it_return_an_factory_instance()
    {
        $this::getInstance()->shouldReturnAnInstanceOf(Factory::class);
    }

    public function testGetDatabaseConfigurator()
    {

    }

    public function testGetDatabaseCommand()
    {

    }

    public function testGetConfigurator()
    {

    }

    public function testInit()
    {

    }
}
