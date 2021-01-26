<?php

use yii\db\Migration;

/**
 * Class m210126_032323_create_table_color
 */
class m210126_032323_create_table_color extends Migration
{
    private $table = 'color';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(63)->notNull()->comment('Наименование'),
            'code_name' => $this->string(31)->notNull()->comment('Кодовое название'),
            'value' => $this->string(31)->notNull()->comment('Значение'),
        ], 'COMMENT "Цвета яблок"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
