<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%review}}`.
 */
class m220819_063809_add_author_id_column_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('review', 'author_id', $this->integer());

        $this->addForeignKey(
            'fk-review-author_id',
            'review',
            'author_id',
            'user',
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
            'fk-review-author_id',
            'review',
        );

        $this->dropColumn('review', 'author_id');
    }
}
