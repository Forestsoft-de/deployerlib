<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 17.02.2019
 * Time: 14:48
 */

namespace Forestsoft\Deployer\Configuration;


interface DatabaseConfiguration
{
    /**
     * @return string
     */
    public function getTable() : string;

    /**
     * @return string[]
     */
    public function getValues() : array;

    /**
     * @return string[]
     */
    public function getConditions() : array;
}