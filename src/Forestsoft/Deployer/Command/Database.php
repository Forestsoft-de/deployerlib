<?php

namespace Forestsoft\Deployer\Command;


class Database extends Command
{

    public function run($command)
    {
        if ($this->_deployer->has("app.mysql.defaults_file")) {
            $defaults = "--defaults-file=".$this->_deployer->get("app.mysql.defaults_file");
        } else {
            $defaults = "";
        }
        parent::run("mysql " . $defaults . " -h" . $this->_deployer->get("app.mysql.host") . " -u" . $this->_deployer->get("app.mysql.user") . " -P" . $this->_deployer->get("app.mysql.port") . " -p'" . $this->_deployer->get("app.mysql.password") . "' " . $this->_deployer->get("app.mysql.database") . " -e \"" . $command . "\" ");
        $this->_deployer->writeln(sprintf("<info>✔</info> %s@%s ON %s <fg=green>%s</>", $this->_deployer->get("app.mysql.user"), $this->_deployer->get("app.mysql.host"),  $this->_deployer->get("app.mysql.database"),  $command));
    }
}