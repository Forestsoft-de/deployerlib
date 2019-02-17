<?php

namespace Forestsoft\Deployer\Configuration;

use Deployer\Host\Host;
use Forestsoft\Deployer\Wrapper\Deployer;
use Forestsoft\Deployer\Configuration\Configurator;
use PHPUnit\Framework\TestCase;

class ConfiguratorTest extends TestCase
{

    /**
     * @var Configurator
     */
    protected $_object = null;

    /**
     * @var Deployer
     */
    private $_deployer;

    public function dp_config()
    {
        return [
            "Config" => [
                "expected" => [
                    "key" => "app.mysql.user",
                    "value" => "root"
                ],
                "config" => [
                    "http_user" => "www-data",
                    "app" => [
                        "mysql" => [
                            "user" => "root"
                        ]
                    ],
                ]
            ]
        ];
    }

    protected function setUp()
    {
        $this->_deployer = $this->getMockBuilder("Forestsoft\Deployer\Wrapper\Deployer")->getMock();
        $this->_object = $this->getMockBuilder("Forestsoft\Deployer\Configuration\Configurator")
                              ->setMethods(["foo"])
                              ->disableOriginalConstructor()
                              ->setConstructorArgs([$this->_deployer])
                              ->getMock();

        $this->_object->setDeployer($this->_deployer);
    }

    /**
     * @group unit
     */
    public function testgetAppConfig()
    {
        $appConfig = ["app" => ["hello" => "World"]];
        $this->_deployer->expects($this->any())->method("get")->with("app")->willReturn($appConfig);
        $this->assertEquals($appConfig, $this->_object->getAppConfig());
    }

    /**
     * @group unit
     * @dataProvider dp_config
     */
    public function testParseConfig($expectedConfig, $config)
    {
        $host = $this->getMockBuilder(Host::class)->disableOriginalConstructor()->getMock();
        $host->expects($this->once())->method("set")->with($expectedConfig["key"], $expectedConfig["value"]);

        $this->_object->parseConfig($host, $config["app"], "app");
    }
}
