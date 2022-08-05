<?php

use yii\db\Migration;

/**
 * Class m220803_082949_insert_data_to_category_table
 */
class m220803_082949_insert_data_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(
            "INSERT INTO category (name,icon) VALUES
            ( 'Курьерские услуги', 'man-running'),
            ( 'Уборка', 'clean'),
            ( 'Переезды', 'cargo'),
            ( 'Компьютерная помощь', 'computer'),
            ( 'Ремонт квартирный', 'roller'),
            ( 'Ремонт техники', 'repair'),
            ( 'Красота', 'hairdryer'),
            ( 'Фото', 'camera')"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220803_082949_insert_data_to_category_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220803_082949_insert_data_to_category_table cannot be reverted.\n";

        return false;
    }
    */
}
