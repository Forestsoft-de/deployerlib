<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 16.02.2019
 * Time: 15:55
 */

namespace Forestsoft\Deployer\Command;

use Forestsoft\Deployer\Factory;
use Forestsoft\Deployer\Wrapper\Deployer;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $root;

    private $_deployer;

    /**
     * @var
     */
    private $_object;

    public function setupCredentials(): void
    {
        $this->_deployer->method('get')->will($this->returnValueMap(
            [
                ['app.mysql.host', null, 'localhost'],
                ['app.mysql.user', null, 'root'],
                ['app.mysql.password', null, 'root'],
                ['app.mysql.port', null, '3306'],
                ['app.mysql.database', null, 'mydatabase']
            ]
        ));
    }

    protected function setUp()
    {
        parent::setUp();

        $this->_deployer = $this->getMockBuilder(Deployer::class)->getMock();
        Factory::container()->set("forestsoft_deployer", $this->_deployer);
        $this->_object = Factory::app("forestsoft_deployer_command_database");
        $this->root = vfsStream::setup("exampleDir");
    }

    /**
     *
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf(DatabaseCommand::class, $this->_object);
    }

    /**
     *
     */
    public function testImportThrowsExceptionIfFileDoesNotExists()
    {
        $sqlFile = vfsStream::url("exampleDir/dump.sql");

        $this->expectExceptionMessage(sprintf("The sql file %s to import does not exist", $sqlFile));
        $this->_object->import([$sqlFile]);
    }

    /**
     *
     */
    public function testImport()
    {
        $sqlFile = vfsStream::url("exampleDir/dump.sql");
        $sqlCommand = "mysql -hlocalhost -uroot -P3306 -p'root' mydatabase < $sqlFile";

        $this->setupCredentials();

        $this->_deployer->method('isLocal')->willReturn(true);
        $this->_deployer->expects($this->once())->method('run')->with($sqlCommand);

        vfsStream::newFile('dump.sql')->withContent("INSERT INTO foo values (foo, bar)")->at($this->root);

        $this->_deployer->expects($this->once())->method('writeln')->with(
            sprintf("<info>✔</info> %s sucessfully imported to %s@%s ON %s", $sqlFile, "root", "localhost", "mydatabase")
        );

        $this->_object = new Database($this->_deployer);
        $this->_object->import([$sqlFile]);
    }

    /**
     *
     */
    public function testRun()
    {
        $this->setupCredentials();

        $this->_object = new Database($this->_deployer);
        $sqlCommand = "mysql -hlocalhost -uroot -P3306 -p'root' mydatabase -e \"update mysql.user set password='newsecret' where user='root'\"";
        $this->_deployer->expects($this->once())->method('run')->with($sqlCommand);

        $this->_object->run("update mysql.user set password='newsecret' where user='root'");
    }
}
