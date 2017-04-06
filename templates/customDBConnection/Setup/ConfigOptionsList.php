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
use Magento\Setup\Exception as SetupException;
use Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactory;

class ConfigOptionsList implements ConfigOptionsListInterface
{
    const DB_CONNECTION_NAME = '${connectionname}';
    const DB_CONNECTION_SETUP = self::DB_CONNECTION_NAME;
    const CONFIG_PATH_DB_CONNECTION = ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTIONS . '/' . self::DB_CONNECTION_NAME;
    const CONFIG_PATH_RESOURCE_SETUP = ConfigOptionsListConstants::CONFIG_PATH_RESOURCE . '/' . self::DB_CONNECTION_SETUP . '/connection';
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

    protected $connectionFactory;

    public function __construct(
        ConnectionFactory $connectionFactory
    ) {
        $this->connectionFactory = $connectionFactory;
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

    public function createConfig(array $options, DeploymentConfig $deploymentConfig)
    {
        $configData = new ConfigData(ConfigFilePool::APP_ENV);

        $dbConfig = $this->getDbConfig($options, $deploymentConfig);
        foreach ($dbConfig as $configSubPath => $configValue) {
            $configData->set(self::CONFIG_PATH_DB_CONNECTION . '/' . $configSubPath, $configValue);
        }

        if ($deploymentConfig->get(self::CONFIG_PATH_RESOURCE_SETUP) === null) {
            $configData->set(self::CONFIG_PATH_RESOURCE_SETUP, self::DB_CONNECTION_NAME);
        }

        return [$configData];
    }

    protected function getDbConfig(array $options, DeploymentConfig $deploymentConfig) : array
    {
        $dbConfig = [];
        foreach (self::OPTIONAL_OPTIONS as $configSubPath => $option) {
            if ($options[$option] === null) {
                $options[$option] = $deploymentConfig->get(self::CONFIG_PATH_DB_CONNECTION . '/' . $configSubPath);
            }
            $dbConfig[$configSubPath] = $options[$option];
        }

        $activeConfigPath = self::CONFIG_PATH_DB_CONNECTION . '/' . ConfigOptionsListConstants::KEY_ACTIVE;
        $dbConfig[ConfigOptionsListConstants::KEY_ACTIVE] = $deploymentConfig->get($activeConfigPath)??'1';

        return $dbConfig;
    }

    public function validate(array $options, DeploymentConfig $deploymentConfig)
    {
        if (!$options[ConfigOptionsListConstants::INPUT_KEY_SKIP_DB_VALIDATION]) {
            try {
                $dbConfig = $this->getDbConfig($options, $deploymentConfig);
                $this->checkDatabaseConnection($dbConfig);
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

    /**
     * @param array $dbConfig
     * @return bool
     * @throws SetupException
     */
    protected function checkDatabaseConnection(array $dbConfig)
    {
        $connection = $this->connectionFactory->create($dbConfig);
        $dbName = $dbConfig[ConfigOptionsListConstants::KEY_NAME];

        $accessibleDbs = $connection
            ->query("SHOW DATABASES")
            ->fetchAll(\PDO::FETCH_COLUMN, 0); //@codingStandardsIgnoreLine
        if (in_array($dbName, $accessibleDbs)) {
            return true;
        }

        throw new SetupException(
            sprintf("Database '%s' does not exist or user does not have privileges to access this database.", $dbName)
        );
    }
}
