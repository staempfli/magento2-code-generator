<?php
/**
 * UpdateSelfCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\UniversalGenerator\Helper\FileHelper;
use Symfony\Component\Console\Command\Command;
use Humbug\SelfUpdate\Updater as PharUpdater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SelfUpdateCommand extends Command
{
    /**
     * Default command name is none is set
     *
     * @var string
     */
    protected $defaultName = 'self-update';
    /**
     * @var FileHelper
     */
    protected $fileHelper;

    /**
     * SelfUpdateCommand constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->fileHelper = new FileHelper();
        parent::__construct($name);
    }

    /**
     * Command configuration
     */
    public function configure()
    {
        if (!$this->getName()) {
            $this->setName($this->defaultName);
        }

        $this->setDescription(sprintf('Updates %s to the latest stable version', $this->fileHelper->getCommandName()))
            ->setHelp(<<<EOT

The <info>self-update</info> command checks github for newer
versions of {$this->fileHelper->getCommandName()} and if found, installs the latest.

<info>php {$this->fileHelper->getCommandName()} self-update</info>

EOT
            );
    }

    /**
     * This command is only enable for .phar
     *
     * @return bool
     */
    public function isEnabled()
    {
        $pharFilePath = $this->fileHelper->getPharPath();
        if ($pharFilePath) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $updater = new PharUpdater(null, false, PharUpdater::STRATEGY_GITHUB);
        $updater->getStrategy()->setPackageName('staempfli/magento2-code-generator');
        $updater->getStrategy()->setPharName('mg2-codegen.phar');
        $updater->getStrategy()->setCurrentLocalVersion('@git_version@');

        try {
            $result = $updater->update();
            if ($result) {
                $newVersion = $updater->getNewVersion();
                $oldVersion = $updater->getOldVersion();
                $io->success(sprintf('Updated to version %s from %s', $newVersion, $oldVersion));
            } else {
                $io->writeln('<info>No update needed!</info>');
            }
        } catch (\Exception $e) {
            $io->error('There was an error while updating. Please try again later');
        }
    }

}