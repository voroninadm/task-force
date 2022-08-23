<?php

use yii\db\Migration;

/**
 * -- таблица пользователей
 * Handles the creation of table `{{%user}}`.
 */
class m220801_194528_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'birth_date' => $this->timestamp()->null(),
            'city_id' => $this->integer()->notNull(),
            'reg_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'avatar_file_id' => $this->integer()->null(),
            'email' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'phone' => $this->string()->Null(),
            'telegram' => $this->string()->Null(),
            'done_task' => $this->integer()->null(),
            'failed_task' => $this->integer()->null(),
            'rating' => $this->decimal()->null(),
            'is_performer' => $this->boolean()->notNull(),
            'is_private' => $this->boolean()->defaultValue(0),
            'is_busy' => $this->boolean()->notNull()->defaultValue(0)
        ]);

        $this->createIndex(
            'user_email',
            'user',
            'email',
            true);

        $this->addForeignKey(
            'user_fk_city_id',
            'user',
            'city_id',
            'city',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey(
            'user_fk_avatar_file_id',
            'user',
            'avatar_file_id',
            'file',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_fk_avatar_file_id', 'user');

        $this->dropForeignKey('user_fk_city_id', 'user');

        $this->dropIndex('user_email', 'user');

        $this->dropTable('{{%user}}');
    }
}
