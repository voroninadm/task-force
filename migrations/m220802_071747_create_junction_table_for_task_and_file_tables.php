<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_file}}`.
 */
class m220802_071747_create_junction_table_for_task_and_file_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task_file', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'file_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-task_file-task_id',
            'task_file',
            'task_id',
            'task',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-task_file-file_id',
            'task_file',
            'file_id',
            'file',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-task_file-task_id',
            'task_file'
        );

        $this->dropForeignKey(
            'fk-task_file-file_id',
            'task_file'
        );

        $this->dropTable('task_file');
    }
}
