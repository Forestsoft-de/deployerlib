<?php

namespace Forestsoft\Deployer\Configuration;

use Forestsoft\Deployer\BaseTest;
use Forestsoft\Deployer\Wrapper\Deployer;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends BaseTest
{

    /**
     * @var Database
     */
    protected $_object = null;

    /**
     * @var array
     */
    private $_appConfig = [
        "configTable" => [
            "name" => "core_config_data",
            "keyField" => "path",
            "valueField" => "value",
        ],
        "config_files" => [
            "test.json"
        ],
        "app" => [
            "mysql" => [ "user" => "root" ]
        ]
    ];

    protected function setUp()
    {
        $this->_deployer = $this->getMockBuilder(Deployer::class)->getMock();
        $this->_deployer->expects($this->any())->method("get")->willReturn($this->_appConfig);
        $this->_object = new Database($this->_deployer);
    }

    /**
     * @group unit
     */
    public function testConfigureBySettingsFiles()
    {

        $dataset = __DIR__ . "/dataset/bp_sysprefs.json";
        $this->_deployer->expects($this->once())->method("download")->with(
            "{{release_path}}/test.json",
            $dataset
        );

        $mock = $this->getMockBuilder(Database::class)
            ->setMethods(["setAppDatabaseConfig", "getTempname"])
            ->setConstructorArgs([$this->_deployer])
            ->getMock();

        $mock->expects($this->any())->method("getTempname")->willReturn($dataset);
        $mock->expects($this->exactly(3))
            ->method("setAppDatabaseConfig")
            ->withConsecutive(
                ["smtp_pass", ""],
                ["smtp_user", ""],
                ["smtp_host", ""]
            );

        $mock->configureBySettingFiles();
    }

    /**
     * @group unit
     */
    public function testsetAppDatabaseConfig()
    {
        $expectedQuery = "UPDATE core_config_data SET value = 'bar' WHERE path = 'foo'";

        $mock = $this->createDbMock($expectedQuery);
        
        $mock->setAppDatabaseConfig("foo", "bar");
    }

    private function createDbMock($expectedQuery)
    {
        $dbRunner = $this->getMockBuilder(\Forestsoft\Deployer\Command\Database::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dbRunner->expects($this->once())->method("run")->with($expectedQuery);

        $mock = $this->getMockBuilder(Database::class)
            ->setMethods(["getDatabaseRunner"])
            ->setConstructorArgs([$this->_deployer])
            ->getMock();
        $mock->expects($this->any())->method("getDatabaseRunner")->willReturn($dbRunner);

        return $mock;
    }

    public function testWrite()
    {
        $configruation = $this->getMockBuilder(DatabaseConfiguration::class)->getMock();
        $expectedQuery = "UPDATE wp_options SET option_value = 'My new Wordpresssite', autoload = 'no' WHERE option_name = 'blogname'";
        $mock = $this->createDbMock($expectedQuery);

        $configruation->method('getTable')->willReturn('wp_options');
        $configruation->method('getValues')->willReturn(['option_value' => 'My new Wordpresssite', 'autoload' => 'no']);
        $configruation->method('getConditions')->willReturn(['option_name' => 'blogname']);

        $mock->write($configruation);
    }
}
