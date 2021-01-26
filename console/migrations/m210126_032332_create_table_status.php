<?php

use common\dictionaries\AppleStatus;
use yii\db\Migration;

/**
 * Class m210126_032332_create_table_status
 */
class m210126_032332_create_table_status extends Migration
{
    private $table = 'status';

    private function fillTable()
    {
        $this->batchInsert($this->table, ['id', 'name'], [
            [AppleStatus::TREE, 'висит на дереве'],
            [AppleStatus::GROUND, 'упало на землю'],
            [AppleStatus::ROTTEN, 'испорчено'],
        ]);
    }

    private function makeTable()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(63)->notNull()->comment('Наименование'),
        ], 'COMMENT "Состояния яблок"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->makeTable();
        $this->fillTable();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
