<?php

use yii\db\Migration;

/**
 * Class m210126_041933_create_table_apple
 */
class m210126_041933_create_table_apple extends Migration
{
    private $table = 'apple';

    private $refs = [
        'color_id' => ['color', 'id'],
        'status_id' => ['status', 'id'],
    ];

    private function dropForeignKeys()
    {
        foreach (array_keys($this->refs) as $column) {
            $this->dropForeignKey($this->fkName($column), $this->table);
        }
    }

    private function dropIndexes()
    {
        foreach (array_keys($this->refs) as $column) {
            $this->dropIndex($this->indexName($column), $this->table);
        }
    }

    private function fkName(string $column): string
    {
        return "fk_{$this->table}_{$column}";
    }

    private function indexName(string $column): string
    {
        return "ix_{$this->table}_{$column}";
    }

    private function makeForeignKeys()
    {
        $on = 'RESTRICT';
        foreach ($this->refs as $column => $ref) {
            $this->addForeignKey($this->fkName($column), $this->table, $column, $ref[0], $ref[1], $on, $on);
        }
    }

    private function makeIndexes()
    {
        foreach (array_keys($this->refs) as $column) {
            $this->createIndex($this->indexName($column), $this->table, $column);
        }
    }

    private function makeTable()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'color_id' => $this->integer()->notNull()->comment('ID цвета'),
            'status_id' => $this->integer()->notNull()->comment('ID состояния'),
            'appear_at' => $this->timestamp()->notNull()->comment('Дата появления'),
            'fall_at' => $this->timestamp()->null()->comment('Дата падения'),
            'eaten_percent' => $this->double()->notNull()->defaultValue(0)->comment('Процент съеденного'),
        ], 'COMMENT "Яблоки"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->makeTable();
        $this->makeIndexes();
        $this->makeForeignKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKeys();
        $this->dropIndexes();
        $this->dropTable($this->table);
    }
}
