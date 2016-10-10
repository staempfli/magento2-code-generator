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
        $packageName = $this->getComposerPackageName();
        $pharFilename = $this->getPharFilename();
        if (!$packageName) {
            $io->error('Package name not found. Please ensure that the composer.json file format is correct.');
        }

        if (!$pharFilename) {
            $io->error('Phar filename not found. Please ensure that you have a box.json file with "output" param.');
        }

        $updater = new PharUpdater(null, false, PharUpdater::STRATEGY_GITHUB);
        $updater->getStrategy()->setPackageName($packageName);
        $updater->getStrategy()->setPharName($packageName);
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

    /**
     * Get package name from composer file
     *
     * @return bool|string
     */
    protected function getComposerPackageName()
    {
        $composerDecoded = json_decode(file_get_contents($this->fileHelper->getProjectBaseDir() . '/composer.json'), true);
        if (isset($composerDecoded['name']))
        {
            return $composerDecoded['name'];
        }

        return false;
    }

    /**
     * Get Phar filename from box.json configuration
     *
     * @return bool|string
     */
    protected function getPharFilename()
    {
        $boxDecoded = json_decode(file_get_contents($this->fileHelper->getProjectBaseDir() . '/box.json'), true);
        if (isset($boxDecoded['output']))
        {
            return $boxDecoded['output'];
        }
        return false;
    }

}