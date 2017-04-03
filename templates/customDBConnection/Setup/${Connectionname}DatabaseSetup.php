<?php
/**
 * ${Connectionname}DatabaseSetup
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use ${Vendorname}\${Modulename}\Setup\ConfigOptionsList as ${Modulename}SetupConfig;

class ${Connectionname}DatabaseSetup
{

    protected $connection;

    public function __construct(SchemaSetupInterface $setup)
    {
        $this->connection = $setup->getConnection(${Modulename}SetupConfig::DB_CONNECTION_NAME);
    }

    public function setupTables()
    {
        $tablesToCreate = $this->getTablesToCreate();
        $this->createTables($tablesToCreate);
    }

    /**
     * @return Table[]
     */
    protected function getTablesToCreate() : array
    {
        $tables = [];
//        $tables[] = $this->connection
//            ->newTable($this->connection->getTableName('some_table_name'))
//            ->addColumn('id', Table::TYPE_INTEGER, 11, ['nullable' => false, 'primary' => true])
//            ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false]);

        return $tables;
    }

    protected function createTables(array $tables)
    {
        foreach ($tables as $table) {
            $this->dropTableIfExists($table->getName());
            $this->connection->createTable($table);
        }
    }

    protected function dropTableIfExists(string $tableName)
    {
        if ($this->connection->isTableExists($this->connection->getTableName($tableName))) {
            $this->connection->dropTable($this->connection->getTableName($tableName));
        }
    }
}
