<?php

use yii\db\Migration;

/**
 * -- отзывы на задания
 * Handles the creation of table `{{%review}}`.
 */
class m220801_205508_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'create_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'grade' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull()
        ]);

        /**
         * FK to task
         */
        $this->addForeignKey(
            'review_fk_task_id',
            'review',
            'task_id',
            'task',
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
        $this->dropForeignKey('review_fk_task_id', 'review');

        $this->dropTable('{{%review}}');
    }
}
