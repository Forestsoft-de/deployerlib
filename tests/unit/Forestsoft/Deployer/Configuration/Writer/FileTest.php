<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 15.02.2019
 * Time: 20:00
 */

namespace Forestsoft\Deployer\Configuration\Writer;

use Forestsoft\Deployer\Configuration\ConfiguratorInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{

    private $configurator;

    /**
     * @var File
     */
    private $_object;

    private $root;

    protected function setUp()
    {
        parent::setUp();
        $this->configurator = $this->getMockBuilder(ConfiguratorInterface::class)->getMock();
        $this->_object = new File($this->configurator);
        $this->root = vfsStream::setup('exampleDir');
    }

    /**
     *
     */
    public function testWrite()
    {
        vfsStream::newFile('config.txt')
            ->withContent('{{deploy_dir}}/mydirectorory')->at($this->root);

        $this->_object->addFiles([vfsStream::url("exampleDir/config.txt")]);

        $this->configurator->expects($this->once())->method('parse')->with('{{deploy_dir}}/mydirectorory')->willReturn('/var/www/mydirectorory');

        $this->_object->write();

        $this->assertEquals("/var/www/mydirectorory", file_get_contents(vfsStream::url("exampleDir/config.txt")));
    }
}
