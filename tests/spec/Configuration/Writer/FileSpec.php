<?php

namespace spec\Forestsoft\Deployer\Configuration\Writer;

use Deployer\Deployer;
use Deployer\Task\Context;
use Forestsoft\Deployer\Configuration\Configurator;
use Forestsoft\Deployer\Configuration\Writer\File;
use Forestsoft\Deployer\Factory;
use org\bovigo\vfs\vfsStream;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class FileSpec extends ObjectBehavior
{
    function it_is_initializable(Configurator $deployer)
    {
        $this->beConstructedWith($deployer);
        $this->shouldHaveType(File::class);
    }

    function it_should_replace_config_placeholder()
    {
        $this->beConstructedThrough(array($this, 'createFileWriter'));

        $root = vfsStream::setup('configFiles');
        vfsStream::newFile('config.yml', 0777)->withContent('base_url: {{app.base_url}}')->at($root);

        $this->addFiles([vfsStream::url('configFiles/config.yml')]);
        $this->write()->shouldWriteFileWithContent(vfsStream::url('configFiles/config.yml'), "base_url: http://dev.local");
    }

    public function getMatchers(): array
    {
        $matchers = parent::getMatchers(); // TODO: Change the autogenerated stub

        $custom = [
        'writeFileWithContent' => function ($subject, $file, $content) {
                $writtenContent = file_get_contents($file);
                if (!stristr($writtenContent, $content)) {
                    throw new FailureException(sprintf(
                        'Content %s is not written in file %s',
                        $content, $file
                    ));
                }
                return true;
            }
        ];

        return array_merge($matchers, $custom);
    }

    public function createFileWriter()
    {
        $deployerLib = Factory::getInstance();
        $deployerLib->init();
        $hosts = Deployer::get()->hostSelector->getByHostnames('dev.local');

        foreach ($hosts as $host) {
            Context::push(new Context($host, new ArgvInput(), new BufferedOutput()));
        }

        return $deployerLib->getConfigFileWriter();

    }
}
