<?php
/**
 * Created by PhpStorm.
 * @author: Sebastian Förster <foerster@forestsoft.de>
 * Date: 15.02.2019
 * Time: 18:31
 */

namespace Forestsoft\Deployer\Configuration\Writer;

use Forestsoft\Deployer\Configuration\Configurator;
use Forestsoft\Deployer\Configuration\ConfiguratorInterface;
use Forestsoft\Deployer\Configuration\Writer;

/**
 * Class File
 * @package Forestsoft\Deployer\Configuration\Writer
 */
class File implements Writer
{
    /**
     * @var array
     */
    private $_files = [];

    /**
     * @var Configurator
     */
    private $configurator;

    public function __construct(ConfiguratorInterface $configurator, array $files = null)
    {
        if ($files !== null) {
            $this->_files = $files;
        }

        $this->configurator = $configurator;
    }

    public function addFiles(array $files) : Writer
    {
        $this->_files = array_merge($this->_files, $files);
        return $this;
    }

    /**
     * Write configfile array
     */
    public function write()
    {
        foreach ($this->_files as $file) {
            $content = file_get_contents($file);
            $content = $this->configurator->parse($content);
            file_put_contents($file, $content);
        }
    }
}