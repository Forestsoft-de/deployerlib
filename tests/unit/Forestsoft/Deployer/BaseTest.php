<?php
namespace Forestsoft\Deployer;

use Deployer\Deployer;
use Deployer\Task\Context;
use PHPUnit\Framework\TestCase;
use Forestsoft\Deployer\Wrapper\Deployer as DeployerInterface;



/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 16.02.2019
 * Time: 23:15
 */

abstract class BaseTest extends TestCase
{
    /**
     * @var Deployer
     */
    protected $_deployer;

    protected function setUp()
    {
        parent::setUp();

        $this->_deployer = $this->getMockBuilder(DeployerInterface::class)->getMock();

        $input = new \Symfony\Component\Console\Input\ArgvInput();
        $output = new \Symfony\Component\Console\Output\BufferedOutput();

        $localhost = Deployer::get()->hostSelector->getByHostnames("dev.local");
        Context::push(new Context($localhost[0], $input, $output));
    }
}