<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 17.02.2019
 * Time: 15:04
 */

namespace Forestsoft\Deployer\Configuration\Wordpress;

use Forestsoft\Deployer\Configuration\DatabaseConfiguration;
use Forestsoft\Deployer\Wrapper\Deployer;

/**
 * Class Options
 * @package Forestsoft\Deployer\Configuration\Wordpress
 */
class Options implements DatabaseConfiguration
{
    protected $_optionName = null;

    protected $_values = [];
    /**
     * Options constructor.
     */
    public function __construct(Deployer $deployer)
    {
        $this->_deployer = $deployer;
    }

    public function getTable(): string
    {
        return $this->_deployer->get('app.mysql.prefix', 'wp_') . 'options';
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string $autoload
     */
    public function setOption($name, $value, $autoload = "yes")
    {
        if (is_array($value)) {
            $this->_values['option_value'] = serialize($value);
        } else {
            $this->_values['option_value'] = $value;
        }
        $this->_values['autoload'] = ($autoload == "yes") ?: "no";
        $this->_optionName = $name;

    }

    public function getValues(): array
    {
        return $this->_values;
    }

    public function getConditions(): array
    {
        $conditions['option_name'] = $this->_optionName;
        return $conditions;
    }
}