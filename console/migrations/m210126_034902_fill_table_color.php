<?php

use yii\db\Migration;

/**
 * Class m210126_034902_fill_table_color
 */
class m210126_034902_fill_table_color extends Migration
{
    private $table = 'color';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert($this->table, ['name', 'code_name', 'value'], [
            ['красный', 'red', '#f00'],
            ['жёлтый', 'yellow', '#ff0'],
            ['зелёный', 'green', '#0f0'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->table);
    }
}
