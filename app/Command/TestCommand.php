<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class TestCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('demo:command');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
        $this->setHelp('Hyperf 自定义命令演示');
        $this->addArgument('name', InputArgument::OPTIONAL, '姓名', 'Hyperf');
//        $this->addArgument('name', InputArgument::IS_ARRAY, '姓名');
        $this->addOption('opt', 'o', InputOption::VALUE_NONE, '是否优化');
        $this->addUsage('--o 演示代码');
    }

    public function handle()
    {
        $this->line("Hello {$this->input->getArgument('name')}!", 'info');
        $this->line($this->input->getOption('opt'));
//        $money = $this->ask('是否有钱', 'y/n');
//        $this->line($money == 'y' ? '有钱任性' : '没钱认命');
    }

}
