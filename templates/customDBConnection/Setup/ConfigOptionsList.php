<?php
/**
 * ConfigOptionsList
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\Config\Data\ConfigData;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\Setup\ConfigOptionsListInterface;
use Magento\Framework\Setup\Option\TextConfigOption;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\ConfigOptionsListConstants;
use Magento\Setup\Model\ConfigGenerator;
use Magento\Setup\Validator\DbValidator;
use Zend\ServiceManager\Di\DiAbstractServiceFactory;
use Zend\ServiceManager\ServiceManager;

class ConfigOptionsList implements ConfigOptionsListInterface
{
    const DB_CONNECTION_NAME = '${connectionname}';
    const CONFIG_PATH_DB_CONNECTION = ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTIONS . '/' . self::DB_CONNECTION_NAME;
    const OPTION_DB_HOST = self::DB_CONNECTION_NAME . '-db-host';
    const OPTION_DB_NAME = self::DB_CONNECTION_NAME . '-db-name';
    const OPTION_DB_USER = self::DB_CONNECTION_NAME . '-db-user';
    const OPTION_DB_PASSWORD = self::DB_CONNECTION_NAME . '-db-password';
    const OPTION_DB_ENGINE = self::DB_CONNECTION_NAME . '-db-engine';
    const OPTION_DB_INIT_STATEMENTS = self::DB_CONNECTION_NAME . '-db-init-statements';

    const OPTIONAL_OPTIONS = [
        ConfigOptionsListConstants::KEY_HOST => self::OPTION_DB_HOST,
        ConfigOptionsListConstants::KEY_NAME => self::OPTION_DB_NAME,
        ConfigOptionsListConstants::KEY_USER => self::OPTION_DB_USER,
        ConfigOptionsListConstants::KEY_PASSWORD => self::OPTION_DB_PASSWORD,
        ConfigOptionsListConstants::KEY_ENGINE => self::OPTION_DB_ENGINE,
        ConfigOptionsListConstants::KEY_INIT_STATEMENTS => self::OPTION_DB_INIT_STATEMENTS,
    ];

    protected $configGenerator;
    protected $dbValidator;

    public function __construct(
        ConfigGenerator $configGenerator,
        DbValidator $dbValidator,
        ServiceManager $serviceLocator,
        DiAbstractServiceFactory $abstractServiceFactory
    ) {
        $this->configGenerator = $configGenerator;
        $this->dbValidator = $dbValidator;
        $this->fixDBValidatorErrorGettingInstanceOfLoggerQuiet($serviceLocator, $abstractServiceFactory);
    }

    protected function fixDBValidatorErrorGettingInstanceOfLoggerQuiet(
        ServiceManager $serviceLocator,
        DiAbstractServiceFactory $abstractServiceFactory
    ) {
        $serviceLocator->addAbstractFactory($abstractServiceFactory);
    }

    public function getOptions()
    {
        return [
            new TextConfigOption(
                self::OPTION_DB_HOST,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_HOST,
                'Database host (Connection name: ${Connectionname})',
                'localhost'
            ),
            new TextConfigOption(
                self::OPTION_DB_NAME,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_NAME,
                'Database name (Connection name: ${Connectionname})',
                'magento2_${connectionname}'
            ),
            new TextConfigOption(
                self::OPTION_DB_USER,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_USER,
                'Database username (Connection name: ${Connectionname})',
                'root'
            ),
            new TextConfigOption(
                self::OPTION_DB_PASSWORD,
                TextConfigOption::FRONTEND_WIZARD_PASSWORD,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_PASSWORD,
                'Database password (Connection name: ${Connectionname})',
                ''
            ),
            new TextConfigOption(
                self::OPTION_DB_ENGINE,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_ENGINE,
                'Database engine (Connection name: ${Connectionname})',
                'innodb'
            ),
            new TextConfigOption(
                self::OPTION_DB_INIT_STATEMENTS,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_INIT_STATEMENTS,
                'Database initial set of commands (Connection name: ${Connectionname})',
                'SET NAMES utf8;'
            ),
        ];
    }

    public function createConfig(array $data, DeploymentConfig $deploymentConfig)
    {
        $configData = new ConfigData(ConfigFilePool::APP_ENV);

        foreach (self::OPTIONAL_OPTIONS as $configSubPath => $option) {
            if (isset($data[$option])) {
                $configData->set(
                    self::CONFIG_PATH_DB_CONNECTION . '/' . $configSubPath,
                    $data[$option]
                );
            }
        }
        $activeConfigPath = self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_ACTIVE;
        if ($deploymentConfig->get($activeConfigPath) === null) {
            $configData->set($activeConfigPath, '1');
        }

        return [$configData];
    }

    /**
     * @param array $options
     * @param DeploymentConfig $deploymentConfig
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(array $options, DeploymentConfig $deploymentConfig) //@codingStandardsIgnoreLine
    {
        if (!$options[ConfigOptionsListConstants::INPUT_KEY_SKIP_DB_VALIDATION]) {
            try {
                $this->dbValidator->checkDatabaseConnection(
                    $options[self::OPTION_DB_NAME],
                    $options[self::OPTION_DB_HOST],
                    $options[self::OPTION_DB_USER],
                    $options[self::OPTION_DB_PASSWORD]
                );
            } catch (\Exception $e) {
                $errors = [
                    sprintf('Error validating DB connection name: "%s"', self::DB_CONNECTION_NAME),
                    $e->getMessage()
                ];
                return $errors;
            }
        }
        return [];
    }
}
