<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 16.02.2019
 * Time: 16:59
 */

namespace Forestsoft\Deployer\Command;


interface DatabaseCommand
{
    public function run($sql);

    public function import(array $sqlFiles);
}