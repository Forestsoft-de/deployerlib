<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 17.02.2019
 * Time: 15:08
 */

use Forestsoft\Deployer\Configuration\Wordpress\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends \Forestsoft\Deployer\BaseTest
{
    /**
     * @var Options
     */
    private $_object;

    protected function setUp()
    {
        parent::setUp();
        $this->_object = \Forestsoft\Deployer\Factory::app('forestsoft_deployer_configuration_wordpress_options');
    }

    /**
     *
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf(\Forestsoft\Deployer\Configuration\DatabaseConfiguration::class, $this->_object);
    }

    /**
     *
     */
    public function testsetOption()
    {
        $expected['option_value'] = "bar";
        $expected['autoload'] = "no";

        $this->_object->setOption("foo", "bar", "no");

        $this->assertEquals($expected, $this->_object->getValues());

        $conditions['option_name'] = "foo";

        $this->assertEquals($conditions, $this->_object->getConditions());
    }


    public function testgetTable()
    {
        $this->assertEquals('wp_options', $this->_object->getTable());
    }
}
