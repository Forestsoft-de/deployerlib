<?php
namespace Forestsoft\Deployer\Wrapper;
use Forestsoft\Deployer\BaseTest;

/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 16.02.2019
 * Time: 22:46
 */

class StubTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->_object = \Forestsoft\Deployer\Factory::app('forestsoft_deployer');
    }

    /**
     * @group integration
     */
    public function testGet()
    {
        $this->assertEquals("localhost", $this->_object->get('app.mysql.host'));
    }
}
