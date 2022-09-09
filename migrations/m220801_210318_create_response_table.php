<?php

use yii\db\Migration;

/**
 * -- отклики на задания
 * Handles the creation of table `{{%response}}`.
 */
class m220801_210318_create_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%response}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'comment' => $this->string()->null(),
            'create_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'price' => $this->integer()->null(),
            'is_blocked' => $this->boolean()->defaultValue(0)
        ]);

        /**
         * FK for task
         */
        $this->addForeignKey(
            'response_fk_task_id',
            'response',
            'task_id',
            'task',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * FK for performer
         */
        $this->addForeignKey(
            'response_fk_user_id',
            'response',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('response_fk_user_id', 'response');

        $this->dropForeignKey('response_fk_task_id', 'response');

        $this->dropTable('{{%response}}');
    }
}
