<?php

use yii\db\Migration;

/**
 * -- связь категорий работ и категорий исполнителей
 * Handles the creation of table `{{%user_category}}`.
 *
 */
class m220802_065234_create_junction_table_for_user_and_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_category', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-user_category-user_id',
            'user_category',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_category-category_id',
            'user_category',
            'category_id',
            'category',
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
            'fk-user_category-user_id',
            'user_category'
        );

        $this->dropForeignKey(
            'fk-user_category-category_id',
            'user_category'
        );


        $this->dropTable('user_category');
    }
}
