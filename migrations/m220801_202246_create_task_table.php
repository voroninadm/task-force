<?php

use yii\db\Migration;

/**
 * -- таблица задач
 * Handles the creation of table `{{%task}}`.
 */
class m220801_202246_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'public_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'address' => $this->string()->null(),
            'lat' => $this->decimal(11,8)->null(),
            'lng' => $this->decimal(11,8)->null(),
            'price' => $this->integer()->null(),
            'deadline' => $this->date()->null(),
            'customer_id' => $this->integer()->notNull(),
            'performer_id' => $this->integer()->null()
        ]);

        /**
         * FK for category of task
         */
        $this->addForeignKey(
            'task_fk_category_id',
            'task',
            'category_id',
            'category',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * FK for task customer
         */
        $this->addForeignKey(
            'task_fk_customer_id',
            'task',
            'customer_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * FK for task performer
         */
        $this->addForeignKey(
            'task_fk_performer_id',
            'task',
            'performer_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * FK for city of task
         */
        $this->addForeignKey(
            'task_fk_city_id',
            'task',
            'city_id',
            'city',
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
        $this->dropForeignKey('task_fk_city_id', 'task');

        $this->dropForeignKey('task_fk_performer_id', 'task');

        $this->dropForeignKey('task_fk_customer_id', 'task');

        $this->dropForeignKey('task_fk_category_id', 'task');

        $this->dropTable('{{%task}}');
    }
}
