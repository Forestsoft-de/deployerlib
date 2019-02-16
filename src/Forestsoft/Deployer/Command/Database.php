<?php

namespace Forestsoft\Deployer\Command;


class Database extends Command implements DatabaseCommand
{

    public $cliBin = "mysql";

    public function run($command)
    {
        $opts = $this->getOpts();
        parent::run($this->cliBin . " " . $opts . " -e \"" . $command . "\"");
        $this->_deployer->writeln(sprintf("<info>✔</info> %s@%s ON %s <fg=green>%s</>", $this->_deployer->get("app.mysql.user"), $this->_deployer->get("app.mysql.host"),  $this->_deployer->get("app.mysql.database"),  $command));
    }

    /**
     * @param string $sqlFile
     */
    public function import(array $sqlFiles)
    {
        $opts = $this->getOpts();

        foreach ($sqlFiles as $sqlFile) {
            if (!file_exists($sqlFile)) {
                throw new \InvalidArgumentException(sprintf("The sql file %s to import does not exist", $sqlFile));
            }
            if (!$this->_deployer->isLocal()) {
                $this->_deployer->upload($sqlFile, "/tmp/" . basename($sqlFile));
            }
            try {
                parent::run($this->cliBin . " " . $opts . " < " . $sqlFile);
            } catch (\Exception $e) {
                throw $e;
            } finally {
                if (!$this->_deployer->isLocal()) {
                    parent::run("rm -f /tmp/" . basename($sqlFile));
                }
            }

            $this->_deployer->writeln(sprintf("<info>✔</info> %s sucessfully imported to %s@%s ON %s", $sqlFile, $this->_deployer->get("app.mysql.user"), $this->_deployer->get("app.mysql.host"),  $this->_deployer->get("app.mysql.database")));
        }
    }

    protected function getOpts()
    {
        if ($this->_deployer->has("app.mysql.defaults_file")) {
            $defaults = "--defaults-file=".$this->_deployer->get("app.mysql.defaults_file");
        } else {
            $defaults = "";
        }

        $opts = $defaults . " -h" . $this->_deployer->get("app.mysql.host") . " -u" . $this->_deployer->get("app.mysql.user") . " -P" . $this->_deployer->get("app.mysql.port") . " -p'" . $this->_deployer->get("app.mysql.password") . "' " . $this->_deployer->get("app.mysql.database");

        return trim($opts);

    }
}