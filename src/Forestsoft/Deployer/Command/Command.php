<?php

namespace Forestsoft\Deployer\Command;


use Forestsoft\Deployer\Wrapper\Deployer;

class Command
{

    /**
     * @var Deployer
     */
    protected $_deployer = null;

    public function __construct(Deployer $deployer)
    {
        $this->_deployer = $deployer;
    }

    /**
     * @param Deployer $deployer
     */
    public function setDeployer(Deployer $deployer): void
    {
        $this->_deployer = $deployer;
    }

    /**
     * @param $command
     */
    public function run($command)
    {
        $this->_deployer->run($command);
    }
}