<?php

use yii\db\Migration;

/**
 * -- таблица городов
 * Handles the creation of table `{{%city}}`.
 */
class m220801_105002_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'lat' => $this->decimal(11,8)->notNull(),
            'lng' => $this->decimal(11,8)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
