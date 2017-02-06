<?php
/**
 * UpdateSelfCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\UniversalGenerator\Command\AbstractCommand;
use Staempfli\UniversalGenerator\Helper\FileHelper;
use Humbug\SelfUpdate\Updater as PharUpdater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends AbstractCommand
{
    /**
     * @var FileHelper
     */
    protected $fileHelper;
    /**
     * @var PharUpdater
     */
    protected $updater;

    /**
     * SelfUpdateCommand constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->fileHelper = new FileHelper();
        $this->updater = new PharUpdater(null, false, PharUpdater::STRATEGY_GITHUB);
        parent::__construct($name);
    }

    public function configure()
    {
        $applicationFileName = $this->fileHelper->getApplicationFileName();
        $this->setDescription(sprintf('Updates "%s" to the latest stable version', $applicationFileName))
            ->setHelp(<<<EOT

The <info>self-update</info> command checks github for newer
versions of {$applicationFileName} and if found, installs the latest.

<info>php {$applicationFileName} self-update</info>

EOT
            );
    }

    /**
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
        $this->updater->getStrategy()->setPackageName('staempfli/magento2-code-generator');
        $this->updater->getStrategy()->setPharName('mg2-codegen.phar');
        $this->updater->getStrategy()->setCurrentLocalVersion('@git-version@');

        try {
            $result = $this->updater->update();
            if ($result) {
                $newVersion = $this->updater->getNewVersion();
                $oldVersion = $this->updater->getOldVersion();
                $this->io->success(sprintf('Updated to version %s from %s', $newVersion, $oldVersion));
            } else {
                $this->io->writeln('<info>No update needed!</info>');
            }
        } catch (\Exception $e) {
            $this->io->error('There was an error while updating. Please try again later');
        }
    }

}