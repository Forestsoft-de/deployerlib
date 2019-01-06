<?php

namespace spec\Forestsoft\Deployer\Wrapper\Deployer;

use Deployer\Console\Application;
use Deployer\Deployer;
use Deployer\Exception\ConfigurationException;
use Deployer\Task\Context;
use Forestsoft\Deployer\Wrapper\Deployer\Stub;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StubSpec extends ObjectBehavior
{
    function let()
    {
        $console = new Application('Deployer', "0.1");
        new Deployer($console);

        $input = new \Symfony\Component\Console\Input\ArgvInput();
        $output = new \Symfony\Component\Console\Output\BufferedOutput();

        $localhost = new \Deployer\Host\Localhost();
        $localhost->set("foo", "bar");
        Context::push(new Context($localhost, $input, $output));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Stub::class);
    }

    function it_get_return_config_value()
    {
        $this->shouldThrow(ConfigurationException::class);
        $this->get("foo")->shouldBeEqualTo(
            "bar"
        );
    }

    function it_cd_the_working_directory()
    {
        $this->cd("../")->shouldReturnAnInstanceOf(Stub::class);
        $this->get("working_path")->shouldBeEqualTo("../");
    }
}
