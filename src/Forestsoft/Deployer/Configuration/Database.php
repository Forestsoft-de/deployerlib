<?php

namespace Forestsoft\Deployer\Configuration;


use Forestsoft\Deployer\Factory;

class Database extends Configurator
{
    public function configureBySettingFiles()
    {
        if(!empty($this->_settings["config_files"])) {
            $configFiles = $this->_settings["config_files"];

            $config = [];
            foreach($configFiles as $configFile) {
                $tmpFile = $this->getTempname();
                $this->_deployer->download("{{release_path}}/" . $configFile, $tmpFile);
                $loadedConfig = json_decode(file_get_contents($tmpFile), true);
                if ($loadedConfig) {
                    $config = array_merge($config, $loadedConfig);
                }
            }
            if (count($config)) {
                foreach($config as $path => $value) {
                    $this->setAppDatabaseConfig($path, $this->_deployer->parse($value));
                }
            }
        } else {
            $this->_deployer->writeln(sprintf("<fg=red>✘</fg=red> <comment>Cannot configure the database settings for app. There are no app.config_files section in config</comment>"));
        }
    }

    /**
     * @return bool|string
     */
    protected function getTempname()
    {
        return tempnam(sys_get_temp_dir(), "conf");
    }

    /**
     * @param $key
     * @param $value
     */
    public function setAppDatabaseConfig($key, $value)
    {
        if (!empty($this->_settings["configTable"]["name"])) {
            $query  = "UPDATE " . $this->_settings["configTable"]["name"] . " SET ";
            $query .=  $this->_settings["configTable"]["valueField"] . " = '" . $value . "'";
            $query .= " WHERE " . $this->_settings["configTable"]["keyField"] . " = '" . $key . "'";
            $this->getDatabaseRunner()->run($query);
        } else {
            $this->_deployer->writeln(sprintf("<fg=red>✘</fg=red> <comment>Cannot configure the database settings for app. There are no app.configTable.name section in config</comment>"));
        }
    }

    public function write(DatabaseConfiguration $configuration)
    {
        $query  = "UPDATE " . $configuration->getTable() . " SET ";
        $query .= $this->extractArray($configuration->getValues());

        if ($configuration->getConditions()) {
            $query .= " WHERE ";
            $query .= $this->extractArray($configuration->getConditions());
        }

        $this->getDatabaseRunner()->run($query);
    }

    private function extractArray($fields, $seperator = ", ")
    {
        $values = [];

        foreach ($fields as $field => $value) {
            $definition = "" . $field . " = ";
            if (is_string($value)) {
                $definition .= "'" . $value . "'";
            }
            if (is_numeric($value)) {
                $definition .=  $value;
            }
            $values[] = $definition;
        }

        return implode($seperator, $values);
    }

    protected function getDatabaseRunner()
    {
        return Factory::getInstance()->getDatabaseCommand();
    }
}