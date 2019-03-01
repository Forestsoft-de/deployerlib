<?php

namespace spec\Forestsoft\Deployer\Wrapper\Deployer;

use Deployer\Exception\ConfigurationException;
use Forestsoft\Deployer\Wrapper\Deployer\Stub;
use PhpSpec\ObjectBehavior;

class StubSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Stub::class);
    }

    function it_get_return_config_value()
    {
        $this->shouldThrow(new ConfigurationException("Configuration parameter `foo` does not exist."))->during('get', ['foo']);
    }

    function it_cd_the_working_directory()
    {
        $this->cd("../")->shouldReturnAnInstanceOf(Stub::class);
        $this->get("working_path")->shouldBeEqualTo("../");
    }
}
